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
    //tampilkan data konsultasi-ermintaan janji temu
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
    public function janji_temu()
    {
        $nip = Auth::user()->id;

        $data = Mahasiswa::where('nip', $nip)
            ->with([
                'janji_temu' => function ($query) {
                    $query->select([
                        'id', 'nim', 'tanggal', 'materi'
                    ]);
                }
            ])->get(['nim', 'nama', 'no_hp', 'semester']);
        
        if ($data->isEmpty()) {
            return $this->sendError('Data tidak ditemukan');
        }

        // Hide 'nim' in the JanjiTemu model for each Mahasiswa
        $data->each(function ($mahasiswa) {
            $mahasiswa->janji_temu->makeHidden(['nim']);
        });

        // Return the data with a success message
        return $this->sendResponse($data, 'Sukses mengambil data');
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
    // public function janji_temu_create(Request $request)
    // {
    //     $nip = Auth::user()->id;

    //     $data = $request->validate([
    //         'nim' => 'required',
    //         'tanggal' => 'required',
    //         'materi' => 'required',
    //         'status' => 'required'
    //     ]);

    //     JanjiTemu::create([
    //         'nim' => $request->nim,
    //         'tanggal' => $request->tanggal,
    //         'materi' => $request->materi,
    //         'status' => $request->status
    //     ]);

    //     return $this->sendResponse($data, 'Sukses Membuat Data untuk mahasiswa yang dipilih!');
    // }

    //form janji temu mhs all or array
    use Illuminate\Database\Eloquent\ModelNotFoundException;

    public function janji_temu_create(Request $request)
    {
        $nip = Auth::user()->id; // Ambil ID dosen yang sedang login

        $data = $request->validate([
            'nim' => 'nullable|array', // Nim bisa berupa array atau null (jika untuk semua mahasiswa)
            'tanggal' => 'required|date',
            'materi' => 'required',
            'status' => 'nullable|string' // Status bisa null dan default menjadi 'Aktif'
        ]);

        $status = $request->status ?? 'Aktif'; // Jika status tidak diisi, default ke 'Aktif'

        // Jika nim tidak diisi, buat janji untuk semua mahasiswa bimbingan dosen
        $mhs = empty($data['nim']) ? $this->getAllStudentsForLecturer($nip) : $data['nim'];

        // Cek jika tidak ada mahasiswa ditemukan
        if (empty($mhs)) {
            return $this->sendError('Tidak ada mahasiswa ditemukan untuk NIP ini.', 404);
        }

        // Gunakan Eloquent untuk menangani transaksi
        try {
            foreach ($mhs as $nim) {
                JanjiTemu::create([
                    'nim' => $nim,
                    'tanggal' => $request->tanggal,
                    'materi' => $request->materi,
                    'status' => $status
                ]);
            }
        } catch (\Exception $e) {
            return $this->sendError('Gagal membuat janji temu: ' . $e->getMessage(), 500);
        }

        return $this->sendResponse($data, 'Sukses Membuat Data untuk mahasiswa yang dipilih!');
    }

    private function getAllStudentsForLecturer($nip)
    {
        // Fungsi untuk mengambil semua mahasiswa bimbingan dosen berdasarkan NIP
        $students = Mahasiswa::where('nip', $nip)->pluck('nim')->toArray();

        if (empty($students)) {
            // Handle the case where no students are found
            return []; // atau handle sesuai kebutuhan
        }

        return $students;
    }
}
