<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Resources\Api\MahasiswaCollection;
use Response;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Konsultasi;

class KonsultasiController extends BaseController
{
    public function konsul()
    {
        $data = Konsultasi::select([
            'nim',
            'tanggal',
            'materi',
        ])->with([
            'mahasiswa' => function ($q) {
                $q->select(['nim','nama', 'semester', 'id_kelas', 'no_hp'])->with([
                        'kelas' => function ($que) {
                            $que -> select(['id_kelas', 'abjad_kelas']);
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


    //
    public function konsul_create(Request $request)
    {
        $data = $request->validate([
            'nim' => 'required',
            'tanggal' => 'required',
            'materi' => 'required'
        ]);

        Konsultasi::create([
            'nim' => $request->nim,
            'tanggal' => $request->tanggal,
            'materi' => $request->materi
        ]);

        return $this->sendResponse($data, 'Sukses Membuat Data!');
    }

    public function konsul_update(Request $request, $nim)
    {
        // Validasi input
        $data = $request->validate([
            // 'nim' => 'required',
            'tanggal' => 'required',
            'materi' => 'required'
        ]);

        // Cari data konsultasi berdasarkan nim
        $konsul = Konsultasi::where('nim', $nim)->firstOrFail();

        // Update data yang ditemukan
        $konsul->update([
            'nim' => $request->nim,
            'tanggal' => $request->tanggal,
            'materi' => $request->materi
        ]);

        return $this->sendResponse($konsul, 'Sukses Mengupdate Data!');
    }

    public function konsul_delete($nim)
    {
        // Cari data konsultasi berdasarkan nim
        $konsul = Konsultasi::where('nim', $nim)->firstOrFail();

        // Hapus data yang ditemukan
        $konsul->delete();

        return $this->sendResponse(null, 'Sukses Menghapus Data!');
    }
}
