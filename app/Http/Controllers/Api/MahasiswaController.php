<?php

namespace App\Http\Controllers\Api;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Http\Resources\Api\MahasiswaCollection;
use Response;
use App\Http\Controllers\Api\BaseController as BaseController;

class MahasiswaController extends BaseController
{
    public function index() {
        $data = Mahasiswa::all();
        foreach ($data as $mhs) {
            // $mhs->put('nama_jurusan', $mhs->jurusan->nama_jurusan);
            $mhs->prodi;
            $mhs->prodi->jurusan;
            $mhs->dosen_pembimbing;
            $mhs->kelas;
        }
        $data = $data->except(['id_kelas','nip','kode_prodi']);
        return $this->sendResponse(new MahasiswaCollection($data), 'Sukses mengambil data');
    }

    public function edit(Request $request) {

        try {

            $update = Mahasiswa::where('nim', $request->nim)->update([
                'nama' => $request->nama,
                /// others
            ]);

        } catch (\Exception $e) {

            return 'error';

        }
    }

    public function delete(Request $request) {

        try {

            $getId = Mahasiswa::findOrFail($request->id)->delete();
            return 'success';

        } catch (\Exception $e) {

            return 'error';

        }
    }
}
