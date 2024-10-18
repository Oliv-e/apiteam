<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Models\Dokumen;
use App\Models\StaffAdmin;
use Illuminate\Http\Request;

class ArsipController extends BaseController
{
    public function Dokumen(){
        $data = Dokumen::select('id_admin','id_kategori','nama_kategori','judul', 'deskripsi', 'file_path', 'nomor_unik','upload_by')
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
            'id_dokumen'=> 'required'
        ]);
        markeddokumen::create([
            'id_tandai'=>$request->id_tandai,
            'id_user'=>$request->id_user,
            'id_dokumen'=>$request->id_dokumen
        ]);
        return $this->sendResponse($data, 'Sukses Memuat Data!');
    }
    public function destroy(Dokumen $dokumen){
        $dokumen->delete();

        return $this->sendResponse([], 'data mahasiswa sukses');
    }
}