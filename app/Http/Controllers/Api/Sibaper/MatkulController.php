<?php

namespace App\Http\Controllers\Api\Sibaper;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\Matkul;

class MatkulController extends BaseController
{
    public function matkul()
    {
        //harus connect ke database rps dulu
        $data = Matkul::select([
            'kode_matkul',
            'nama_matkul',
            'jumlah_jam',
            'SKS',
        ])->get();
        return $this->sendResponse($data, 'sukses mengambil data');
    }
    public function matkul_create(Request $request){
        $data = $request -> validate([
            'kode_matkul'=>'required',
            'nama_matkul'=>'required',
            'jumlah_jam'=>'required',
            'SKS'=>'required',
        ]);

        Matkul::create([
            'kode_matkul'=>$request -> kode_matkul,
            'nama_matkul' =>$request -> nama_matkul,
            'jumlah_jam'=>$request -> jumlah_jam,
            'sks'=>$request -> sks,
        ]);
        return $this->sendResponse($data, 'Sukses membuat Data!');
    }
}
