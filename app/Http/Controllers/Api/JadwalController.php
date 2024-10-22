<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\Jadwal;

class JadwalController extends BaseController
{
    public function jadwal()
    {
        //harus connect ke database rps dulu
        $data = Jadwal::select([
            'id_jadwal',
            'nip',
            'id_kelas',
            'kode_matkul',
            'id_ruang',
            'hari',
            'start',
            'finish',
            'semester',

                 ])->with([
                'matkul'=> function ($q){
                    $q->select(['kode_matkul', ]);
                }
             ])->with([
                 'ruang'=> function ($q){
                  $q->select(['id_ruang']);
                }
                ])->with([
                    'kelas'=> function ($q){
                     $q->select(['id_kelas']);
                   }
        ])->get();
        return $this->sendResponse($data, 'sukses mengambil data');
    }
    public function jadwal_create(Request $request){
        $data = $request -> validate([
            'id_jadwal'=>'required',
            'nip' => 'required',
            'id_kelas'=>'required',
            'kode_matkul'=>'required',
            'id_ruang'=>'required',
            'hari'=>'required',
            'start'=>'required',
            'finish'=>'required',
            'semester'=>'required',
        ]);

    Jadwal::create([
        'id_jadwal' => $request->id_jadwal,
        'nip' => $request->nip,
        'id_kelas'=> $request->id_kelas,
        'kode_matkul'=> $request->kode_matkul,
        'id_ruang'=> $request->id_ruang,
        'hari'=> $request->hari,
        'start'=> $request->start,
        'finish'=> $request->finish,
        'semester'=> $request->semester
    ]);
        return $this->sendResponse($data, 'Sukses membuat Data!');
    }
}
