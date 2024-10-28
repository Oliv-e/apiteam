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

class DosenController extends BaseController
{
    //display permintaan janji temu
    public function janji_temu(Request $request)
    {
        $nip = Auth::user()->id;

        // Ambil data mahasiswa yang terkait dengan nip dosen
        $data = Mahasiswa::where('nip', $nip)
            ->with([
                'janji_temu' => function ($query) {
                    $query->select(['id', 'nim', 'tanggal', 'materi', 'status']);
                }
            ])
            ->get(['nim', 'nama']);

        if ($data->isEmpty()) {
            return $this->sendError('Data tidak ditemukan');
        }

        // Hide 'nim' in the JanjiTemu model for each Mahasiswa
        $data->each(function ($mahasiswa) {
            $mahasiswa->janji_temu->makeHidden(['nim', 'id']);
        });

        // Jika ada permintaan untuk menyetujui janji temu
        if ($request->has('setujui')) {
            $id = $request->input('setujui');
            $janjiTemu = JanjiTemu::find($id);

            if (!$janjiTemu) {
                return $this->sendError('Janji temu tidak ditemukan');
            }

            // Cek apakah janji temu sudah disetujui
            if ($janjiTemu->status === 'Disetujui') {
                // Simpan data ke tabel Konsultasi
                $konsultasi = Konsultasi::create([
                    'nim' => $janjiTemu->nim,
                    'tanggal' => $janjiTemu->tanggal,
                    'materi' => $janjiTemu->materi,
                    'status' => 'Disetujui'
                ]);
                return $this->sendResponse($konsultasi, 'Data berhasil disimpan ke tabel Konsultasi');
            }
            return $this->sendError('Janji temu tidak disetujui, tidak ada data yang disimpan');
        }

        // Kembalikan data permintaan janji temu
        return $this->sendResponse($data, 'Sukses mengambil data');
    }


    //display konsultasi
    public function konsul() {
        // Ambil nip dari pengguna yang sedang login
        $nip = Auth::user()->id;

        // Ambil semua nilai nim mahasiswa yang terkait dengan nip dosen yang sedang login
        $mahasiswaNim = Mahasiswa::where('nip', $nip)->pluck('nim');

        // Query konsultasi berdasarkan nilai nim yang diambil
        $data = Konsultasi::select([
            'konsultasi.tanggal',
            'konsultasi.materi',
        ])
        ->join('janjitemu', 'konsultasi.nim', '=', 'janjitemu.nim')
        ->where('janjitemu.status', '=', 'Disetujui')
        ->whereIn('konsultasi.nim', $mahasiswaNim)
        ->with([
            'mahasiswa' => function ($q) {
                $q->select(['nim', 'nama', 'semester', 'no_hp']);
            }
        ])
        ->get();

        // Format data untuk menyertakan field tambahan dalam respons
        $display = $data->map(function ($item) {
            return [
                'nim'       => $item->mahasiswa->nim,
                'nama'      => $item->mahasiswa->nama,
                'no_hp'     => $item->mahasiswa->no_hp,
                'tanggal'   => $item->tanggal,
                'semester'  => $item->mahasiswa->semester,
                'materi'    => $item->materi,
                'status'    => $item->janjitemu->status,
            ];
        });

        return $this->sendResponse($display, 'Sukses mengambil data');
    }


    //display mahasiswa bimbingan
    public function mhs_bimbingan()
    {
        // Ambil data janji temu berdasarkan nip dosen
        $nip = Auth::user()->id;

        $dosen = Dosen::where('nip', $nip)
        ->with(
            'mahasiswa:nim,nama,no_hp,semester,nip'
        )->first(['nama','nip']);

        // Sembunyikan nip pada relasi mahasiswa
        foreach($dosen->mahasiswa as $mahasiswa) {
            $mahasiswa->makeHidden(['nip']);
        }

        return $this->sendResponse($dosen, 'Sukses mengambil data');
    }

    //display rekomendasi
    public function rekomendasi()
    {
        $nip = Auth::user()->id;

        // Ambil data mahasiswa beserta rekomendasi terkait
        $data = Mahasiswa::where('nip', $nip)
            ->with(['rekomendasi:id,nim,keterangan,tanggal_pengajuan']) // Menyederhanakan relasi
            ->get(['nim', 'nama', 'no_hp', 'semester']);

        // Cek apakah data mahasiswa ada
        if ($data->isEmpty()) {
            return $this->sendError('Data tidak ditemukan');
        }

        // Sembunyikan atribut tertentu pada model rekomendasi
        $data->each(function ($mahasiswa) {
            $mahasiswa->rekomendasi->each(function ($rekomendasi) {
                $rekomendasi->makeHidden(['nim', 'jenis_rekomendasi', 'tanggal_persetujuan', 'status']);
            });

            // Cek apakah mahasiswa sudah mengajukan rekomendasi 'SO' dan 'DO'
            $rekomendasiTypes = $mahasiswa->rekomendasi->pluck('jenis_rekomendasi')->toArray();

            // Tambahkan atribut can_ajukan
            $mahasiswa->can_ajukan_so = !in_array('SO', $rekomendasiTypes);
            $mahasiswa->can_ajukan_do = !in_array('DO', $rekomendasiTypes);

            // Sembunyikan atribut can_ajukan
            $mahasiswa->makeHidden(['can_ajukan_so', 'can_ajukan_do']);
        });

        // Kembalikan data dengan pesan sukses
        return $this->sendResponse($data, 'Sukses mengambil data');
    }

    //form janji temu
    public function janji_temu_create(Request $request)
    {
        $nip = Auth::user()->id;

        $data = $request->validate([
            'nim' => 'required',
            'tanggal' => 'required',
            'materi' => 'required',
        ]);

        JanjiTemu::create([
            'nim' => $request->nim,
            'tanggal' => $request->tanggal,
            'materi' => $request->materi,
            'status' => 'Disetujui'
        ]);

        return $this->sendResponse($data, 'Sukses Membuat Data untuk mahasiswa yang dipilih!');
    }
}
