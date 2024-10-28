<?php

namespace App\Http\Controllers\Api\Arsip;

use App\Http\Controllers\Api\BaseController;
use App\Models\Dokumen;
use App\Models\markeddokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArsipController extends BaseController
{
    // PR STORE GAMBAR --||__||--
    // GET SECTION
    public function getDokumen(){
        $data = Dokumen::select('id', 'id_admin','id_kategori','nama_kategori','judul', 'deskripsi', 'file_path', 'nomor_unik','upload_by')
        ->with([
            'admin'
        ])
        ->get();
        return $this->SendResponse($data,'Sukses mengambil data');
    }
    public function getDokumenSaya() {
        $user = Auth::user()->id;
        $dokumen = Dokumen::where('id_admin', $user)->get();

        return response()->json(['data'=> $dokumen, 'message'=> 'Sukses mengambil data'], 200);
    }
    public function getDokumenDitandai(){
        $data = markeddokumen::select('id', 'id_dosen', 'id_dokumen')->get();
        return $this->SendResponse($data, 'Sukses mengambil data');
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
    public function GetDokumenNama($id){

        // Ambil dokumen yang sesuai dengan id_kategori dari tabel Dokumen
            $dokumen = Dokumen::where('nama_kategori', $id)->get();

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
    public function getDokumenDownload($id){
        // Cari dokumen berdasarkan ID
            $dokumen = Dokumen::find($id);

        // Cek apakah dokumen ditemukan
                if (!$dokumen) {
                return $this->sendError('Dokumen tidak ditemukan.');
            }

        // Ambil file path dari dokumen
            $filePath = $dokumen->file_path;

        // Cek apakah file benar-benar ada di storage
            if (!Storage::exists($filePath)) {
                return $this->sendError('File tidak ditemukan.');
            }

        // Mengirimkan file ke client untuk didownload
            return Storage::download($filePath, $dokumen->judul . '.' . pathinfo($filePath, PATHINFO_EXTENSION));
    }

    // POST SECTION
    public function setDokumen(Request $request){
        $data = $request->validate([
            'id_admin' => 'required',
            'id_kategori' => 'required',
            'nama_kategori' => 'required',
            'judul' => 'required',
            'deskripsi' => 'required',
            'file_path' => 'required',
            'nomor_unik' => 'required',
            'upload_by' => 'required'
        ]);
        $file_path = $request->file('file_path')->store('dokumen');

        Dokumen::create([
            'id_admin' => $request->id_admin,
            'id_kategori' => $request->id_kategori,
            'nama_kategori' => $request->nama_kategori,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $request->file_path,
            'nomor_unik' => $request->nomor_unik,
            'upload_by' => $request->upload_by
        ]);
        return $this->sendResponse($data, 'Sukses Memuat Data!');
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
            'id_admin' => 'required | integer',
            'id_kategori' => 'required | integer',
            'nama_kategori' => 'required | string',
            'judul' => 'required | string',
            'deskripsi' => 'required | string',
            'file_path' => 'required |string',
            'nomor_unik' => 'required | integer',
            'upload_by' => 'required | string'
        ]);

        $dokumen = Dokumen::findOrFail($id);

        $dokumen->update([

        // Update data dokumen dengan input yang baru
        $dokumen->id_admin = $request->id_admin,
        $dokumen->id_kategori = $request->id_kategori,
        $dokumen->nama_kategori = $request->nama_kategori,
        $dokumen->judul = $request->judul,
        $dokumen->deskripsi = $request->deskripsi,
        $dokumen->file_path = $request->file_path,
        $dokumen->nomor_unik = $request->nomor_unik,
        $dokumen->upload_by = $request->upload_by,
        $dokumen->updated_at = now ()

        ]);
        // Simpan perubahan ke database
        $dokumen->save();

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
