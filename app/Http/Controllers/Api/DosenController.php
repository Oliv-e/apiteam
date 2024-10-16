<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\Dosen;

class DosenController extends BaseController
{
    public function dosen()
    {
        //harus connect ke database rps dulu
        $data = Dosen::select([
            'nip',
            // 'is_kaprodi',
            'nama',
            'no_hp',
            ])->with([
                'dosen'=> function ($q){
                    $q->select(['nip', ]);
                }
        ])->get();
        
        return $this->sendResponse($data, 'sukses mengambil data');
    }
    public function dosen_create(Request $request){
        $data = $request -> validate([
            'nip'=>'required',
            // 'is_kaprodi'=>'required',
            'nama'=>'required',
            'no_hp'=>'required',    
        ]);
    
    Dosen::create([
        'nip'=>$request -> nip,
        'nama'=>$request -> nama,
        'no_hp'=>$request -> no_hp,
        
    ]);
        return $this->sendResponse($data, 'Sukses membuat Data!');
    }
}
