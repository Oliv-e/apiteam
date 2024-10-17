<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Resources\Api\MahasiswaCollection;
use Response;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\KHS;

class KHSController extends BaseController
{
    public function khs()
    {
        $data = KHS::select([
            'nim','semester','tahun_ajaran','status'
        ])->with([
            'mahasiswa' => function ($q) {
                $q->select(['nama', 'semester']);
            }
        ])->get();
        //$data->makeHidden(['jenis_rekomendasi', 'tanggal_persetujuan']);
        return $this->sendResponse($data, 'Sukses mengambil data');
    }

    //
    public function khs_create(Request $request)
    {
        $data = $request->validate([
            'nim' => 'required',
            'semester' => 'required',
            'tahun_ajaran' => 'required',
            'status' => 'required'
        ]);

        KHS::create([
            'nim' => $request->nim,
            'semester' => $request->semester,
            'tahun_ajaran' => $request->tahun_ajaran,
            'status' => $request->status
        ]);

        return $this->sendResponse($data, 'Sukses Membuat Data!');
    }
}
