<?php

namespace App\Http\Controllers\Api\Perwalian;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\JanjiTemu;
use App\Models\Konsultasi;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\Dosen;
use App\Models\Rekomendasi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MhsController extends BaseController
{
    //display permintaan janji temu
    public function janji_temu()
    {
        // Mendapatkan nim dari user (mahasiswa) yang sedang login
        $nim = Auth::user()->id;

        // Cari data mahasiswa berdasarkan nim yang sedang login
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        // Jika data mahasiswa tidak ditemukan
        if (!$mahasiswa) {
            return $this->sendError('Data mahasiswa tidak ditemukan');
        }

        // Ambil nip dosen dari data mahasiswa
        $nip = $mahasiswa->nip;

        // Cari janji temu berdasarkan nip dosen yang ada pada data mahasiswa
        $data = Mahasiswa::where('nip', $nip)
            ->with([
                'janji_temu' => function ($query) {
                    $query->select([
                        'id',
                        'nim',
                        'tanggal',
                        'materi'
                    ]);
                }
            ])->get(['nim', 'nama', 'no_hp', 'semester']);

        // Jika data janji temu kosong
        if ($data->isEmpty()) {
            return $this->sendError('Data janji temu tidak ditemukan');
        }

        // Sembunyikan kolom 'nim' dari janji_temu di setiap mahasiswa
        $data->each(function ($mahasiswa) {
            $mahasiswa->janji_temu->makeHidden(['nim']);
        });

        // Kembalikan data dengan pesan sukses
        return $this->sendResponse($data, 'Sukses mengambil data janji temu');
    }

}
