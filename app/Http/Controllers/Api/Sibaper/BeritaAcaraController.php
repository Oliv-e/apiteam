<?php

namespace App\Http\Controllers\Api\Sibaper;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\BeritaAcara;
use App\Models\Jadwal;
use App\Models\rps;

class BeritaAcaraController extends BaseController
{
    public function berita_acara()
    {
        //harus connect ke database rps dulu
        $data = BeritaAcara::select([
            'nip',
            'id_jadwal',
            'id_rps',
            'tanggal',
            'media',
            'jam_ajar',
            'status'
        ])->with([
            'jadwal' => function ($q) {
                $q->select(['id_jadwal','semester' ]);
            }
        ])->with([
            'rps' => function ($q) {
                $q->select(['id_rps','minggu_ke','bahan_kajian','sub_bahan_kajian']);
            }
        ])->get();
        return $this->sendResponse($data, 'sukses mengambil data');
    }

    public function berita_acara_create(Request $request)
    {
        try{
        $data = $request->validate([
            'nip' => 'required',
            'id_jadwal' => 'required',
            'id_rps' => 'required',
            'tanggal' => 'required',
            'media' => 'required',
            'jam_ajar' => 'required',
            'status' => 'required'
        ]);
        $beritaacara = BeritaAcara::updateOrCreate(
            ['nip' => $request->nip], // kondisi untuk mencari data yang ada
            $data // data yang akan diinsert atau diupdate
        );

        return $this->sendResponse($beritaacara, 'Sukses membuat atau memperbarui Data!');
    } catch (\Exception $e) {
        return $this->sendError('Gagal membuat data', $e->getMessage());
    }
        BeritaAcara::create([
            'nip' => $request->nip,
            'id_jadwal' => $request->id_jadwal,
            'id_rps' => $request->id_rps,
            'tanggal' => $request->tanggal,
            'media' => $request->media,
            'jam_ajar' => $request->jam_ajar,
            'status' => $request->status
        ]);
        return $this->sendResponse($data, 'Sukses membuat Data!');
    }
        public function berita_Acara_show($nip) {
            try {
                $beritaAcara = beritaAcara::find($nip);
                if (is_null($beritaAcara)) {
                    return $this->sendError('Data berita Acara tidak ditemukan');
                }
                return $this->sendResponse($beritaAcara, 'Sukses mengambil data');
            } catch (\Exception $e) {
                return $this->sendError('Gagal mengambil data', $e->getMessage());
            }
        }

        public function berita_acara_update(Request $request ,$nip) {
            try{
                $beritaacara = BeritaAcara::where('nip', $nip)->first();
                if (!$beritaacara) {
                    return $this->sendError('Data berita Acara tidak ditemukan');
                }
                // Validasi input yang diterima
                $data = $request->validate([
                    'id_jadwal' => 'required',
                    'id_rps' => 'required',
                    'tanggal' => 'required',
                    'media' => 'required',
                    'jam_ajar' => 'required',
                    'status' => 'required'

                ]);
                $beritaacara = BeritaAcara::find($nip);
                if (is_null($beritaacara)) {
                    return $this->sendError('Data beritaAcara tidak ditemukan');
                }

                return $this->sendResponse($beritaacara, 'Data berita Acara berhasil diperbarui');
        } catch(\Exception $e) {
            return $this->sendError('Gagal memperbarui data berita Acara', $e->getMessage());
        }
    }

    public function berita_acara_hapus($nip)
    {
        // Cari data berdasarkan NIP
        $beritaAcara = BeritaAcara::where('nip', $nip)->first();

        // Jika data ditemukan, hapus
        if ($beritaAcara) {
            $beritaAcara->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data Berita Acara berhasil dihapus',
            ], 200);
        }

        // Jika data tidak ditemukan
        return response()->json([
            'success' => false,
            'message' => 'Data Berita Acara tidak ditemukan',
        ], 404);
    }
}
