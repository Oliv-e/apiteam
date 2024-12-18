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
    // Display permintaan janji temu dan konsultasi
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

        // Cari semua mahasiswa yang memiliki nip yang sama dengan dosen yang terkait
        $mahasiswas = Mahasiswa::where('nip', $nip)->pluck('nim');

        // Ambil semua data konsultasi yang terkait dengan nim mahasiswa tersebut
        $data = Konsultasi::whereIn('konsultasi.nim', $mahasiswas) // Filter konsultasi berdasarkan nim mahasiswa
            ->join('mahasiswa', 'konsultasi.nim', '=', 'mahasiswa.nim') // Menggabungkan tabel mahasiswa
            ->select('mahasiswa.nama', 'konsultasi.nim as nim', 'konsultasi.tanggal', 'konsultasi.materi') // Ambil kolom yang diperlukan dengan alias
            ->get();

        // Jika data konsultasi kosong
        if ($data->isEmpty()) {
            return $this->sendError('Data konsultasi tidak ditemukan');
        }

        // Kembalikan data dengan pesan sukses
        return $this->sendResponse($data, 'Sukses mengambil seluruh data konsultasi');
    }


    //form janji temu
    public function janji_temu_create(Request $request)
    {
        // Mendapatkan nim dari user (mahasiswa) yang sedang login
        $nim = Auth::user()->id;

        // Cari data mahasiswa berdasarkan nim yang sedang login
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        // Jika data mahasiswa tidak ditemukan
        if (!$mahasiswa) {
            return $this->sendError('Data mahasiswa tidak ditemukan');
        }

        $data = $request->validate([
            //'nim' => 'required',
            'tanggal' => 'required',
            'materi' => 'required',
            //'status' => 'required'
        ]);

        JanjiTemu::create([
            'nim' => $nim,
            'tanggal' => $request->tanggal,
            'materi' => $request->materi,
            //'status' => $request->status
        ]);

        return $this->sendResponse($data, 'Sukses Membuat Data!');
    }

    //tampilkan rekomendasi
    public function rekomendasi()
    {
        // Mendapatkan nim dari user (mahasiswa) yang sedang login
        $nim = Auth::user()->id;

        // Cari data mahasiswa berdasarkan nim yang sedang login
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        // Jika data mahasiswa tidak ditemukan
        if (!$mahasiswa) {
            return $this->sendError('Data mahasiswa tidak ditemukan');
        }

        // Ambil data mahasiswa beserta rekomendasi terkait
        $data = Mahasiswa::where('nim', $nim)
            ->with(['rekomendasi:nim,jenis_rekomendasi,status']) // Menyederhanakan relasi
            ->get(['nim', 'nama']);

        // Sembunyikan atribut tertentu pada model rekomendasi
        $data->each(function ($mahasiswa) {
            $mahasiswa->rekomendasi->each(function ($rekomendasi) {
                $rekomendasi->makeHidden(['nim']);
            });
        });

        //$data->makeHidden(['jenis_rekomendasi', 'tanggal_persetujuan']);
        return $this->sendResponse($data, 'Sukses mengambil data');
    }

    //tambah rekomendasi
    public function rekomendasi_create(Request $request)
    {
        // Mendapatkan nim dari user (mahasiswa) yang sedang login
        $nim = Auth::user()->id;

        // Cari data mahasiswa berdasarkan nim yang sedang login
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        // Jika data mahasiswa tidak ditemukan
        if (!$mahasiswa) {
            return $this->sendError('Data mahasiswa tidak ditemukan');
        }

        $data = $request->validate([
            'jenis_rekomendasi' => 'required',
            'tanggal_pengajuan' => 'required',
            'keterangan' => 'required',
            // 'nim' => $nim,
            // 'tanggal_persetujuan' => 'required',
            // 'status' => 'required'
        ]);

        Rekomendasi::create([
            'nim' => $nim,
            'jenis_rekomendasi' => $request->jenis_rekomendasi,
            'tanggal_pengajuan' => $request->tanggal_pengajuan,
            'keterangan' => $request->keterangan,
            //'tanggal_persetujuan' => $request->tanggal_persetujuan,
            // 'status' => $request->status
        ]);

        return $this->sendResponse($data, 'Sukses Membuat Data!');
    }
}
