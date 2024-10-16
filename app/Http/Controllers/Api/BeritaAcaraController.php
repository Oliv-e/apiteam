<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\BeritaAcara;

class BeritaAcaraController extends BaseController
{
    public function berita_acara()
    {
        //harus connect ke database rps dulu
        $data = BeritaAcara::select([
            'nip',
            'id_jadwal',
            'tanggal',
            'id_rps',
            'media',
            'jam_ajar',
            ])->with([
                'jadwal'=> function ($q){
                    $q->select(['id_jadwal', ]);
                }
                 ])->with([
                'jadwal'=> function ($q){
                    $q->select(['id_jadwal', ]);
                }
             ])->with([
                 'rps'=> function ($q){
                  $q->select(['id_rps']);
                }
        ])->get();
        return $this->sendResponse($data, 'sukses mengambil data');
    }

    public function berita_acara_create(Request $request){
        $data = $request -> validate([
            'nip' => 'required',
            'id_jadwal' => 'required',
            'tanggal'=> 'required',
            'id_rps'=> 'required',
            'media'=> 'required',
            'jam_ajar'=> 'required',    
        ]);
    
    BeritaAcara::create([
        'nip'=>$request -> nip,
        'id_jadwal' =>$request -> id_jadwal,
        'tanggal'=>$request -> tanggal,
        'id_rps'=>$request -> id_rps,
        'media'=>$request -> media,
        'jam_ajar'=>$request -> jam_ajar
    ]);
        return $this->sendResponse($data, 'Sukses membuat Data!');
    }
}
