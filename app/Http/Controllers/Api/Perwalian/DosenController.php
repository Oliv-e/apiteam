<?php

namespace App\Http\Controllers\Api\Perwalian;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\JanjiTemu;
use App\Models\Konsultasi;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\Dosen;
use Illuminate\Support\Facades\Auth;

class DosenController extends BaseController
{
    //tampilkan data konsultasi untuk dosen
    public function konsul()
    {
        $data = Konsultasi::select([
            'nim',
            'tanggal',
            'materi'
        ])->with([
            'mahasiswa' => function ($q) {
                $q->select(['nim', 'nama', 'semester', 'id_kelas', 'no_hp'])->with([
                    'kelas' => function ($que) {
                        $que->select(['id_kelas', 'abjad_kelas']);
                    }
                ]);
            }
        ])->get();

        // Sembunyikan id_kelas di mahasiswa dan kelas
        $data->each(function ($item) {
            $item->mahasiswa->makeHidden('nim');
            $item->mahasiswa->makeHidden('id_kelas');
            $item->mahasiswa->kelas->makeHidden('id_kelas');
        });

        return $this->sendResponse($data, 'Sukses mengambil data');
    }

    //display permintaan janji temu
    public function janji_temu($nip)
    {
        // Ambil data janji temu berdasarkan nip dosen
        $data = JanjiTemu::whereHas('mahasiswa', function ($query) use ($nip) {
            $query->where('nip', $nip); // Filter berdasarkan NIP dosen
        })
        ->with([
            'mahasiswa' => function ($query) {
                $query->select(['nim', 'nama', 'nip']); // Ambil nim, nama, dan nip mahasiswa
            }
        ])
        ->select(['nim', 'tanggal', 'materi', 'status'])
        ->get();

        // Sembunyikan nim pada relasi mahasiswa
        $data->each(function ($item) {
            $item->mahasiswa->makeHidden(['nim','nip']);
        });
        
        return $this->sendResponse($data, 'Sukses mengambil data');
    }

    //display mahasiswa bimbingan
    public function mhs_bimbingan()
    {
        // Ambil data janji temu berdasarkan nip dosen
        $nip = Auth::user()->id;
        $data = Mahasiswa::whereHas('dosen',
            function ($query) use ($nip) {
                $query->where('nip', $nip); // Filter berdasarkan NIP dosen
            }
        )
        ->with([
            'mahasiswa' => function ($query) {
                // Ambil nim, nama, no_hp, dan semester mahasiswa
                $query->select(['nim', 'nama', 'no_hp', 'semester']);
            }
        ])
        ->get();
        $dosen = Dosen::where('nip', $nip)->with('mahasiswa:nim,nama,no_hp,semester,dosen_id')->get();

        // Sembunyikan nim pada relasi mahasiswa
        $data->each(function ($item) {
            $item->mahasiswa->makeHidden(['nip']);
        });

        return $this->sendResponse($dosen, 'Sukses mengambil data');
    }
}
