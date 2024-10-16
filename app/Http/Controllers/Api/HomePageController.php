<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\jadwal;
use App\Models\matkul;
use App\Models\dosen;
use App\Models\kelas;

class HomePageController extends BaseController
{
    public function jadwal(Request $request)
    {
       
        $data =jadwal ::select('start','finish','semester','id_kelas','kode_matkul')
            // ->with([
            //     'dosen'=> function ($q){
            //     $q->select(['nama','nip']);
            // }
            // ])
            ->with([
                'kelas'=> function ($q){
                $q->select(['abjad_kelas','id_kelas']);
            }
            ])
            ->with([
                'matkul'=> function ($q){
                $q->select(['nama_matkul','kode_matkul']);
            }
            ])
            ->get();

            $data->each(function ($item) {
                $item->kelas->makeHidden(['id_kelas']);
                $item->matkul->makeHidden(['kode_matkul']);
            });
        return $this->SendResponse($data,'Sukses Mengambil Data');
    }
    
}
