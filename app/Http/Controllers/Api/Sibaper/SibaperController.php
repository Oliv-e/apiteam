<?php

namespace App\Http\Controllers\Api\Sibaper;

use App\Http\Controllers\Api\BaseController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\BeritaAcara;
use App\Models\JadwalPelaksanaan;
use App\Models\jadwal;
use App\Models\ruang;
use App\Models\Dosen;
use App\Models\Rps;
use Illuminate\Support\Facades\Auth;


class SibaperController extends BaseController
{
    public function Homepage()
    {
        $nip = Auth::user()->id;

        // Ambil data BeritaAcara berdasarkan NIP pengguna yang terautentikasi
        $data = BeritaAcara::select([
                'berita_acara.nip',
                'jadwal.start',
                'jadwal.finish',
                'kelas.abjad_kelas',
                'matkul.nama AS nama_matkul',
                'dosen.nama AS nama_dosen'
            ])
            ->join('dosen', 'berita_acara.nip', '=', 'dosen.nip')
            ->join('jadwal', 'berita_acara.id_jadwal', '=', 'jadwal.id_jadwal')
            ->join('kelas', 'jadwal.id_kelas', '=', 'kelas.id_kelas')
            ->join('infomatkul', 'infomatkul.kode_matkul', '=', 'jadwal.kode_matkul')
            ->join('matkul', 'jadwal.kode_matkul', '=', 'matkul.kode_matkul')
            ->where('infomatkul.nip', $nip) // Sesuaikan dengan nip di infomatkul
            ->get();

        // Cek apakah data kosong
        if ($data->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        // Kembalikan respons sukses
        return $this->sendResponse($data, 'Sukses mengambil data');
    }

    // display historypage
    public function Historypage() {
        $nip = Auth::user()->id;

        // Ambil data BeritaAcara berdasarkan NIP pengguna yang terautentikasi
        $data = BeritaAcara::select([
                'jadwal_pelaksanaan.minggu_ke',
                'matkul.nama AS nama_matkul',
                'jadwal_pelaksanaan.bahan_kajian',
                'jadwal_pelaksanaan.sub_bahan_kajian',
                'berita_acara.status'
            ])
            ->join('dosen', 'berita_acara.nip', '=', 'dosen.nip')
            ->join('jadwal', 'berita_acara.id_jadwal', '=', 'jadwal.id_jadwal')
            ->join('kelas', 'jadwal.id_kelas', '=', 'kelas.id_kelas')
            ->join('infomatkul', 'jadwal.kode_matkul', '=', 'infomatkul.kode_matkul') // Join infomatkul
            ->join('matkul', 'jadwal.kode_matkul', '=', 'matkul.kode_matkul')
            ->join('jadwal_pelaksanaan', 'infomatkul.id', '=', 'jadwal_pelaksanaan.id') // Join to get minggu_ke
            ->where('infomatkul.nip', $nip) // Sesuaikan dengan nip di infomatkul
            ->where('berita_acara.status', ['onprocess', 'complete']) // Filter status
            ->get();

        // Cek apakah data kosong
        if ($data->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        // Kembalikan respons sukses
        return $this->sendResponse($data, 'Sukses mengambil data');
    }


    public function berita_acara_create(Request $request)
    {
        // auth user dengan ni[]
        $nip = Auth::user()->id;

        // validasi data
        $data = $request->validate([
            'id_jadwal' => 'required', // Validasi id_jadwal ada di tabel jadwal_pelaksanaan
            'minggu_ke' => 'required',
            'jam_ajar' => 'required',
            'status' => 'required|in:onprocess,complete,notstarted', // Validasi status
        ]);

        // Ambil data dari jadwal pelaksanaan dan infomatkul
        $jadwal = JadwalPelaksanaan::with(['infomatkul' => function($query) {
            $query->with(['matkul', 'kelas']);
        }])
        ->where('id', $data['id_jadwal'])
        ->first();

        // Cek apakah jadwal ada
        if (!$jadwal) {
            return $this->sendError('Jadwal pelaksanaan tidak ditemukan.', 404);
        }

        // Siapkan data untuk ditampilkan
        $beritaAcaraDetails = [
            'tanggal' => now()->format('Y-m-d'), // Tanggal sekarang
            'minggu_ke' => $data['minggu_ke'], // Minggu ke dari request
            'abjad_kelas' => $jadwal->infomatkul->kelas->abjad_kelas ?? 'N/A', // Abjad kelas
            'semester' => $jadwal->infomatkul->semester ?? 'N/A', // Semester
            'bahan_kajian' => $jadwal->infomatkul->bahan_kajian ?? 'N/A', // Bahan kajian
            'sub_bahan_kajian' => $jadwal->infomatkul->sub_bahan_kajian ?? 'N/A', // Sub bahan kajian
            'bentuk_pembelajaran' => $jadwal->bentuk_pembelajaran, // Bentuk pembelajaran
        ];

        // tampilkan informasi data yg diambil
        $response = [
            'data' => $beritaAcaraDetails,
            'message' => 'Data berhasil diambil.'
        ];

        // Jika ingin langsung menambahkan BeritaAcara setelah menampilkan data, Anda bisa menambahkan logika berikut
        $beritaacara = BeritaAcara::create([
            'nip' => $nip, // Automatically use the logged-in user's NIP
            'id_jadwal' => $jadwal->id, // Use validated data
            'id_rps' => $jadwal->infomatkul->id, // Ambil ID dari infomatkul
            'tanggal' => now()->format('Y-m-d'), // Gunakan tanggal sekarang
            'media' => $jadwal->bentuk_pembelajaran, // Isi media dengan bentuk pembelajaran
            'jam_ajar' => $data['jam_ajar'], // Isi jam_ajar
            'minggu_ke' => $data['minggu_ke'], // Gunakan minggu_ke dari request
            'status' => $data['status'], // Status yang divalidasi
        ]);

        // Tambahkan detail berita acara ke respons
        $response['berita_acara'] = $beritaacara;

        return $this->sendResponse($response, 'Sukses membuat Data!');
    }
 }
