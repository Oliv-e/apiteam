<?php

namespace App\Http\Controllers\Api\RPS;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\JadwalPelaksanaan;
use Illuminate\Support\Facades\Auth;

class JadwalController extends BaseController
{
    public function jadwal_pelaksanaan(Request $request) {
        try {
            // Mengambil semua data RPS dari database
            $data = Jadwalpelaksanaan::all();

            // Jika data berhasil ditemukan, kembalikan dengan pesan sukses
            return $this->sendResponse($data, 'Data RPS berhasil ditampilkan');
        } catch (\Exception $e) {
            // Jika terjadi error, kembalikan pesan error
            return $this->sendError('Gagal menampilkan data RPS', $e->getMessage());
        }
    }

    public function jadwal_pelaksanaan_create(Request $request){
        try {
            $nip = Auth::user()->id;
            
            // validasi input yang diterima
            $data = $request->validate([
                'minggu_ke' => 'required',
                'waktu' => 'required',
                'cp_tahapan_matkul' => 'required',
                'bahan_kajian' => 'required',
                'sub_bahan_kajian' => 'required',
                'bentuk_pembelajaran' => 'required',
                'kriteria_penilaian' => 'required',
                'pengalaman_belajar' => 'required',
                'bobot_materi' => 'required',
                'referensi' => 'required',

            ]);

            JadwalPelaksanaan::create([
                //'id_jadwal' => $request->id_jadwal,
                'minggu_ke' => $request->minggu_ke,
                'waktu' => $request->waktu,
                'cp_tahapan_matkul' => $request->cp_tahapan_matkul,
                'bahan_kajian' => $request->bahan_kajian,
                'sub_bahan_kajian' => $request->sub_bahan_kajian,
                'bentuk_pembelajaran' => $request->bentuk_pembelajaran,
                'kriteria_penilaian' => $request->kriteria_penilaian,
                'pengalaman_belajar' => $request->pengalaman_belajar,
                'bobot_materi' => $request->bobot_materi,
                'referensi' => $request->referensi,
            ]);

             return $this->sendResponse($data, 'Data jadwal pelaksanaan berhasil ditambahkan');
        } catch (\Exception $e) {
            return $this->sendError('Gagal menambahkan jadwal pelaksanaan', $e->getMessage());
        }
    }

    public function Jadwal_Pelaksanaan_update(Request $request, $id) {
        try {
            // Validasi input yang diterima
            $data = $request->validate([
                'minggu_ke' => 'required',
                'cp_tahapan_matkul' => 'required',
                'bahan_kajian' => 'required',
                'sub_bahan_kajian' => 'required',
                'bentuk_pembelajaran' => 'required',
                'kriteria_penilaian' => 'required',
                'pengalaman_belajar' => 'required',
                'bobot_materi' => 'required',
                'referensi' => 'required',

            ]);

            // Cari data RPS berdasarkan ID yang sesuai
            $rps = JadwalPelaksanaan::where('id', $id)->first();

            // Cek apakah dosen yang login adalah dosen yang memiliki matkul ini
            // if ($rps->dosen !== auth()->user()->id) { // Mengasumsikan auth()->user()->id memberikan ID dosen yang login
            //     return $this->sendError('Anda tidak memiliki izin untuk memperbarui data ini.');
            // }

            // Update data yang ditemukan dengan data baru
            $rps->update($data);

            // Kembalikan response sukses
            return $this->sendResponse($rps, 'Data RPS berhasil diperbarui');
        } catch (\Exception $e) {
            return $this->sendError('Gagal memperbarui data RPS', $e->getMessage());
        }
    }

    public function jadwal_pelaksanaan_delete($id) {
        try {
            // Cari data RPS berdasarkan ID
            $rps = JadwalPelaksanaan::find($id);

            // Jika data tidak ditemukan, kembalikan pesan error
            if (!$rps) {
                return $this->sendError('Jadwal tidak ditemukan.');
            }

            // Hapus jadwal RPS yang ditemukan
            $rps->delete();

            // Kembalikan response sukses
            return $this->sendResponse([], 'Jadwal berhasil dihapus');
        } catch (\Exception $e) {
            return $this->sendError('Gagal menghapus jadwal', $e->getMessage());
        }
    }
}
