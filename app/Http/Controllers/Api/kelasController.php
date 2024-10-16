<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\Kelas;

class kelasController extends BaseController
{
    public function kelas()
    {
        //harus connect ke database rps dulu
        $data = Kelas::select([
            'id_kelas',
            'abjad_kelas',
            
        ])->get();
        return $this->sendResponse($data, 'sukses mengambil data');
    }
    public function kelas_create(Request $request){
        $data = $request -> validate([
            'id_kelas'=>'required',
            'abjad_kelas'=>'required',
        ]);
    
    Kelas::create([
        'id_kelas'=>$request -> id_kelas,
        'abjad_kelas' =>$request -> abjad_kelas
        
    ]);
        return $this->sendResponse($data, 'Sukses membuat Data!');
    }
}
