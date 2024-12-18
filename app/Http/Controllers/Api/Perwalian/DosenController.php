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
                'janji_temu' => function ($query) use ($nip) {
                    // Tampilkan hanya janji temu yang belum disetujui
                    $query->select(['id', 'nim', 'tanggal', 'materi', 'status'])
                          ->where('status', '!=', 'Disetujui');
                }
            ])
            ->get(['nim', 'nama']);

        if ($data->isEmpty()) {
            return $this->sendError('Data tidak ditemukan');
        }

        // Sembunyikan 'nim' di model JanjiTemu untuk setiap Mahasiswa
        $data->each(function ($mahasiswa) {
            $mahasiswa->janji_temu->makeHidden(['nim']);
        });

        // Jika ada permintaan untuk menyetujui janji temu
        if ($request->has('setujui')) {
            $id_jt = $request->setujui;

            // Temukan janji temu berdasarkan id yang diberikan
            $janjiTemu = JanjiTemu::where('id', $id_jt)->first();

            // Jika janji temu tidak ditemukan, kembalikan pesan error
            if (!$janjiTemu) {
                return $this->sendError('Janji temu tidak ditemukan');
            }

            // Update status janji temu menjadi 'Disetujui'
            $janjiTemu->update(['status' => 'Disetujui']);

            // Simpan data ke tabel Konsultasi tanpa kolom status
            $konsultasi = Konsultasi::create([
                'nim' => $janjiTemu->nim,
                'tanggal' => $janjiTemu->tanggal,
                'materi' => $janjiTemu->materi
            ]);
            $konsultasi->save();

            // Sembunyikan kolom tertentu sebelum dikembalikan sebagai respons
            $konsultasi->makeHidden(['created_at', 'updated_at']);

            // Kembalikan respons sukses setelah menyimpan data
            return $this->sendResponse($konsultasi, 'Data berhasil disimpan ke tabel Konsultasi dan janji temu disetujui');
        }

        // Kembalikan data permintaan janji temu yang belum disetujui
        return $this->sendResponse($data, 'Sukses mengambil data');
    }

    //display konsul
    public function konsul()
    {
    public function konsul()
    {
        // Ambil nip dari pengguna yang sedang login
        $nip = Auth::user()->id;

        // Ambil semua nilai nim mahasiswa yang terkait dengan nip dosen yang sedang login
        $mahasiswaNim = Mahasiswa::where('nip', $nip)->pluck('nim');

        // Query konsultasi berdasarkan nilai nim yang diambil
        $data = Konsultasi::select([
            'konsultasi.nim', // Menambahkan kolom nim untuk ditampilkan
            'konsultasi.tanggal',
            'konsultasi.materi',
        ])
        ->whereIn('konsultasi.nim', $mahasiswaNim)
        ->get();

        // Ambil data mahasiswa berdasarkan nim
        $mahasiswaData = Mahasiswa::with('kelas')
            ->whereIn('nim', $mahasiswaNim)
            ->get(['nim', 'nama', 'semester', 'no_hp', 'id_kelas']);

        // Format data untuk menyertakan field tambahan dalam respons
        $display = $data->map(function ($item) use ($mahasiswaData) {
            // Temukan data mahasiswa yang sesuai dengan nim dari konsultasi
            $mahasiswa = $mahasiswaData->firstWhere('nim', $item->nim);

            return [
                'nim'           => $mahasiswa->nim,
                'nama'          => $mahasiswa->nama,
                'no_hp'         => $mahasiswa->no_hp,
                'abjad_kelas'   => $mahasiswa->kelas ? $mahasiswa->kelas->abjad_kelas : null, // Ambil abjad_kelas dari relasi Kelas
                'tanggal'       => $item->tanggal,
                'semester'      => $mahasiswa->semester,
                'materi'        => $item->materi,
                'status'        => 'Disetujui', // Menetapkan status tetap 'Disetujui' jika diinginkan
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
        )->first(['nama', 'nip']);
        )->first(['nama', 'nip']);

        // Sembunyikan nip pada relasi mahasiswa
        foreach ($dosen->mahasiswa as $mahasiswa) {
        foreach ($dosen->mahasiswa as $mahasiswa) {
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

        Konsultasi::create([
            'nim' => $request->nim,
            'tanggal' => $request->tanggal,
            'materi' => $request->materi,
            'status' => 'Disetujui'
        ]);

        return $this->sendResponse($data, 'Sukses Membuat Data untuk mahasiswa yang dipilih!');
    }
}
