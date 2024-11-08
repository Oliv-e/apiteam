<?php

namespace App\Http\Controllers\Api\Arsip;

use App\Http\Controllers\Api\BaseController;
use App\Models\Dokumen;
use App\Models\MarkedDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArsipController extends BaseController
{
    // display dashboard admin
    public function getDokumen(){
        $data = Dokumen::all();
        return $this->SendResponse($data,'Sukses mengambil data');
    }
    
    // display dashboard dosen
    public function dashboard_dosen(Request $request)
    {
        $nip = Auth::user()->id;
        
        // Ambil data dari tabel MarkedDokumen yang dijoin dengan tabel dokumen berdasarkan id_dokumen
        $data = MarkedDokumen::join('dokumen', 'marked_dokumen.id_dokumen', '=', 'dokumen.id')
            ->where('marked_dokumen.nip', $nip)
            ->select(
                'marked_dokumen.id as id', 
                'dokumen.title', 
                'dokumen.deskripsi', 
                'dokumen.no_surat', 
                'dokumen.tanggal_surat', 
                'dokumen.kategori', 
                'dokumen.jenis'
            )
            ->get();
    
        if ($data->isEmpty()) {
            return $this->sendError('Dokumen tidak ditemukan');
        }
    
        // Kembalikan data yang sudah difilter dan diambil
        return $this->sendResponse($data, 'Sukses mengambil data');
    }

    
    // display data dokumen by id
    public function dokumenId($id, Request $request)
    {
        $nip = Auth::user()->id;
    
        // Ambil data dengan join antara MarkedDokumen dan Dokumen berdasarkan nip dan id
        $data = MarkedDokumen::join('dokumen', 'marked_dokumen.id_dokumen', '=', 'dokumen.id')
            ->where('marked_dokumen.nip', $nip)
            ->where('marked_dokumen.id', $id)
            ->select(
                'marked_dokumen.id as id',
                'dokumen.title', 
                'dokumen.deskripsi', 
                'dokumen.no_surat', 
                'dokumen.tanggal_surat', 
                'dokumen.kategori', 
                'dokumen.jenis', 
                'dokumen.tahun_akademik', 
                'dokumen.filepath'
            )
            ->first();
    
        // Jika tidak ditemukan, kembalikan error
        if (!$data) {
            return $this->sendError('Dokumen tidak ditemukan atau Anda tidak memiliki akses');
        }
    
        // Kembalikan data dokumen yang ditemukan
        return $this->sendResponse($data, 'Sukses mengambil data dokumen yang di-klik');
    }


    
    // hapus dokumen yg ditandai
    public function hapus_dokumen($id) {
        $nip = Auth::user()->id;
        
        // Cari data marked dokumen berdasarkan id
        $markedDokumen = MarkedDokumen::find($id);
    
        // Jika data tidak ditemukan, berikan respons error
        if (!$markedDokumen) {
            return $this->sendError('Marked Dokumen tidak ditemukan');
        }
    
        // Hapus data marked dokumen
        $markedDokumen->delete();
    
        // Berikan respons sukses setelah penghapusan
        return $this->sendResponse([], 'Marked Dokumen berhasil dihapus');
    }

    public function getDokumenById($id) {
        $dokumen = Dokumen::where('id', $id)->get();

        return response()->json(['data'=> $dokumen, 'message'=> 'Sukses mengambil data'], 200);
    }
    
    public function getDokumenDitandai(){
        $id_dosen = Auth::user()->id;
        $data = markeddokumen::where('nip', $id_dosen)->get();
        return response()->json(['data' => $data, 'message' => 'Sukses mengambil data'], 200);
    }
    
    public function getDokumenFilter($id){

        // Ambil dokumen yang sesuai dengan id_kategori dari tabel Dokumen
            $dokumen = Dokumen::where('id_kategori', $id)->get();

        // Cek apakah ada dokumen yang ditemukan
            if ($dokumen->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada dokumen yang ditemukan untuk kategori ini.'
                ], 404);
            }

        // Kembalikan respon sukses dengan data dokumen yang ditemukan
            return response()->json([
                'success' => true,
                'data' => $dokumen
            ], 200);
    }
    public function GetDokumenNama($title){
        // Ambil dokumen yang sesuai dengan id_kategori dari tabel Dokumen
            $dokumen = Dokumen::where('title', 'like', $title)->get();

        // Cek apakah ada dokumen yang ditemukan
            if ($dokumen->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada dokumen yang ditemukan untuk kategori ini.'
                ], 404);
            }

        // Kembalikan respon sukses dengan data dokumen yang ditemukan
            return response()->json([
                'success' => true,
                'data' => $dokumen
            ], 200);
    }
    public function getDokumenDownload($id)
    {
        // Cari dokumen berdasarkan ID
        $dokumen = Dokumen::find($id);
    
        // Cek apakah dokumen ditemukan
        if (!$dokumen) {
            return response()->json(['message' => 'Dokumen tidak ditemukan.'], 404);
        }
    
        // Ambil file path dari dokumen
        $filePath = $dokumen->filepath; // Ensure this matches the actual property name
    
        // Cek apakah file benar-benar ada di storage
        if (!Storage::disk('public')->exists($filePath)) {
            return response()->json(['message' => 'File tidak ditemukan.'], 404);
        }
    
        // Mengirimkan file ke client untuk didownload
        return Storage::disk('public')->download($filePath, $dokumen->title . '.' . pathinfo($filePath, PATHINFO_EXTENSION));
    }
    public function ByKategoriJenis($kategori, $jenis) {
        if ($kategori == 'semua' && $jenis == 'semua') {
            $data = Dokumen::all();
        } else if ($kategori != 'semua' && $jenis == 'semua') {
            $data = Dokumen::where('kategori' , $kategori)->get();
        } else if ($kategori == 'semua' && $jenis != 'semua') {
            $data = Dokumen::where('jenis' , $jenis)->get();
        } else {
            $data = Dokumen::where('kategori', $kategori)->where('jenis', $jenis)->get();
        }
        return $this->SendResponse($data,'Sukses mengambil data');
    }

    // POST SECTION
    public function setDokumen(Request $request){
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'no_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'kategori' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'tahun_akademik' => 'required|string|max:255',
            'filepath' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // Add file validation
        ]);
        
        if ($request->hasFile('filepath')) {
            $file = $request->file('filepath');
            // Store the file and get the path
            $filepath = $file->store('uploads', 'public'); // Store in 'storage/app/public/uploads'
        } else {
            $filepath = null;
        }

        $res = Dokumen::create([
            'title' => $data['title'],
            'deskripsi' => $data['deskripsi'],
            'no_surat' => $data['no_surat'],
            'tanggal_surat' => $data['tanggal_surat'],
            'kategori' => $data['kategori'],
            'jenis' => $data['jenis'],
            'tahun_akademik' => $data['tahun_akademik'],
            'filepath' => $filepath,
        ]);

        return $this->sendResponse($res, 'Sukses Memuat Data!');
    }
    public function setDokumenUpdate(Request $request, $id)
    {
        // Cari dokumen berdasarkan ID
        $dokumen = Dokumen::find($id);
    
        // Jika dokumen tidak ditemukan, berikan respons 404
        if (!$dokumen) {
            return response()->json(['message' => 'Dokumen tidak ditemukan'], 404);
        }
    
        // Validasi input hanya untuk memastikan field yang diperlukan ada
        $request->validate([
            'title' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'no_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'kategori' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'tahun_akademik' => 'required|string|max:255',
            'filepath' => 'sometimes|file|mimes:pdf,jpg,jpeg,png|max:2048', // Optional file validation
        ]);
    
        // Update data dokumen dengan input yang baru
        $dokumen->update([
            'title' => $request->title,
            'deskripsi' => $request->deskripsi,
            'no_surat' => $request->no_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'kategori' => $request->kategori,
            'jenis' => $request->jenis,
            'tahun_akademik' => $request->tahun_akademik,
        ]);
    
        // Handle file upload if provided
        if ($request->hasFile('filepath')) {
            $file = $request->file('filepath');
            // Store the file and get the path
            $filepath = $file->store('uploads', 'public'); // Store in 'storage/app/public/uploads'
            $dokumen->filepath = $filepath; // Update the filepath in the document
            $dokumen->save(); // Save the changes to the document
        }
    
        // Berikan respons sukses
        return response()->json(['data' => $dokumen, 'message' => 'Update data sukses'], 200);
    }
    public function setDokumenHapus($id)
    {
        // Cari dokumen berdasarkan id
        $dokumen = Dokumen::find($id);

        // Cek apakah dokumen ditemukan
        if (!$dokumen) {
            return $this->sendResponse([], 'Dokumen tidak ditemukan');
        }

        // Hapus dokumen
        $dokumen->delete();

        // Berikan respons sukses
        return $this->sendResponse([], 'Hapus data sukses');
    }
    public function setDokumenDitandai(Request $request){
        $data = $request->validate([
            'id_tandai'=> 'required',
            'id_user'=> 'required',
            'id_dokumen'=> 'required',
            'marked_at'=> 'required'
        ]);
        markeddokumen::create([
            'id_tandai'=>$request->id_tandai,
            'id_user'=>$request->id_user,
            'id_dokumen'=>$request->id_dokumen,
            'marked_at'=>$request->marked_at
        ]);
        return $this->sendResponse($data, 'Sukses Memuat Data!');
    }
}

// Menghapus fungsi pemanggilan yang tidak diperlukan
// Mengurutkan fungsi sesuai route
// Memisahkan get dan set agar lebih mudah dibaca
// Menyesuaikan nama kelas berdasarkan route
