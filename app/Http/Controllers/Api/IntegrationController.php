<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Models\StaffAdmin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Dosen;

class IntegrationController extends BaseController
{
    public function mahasiswa() {
        $data = Mahasiswa::select([
            'nim','kode_prodi','nip','id_kelas','nama','nip','semester','no_hp'
        ])->with([
            'prodi' => function ($q) {
                $q->select(['kode_prodi','nama_prodi','kode_jurusan']);
            },
            'prodi.jurusan' => function ($q) {
                $q->select(['kode_jurusan','nama_jurusan']);
            }
        ])->with([
            'dosen_pembimbing' => function ($q) {
                $q->select(['nip','nama']);
            }
        ])->with([
            'kelas' => function ($q) {
                $q->select(['id_kelas','abjad_kelas']);
            }
        ])->get();
        $data->makeHidden(['kode_prodi','nip','id_kelas']);
        foreach ($data as $dat) {
            $dat->prodi->makeHidden(['kode_jurusan']);
            $dat->kelas->makeHidden(['id_kelas']);
        }
        return $this->sendResponse($data, 'Sukses mengambil data');
    }
    public function mahasiswa_by_id($id) {
        $data = Mahasiswa::where('nim', $id)->get();
        return $this->sendResponse($data, 'Data Berhasil diambil');
    }
    public function mahasiswa_create(Request $request) {
        $data = $request->validate([
            'id' => 'required',
            'nama' => 'required',
            'role' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'kode_prodi' => 'required',
            'semester' => 'required',
            'id_kelas' => 'required',
            'nip' => 'required',
            'no_hp' => 'required'
        ]);

        User::create([
            'id' => $request->id,
            'role' => $request->role,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        Mahasiswa::create([
            'nim' => $request->id,
            'nama' => $request->nama,
            'kode_prodi' => $request->kode_prodi,
            'semester' => $request->semester,
            'id_kelas' => $request->id_kelas,
            'nip' => $request->nip,
            'no_hp' => $request->no_hp
        ]);

        unset($data['password']);
        unset($data['c_password']);

        return $this->sendResponse($data, 'Sukses Membuat Data');
    }
    public function dosen() {
        $data = Dosen::all();

        return $this->sendResponse($data, 'Data berhasil diambil!');
    }
    public function dosen_create(Request $request) {
        $data = $request->validate([
            'id' => 'required',
            'nama' => 'required',
            'role' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'no_hp' => 'required'
        ]);

        User::create([
            'id' => $request->id,
            'role' => $request->role,
            'email' => $request->email,
            'password'  => $request->password
        ]);

        Dosen::create([
            'nip' => $request->id,
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
        ]);

        unset($data['password']);
        unset($data['c_password']);

        return $this->sendResponse($data, 'Data dan Akun dosen berhasil disimpan!');
    }
    public function mahasiswa_update(Request $request, $id) {
        $data = $request->validate([
            'nim',
            'email' => 'email|unique:users',
            'password',
            'c_password' => 'same:password',
            'kode_prodi',
            'semester',
            'id_kelas',
            'nip',
            'no_hp',
        ]);
        Mahasiswa::where('nim', $id)->update([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'kode_prodi' => $request->kode_prodi,
            'semester' => $request->semester,
            'id_kelas' => $request->id_kelas,
            'nip' => $request->nip,
            'no_hp' => $request->no_hp
        ]);
        User::where('id', $id)->update([
            'nim' => $request->nim,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return $this->sendResponse($request->id, 'Data sukses di ubah!');
    }
    public function mahasiswa_delete($id) {
        Mahasiswa::where('nim', $id)->delete();
        User::where('id', $id)->delete();

        return $this->sendResponse('Sukses Menghapus Data', 'YEY!');
    }
    public function StaffAdmin(){
        $data = StaffAdmin::all();
        return $this->SendResponse($data,'Sukses mengambil data');
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
}
