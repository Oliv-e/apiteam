<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Resources\Api\MahasiswaCollection;
use Response;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Rekomendasi;

class RekomendasiController extends BaseController
{
    //tampilkan rekomendasi
    public function rekomendasi()
    {
        $data = Rekomendasi::select([
            'nim','keterangan','tanggal_pengajuan','status'
        ])->with([
            'mahasiswa' => function ($q) {
                $q->select(['nama', 'semester']);
            }
        ])->get();
        //$data->makeHidden(['jenis_rekomendasi', 'tanggal_persetujuan']);
        return $this->sendResponse($data, 'Sukses mengambil data');
    }

    //tambah rekomendasi
    public function rekomendasi_create(Request $request) {
        $data = $request -> validate([
            'nim' => 'required',
            'jenis_rekomendasi' => 'required',
            'tanggal_pengajuan' => 'required',
            'tanggal_persetujuan' => 'required',
            'keterangan' => 'required',
            'status' => 'required'
        ]);

        Rekomendasi::create([
            'nim' => $request -> nim,
            'jenis_rekomendasi' => $request -> jenis_rekomendasi,
            'tanggal_pengajuan' => $request -> tanggal_pengajuan,
            'tanggal_persetujuan' => $request -> tanggal_persetujuan,
            'keterangan' => $request -> keterangan,
            'status' => $request -> status
        ]);

        return $this->sendResponse($data, 'Sukses Membuat Data!');
    }
}