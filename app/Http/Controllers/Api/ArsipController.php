<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Models\Dokumen;
use App\Models\StaffAdmin;
use App\Models\markeddokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ArsipController extends BaseController
{
    public function Dokumen(){
        $data = Dokumen::select('id', 'id_admin','id_kategori','nama_kategori','judul', 'deskripsi', 'file_path', 'nomor_unik','upload_by')
        ->with([
            'admin'
        ])
        ->get();
        return $this->SendResponse($data,'Sukses mengambil data');
    }
    public function StaffAdmin(){
        $data = StaffAdmin::select('id_admin','nama', 'no_hp')
        ->with([

        ])
        ->get();
        return $this->SendResponse($data,'Sukses mengambil data');
    }
    public function markeddokumen(){
        $data = markeddokumen::select('id_tandai', 'id_user', 'id_dokumen', 'marked_at')
        ->with([

        ])
        ->get();
        return $this->SendResponse($data, 'Sukses mengambil data');
    }
    public function Dokumen_create(Request $request){
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
    public function StaffAdmin_create(Request $request){
        $data = $request->validate([
            'id_admin'=> 'required',
            'nama'=> 'required',
            'no_hp'=> 'required'
        ]);
        StaffAdmin::create([
            'id_admin'=>$request->id_admin,
            'nama'=>$request->nama,
            'no_hp'=>$request->no_hp
        ]);
        return $this->sendResponse($data, 'Sukses Memuat Data!');
    }
    public function markeddokumen_create(Request $request){
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
    public function Dokumen_hapus($id)
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
    public function Dokumen_update(Request $request, $id)
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
    public function satuan_dokumen() {
        $user = Auth::user()->id;
        $dokumen = Dokumen::where('id_admin', $user)->get();

        return response()->json(['data'=> $dokumen, 'message'=> 'Sukses mengambil data'], 200);
    }
    public function dokumen_filter_kategori($kategori){

    // Ambil dokumen yang sesuai dengan id_kategori dari tabel Dokumen
        $dokumen = Dokumen::where('kategori', $kategori)->get();

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
    public function dokumen_filter_jenis_surat($jenis_surat){

        // Ambil dokumen yang sesuai dengan id_kategori dari tabel Dokumen
            $dokumen = Dokumen::where('jenis_surat', $jenis_surat)->get();
    
        // Cek apakah ada dokumen yang ditemukan
            if ($dokumen->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada dokumen yang ditemukan untuk jenis ini.'
                ], 404);
            }
    
        // Kembalikan respon sukses dengan data dokumen yang ditemukan
            return response()->json([
                'success' => true,
                'data' => $dokumen
            ], 200);
        }
        public function Dokumen_download($id)
        {
            // Cari dokumen berdasarkan ID
            $dokumen = Dokumen::find($id);
        
            // Periksa apakah dokumen ditemukan
            if (!$dokumen) {
                return $this->sendError('Dokumen tidak ditemukan.', [], 404);
            }
        
            // Tentukan path file yang ingin diunduh
            $file_path = storage_path('app/' . $dokumen->file_path);
        
            // Periksa apakah file ada di storage
            if (!file_exists($file_path)) {
                return $this->sendError('File tidak ditemukan.', [], 404);
            }
        
            // Kembalikan response download
            return response()->download($file_path, $dokumen->judul);
        }
        
    public function ambil_dokumen_yang_ditandai_dosen() {
        if (Auth::user()->role == 'dosen') {
            $dosen_id = Auth::user()->id;

            $dokumen = MarkedDokumen::where('id_dosen',$dosen_id)->get();

            foreach ($dokumen as $doc) {
                $doc->dokumen;
            }

            return $this->sendResponse($dokumen, 'Data sukses diambil');
        }
    }
}