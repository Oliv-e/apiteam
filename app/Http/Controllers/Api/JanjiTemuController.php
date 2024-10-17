<?php

namespace App\Http\Controllers\Api;

use App\Models\KHS;
use Illuminate\Http\Request;
use App\Http\Resources\Api\MahasiswaCollection;
use Response;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\JanjiTemu;
use App\Models\Rekomendasi;

class JanjiTemuController extends BaseController
{
    public function janji_temu()
    {
        $data = JanjiTemu::select([
            'nim',
            'tanggal',
            'materi',
            'status'
        ])->with([
            'mahasiswa' => function ($q) {
                $q->select(['nim','nama']);
            }
        ])->get();
        //$data->makeHidden(['jenis_rekomendasi', 'tanggal_persetujuan']);
        return $this->sendResponse($data, 'Sukses mengambil data');
    }

    //
    public function janji_temu_create(Request $request)
    {
        $data = $request->validate([
            'nim' => 'required',
            'tanggal' => 'required',
            'materi' => 'required',
            'status' => 'required'
        ]);

        JanjiTemu::create([
            'nim' => $request->nim,
            'tanggal' => $request->tanggal,
            'materi' => $request->materi,
            'status' => $request->status
        ]);

        return $this->sendResponse($data, 'Sukses Membuat Data!');
    }
}
