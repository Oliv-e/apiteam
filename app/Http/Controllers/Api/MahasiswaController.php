<?php

namespace App\Http\Controllers\Api;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Http\Resources\Api\MahasiswaCollection;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Validator;

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
        // $data = $data->except(['id_kelas','nip','kode_prodi']);
        return $this->sendResponse(new MahasiswaCollection($data), 'Sukses mengambil data');
    }

    public function update(Request $request, Mahasiswa $mahasiswa) {

        $input = $request->all();

        $validator = Validator::make($input, [
            'nama' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.',$validator->errors());
        }

        $mahasiswa->name = $input['nama'];
        $mahasiswa->save();

        return $this->sendResponse(new MahasiswaCollection($mahasiswa), 'Product updated successfully.');
    }

    public function destroy(Mahasiswa $mahasiswa) {
        $mahasiswa->delete();

        return $this->sendResponse([], 'data mahasiswa sukses');
    }
}
