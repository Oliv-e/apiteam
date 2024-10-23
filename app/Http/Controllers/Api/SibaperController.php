<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\BeritaAcara;
use App\Models\jadwal;
use App\Models\ruang;
use App\Models\Dosen;


class SibaperController extends BaseController
{
    public function Homepage($nip)
    {
        $nip = auth()->user()->id;
        $data = BeritaAcara::where('nip',$nip)
        ->select([
            'nip',
            'id_jadwal',
        ])->with([
            'jadwal' => function ($q) {
                $q->select(['id_jadwal','semester','start','finish','id_kelas'])
                ->with(['kelas'=>function($que){
                    $que->select(['id_kelas','abjad_kelas',]);
                }]);
            }
        ])->with([
            'dosen' => function ($q) {
                $q->select(['nip','nama',]);
            }
        ])->get();
        if($data->isEmpty()){
            return response()->json([
                'success'=> false,
                'message'=>'data tidak ditemukan',
            ],404);
        }
        $data->each(function($item){
            $item -> makehidden(['id_jadwal']);
            $item ->jadwal -> makehidden(['id_jadwal','id_kelas']);
            $item->jadwal->kelas->makeHidden(['id_kelas']);
            $item ->dosen -> makehidden(['nip']);
            });
        return $this->sendResponse($data, 'sukses mengambil data');
        }



        public function Historypage($nip){
            {
                $data = BeritaAcara::where('nip',$nip)
                ->select([
                    'minggu_ke',
                    'nip',
                    'id_jadwal',
                    'tanggal',
                    // 'nama_matkul',
                    // 'pokok_bahasan',
                    // 'sub_pokok_bahasan',
                    'status',
                ])->get();
        
                    if ($data->isEmpty()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'data tidak ditemukan',
                        ], 404); }}

                        $data->each(function($item){
                        $item -> makehidden(['nip','id_jadwal']);
                    });
                return $this->sendResponse($data, 'sukses mengambil data history');
            }
        }
