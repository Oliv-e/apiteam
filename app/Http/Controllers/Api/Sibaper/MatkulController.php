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
            'kode',
            'nama',
            'sks_teori',
            'sks_praktikum',
            'jam_teori',
            'jam_praktikum',
        ])->get();
        foreach ($data as $dat) {
            $dat['sks_total'] = $dat['sks_teori'] + $dat['sks_praktikum'];
            $dat['jam_total'] = $dat['jam_teori'] + $dat['jam_praktikum'];
        }
        return $this->sendResponse($data, 'sukses mengambil data');
    }
    public function matkul_create(Request $request){
        $data = $request -> validate([
            'kode'=>'required',
            'nama'=>'required',
            'sks_teori'=>'required',
            'sks_praktikum'=>'required',
            'jam_teori'=>'required',
            'jam_praktikum'=>'required',
        ]);

        Matkul::create([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'sks_teori' => $request->sks_teori,
            'sks_praktikum' => $request->sks_praktikum,
            'jam_teori' => $request->jam_teori,
            'jam_praktikum' => $request->jam_praktikum
        ]);
        return $this->sendResponse($data, 'Sukses membuat Data!');
    }
}
