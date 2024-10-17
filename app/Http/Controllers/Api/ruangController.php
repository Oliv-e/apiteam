<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\Ruang;

class ruangController extends BaseController
{
    public function ruang()
    {
        //harus connect ke database rps dulu
        $data = Ruang::select([
            'id_ruang',
            'nama_ruang',
            
        ])->get();
        return $this->sendResponse($data, 'sukses mengambil data');
    }
    public function ruang_create(Request $request){
        $data = $request -> validate([
            'id_ruang'=>'required',
            'nama_ruang'=>'required',
        ]);
    
    Ruang::create([
        'id_ruang'=>$request -> id_ruang,
        'nama_ruang' =>$request -> nama_ruang
        
    ]);
        return $this->sendResponse($data, 'Sukses membuat Data!');
    }
}
