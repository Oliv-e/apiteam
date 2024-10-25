<?php

namespace App\Http\Controllers\Api\RPS;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\models\Infomatkul;

class MatkulController extends BaseController
{
    public function infomatkul(Request $request) {
        try {
            // Mengambil semua data RPS dari database
            $data = Infomatkul::all();

            // Jika data berhasil ditemukan, kembalikan dengan pesan sukses
            return $this->sendResponse($data, 'Data RPS berhasil ditampilkan');
        } catch (\Exception $e) {
            // Jika terjadi error, kembalikan pesan error
            return $this->sendError('Gagal menampilkan data RPS', $e->getMessage());
        }
    }


    public function infomatkul_create(Request $request) {
        try {
            // Validasi input yang diterima
            $data = $request->validate([
                'nama_matkul' => 'required',
                'kode_matkul' => 'required',
                'semester' => 'required',
                'dosen' => 'required',
                'sks' => 'required',
                'deskripsi' => 'required',
                'cp_prodi' => 'required',
                'cp_matkul' => 'required',
                'bobot_penilaian' => 'required',
                'metode_penilaian' => 'required',
                'buku_referensi' => 'required',

            ]);

            // Membuat data baru berdasarkan input yang validasi
            Infomatkul::create([
                'nama_matkul' => $request->nama_matkul,
                'kode_matkul' => $request->kode_matkul,
                'semester' => $request->semester,
                'dosen' => $request->dosen,
                'sks' => $request->sks,
                'deskripsi' => $request->deskripsi,
                'cp_prodi' => $request->cp_prodi,
                'cp_matkul' => $request->cp_matkul,
                'bobot_penilaian' => $request->bobot_penilaian,
                'metode_penilaian' => $request->metode_penilaian,
                'buku_referensi' => $request->buku_referensi,
            ]);

            return $this->sendResponse($data, 'Data RPS berhasil ditambahkan');
        } catch (\Exception $e) {
            return $this->sendError('Gagal menampilkan data RPS', $e->getMessage());
        }
    }

    public function infomatkul_update(Request $request, $id) {
        try {
            // Validasi input yang diterima
            $data = $request->validate([
                'nama_matkul' => 'required',
                'kode_matkul' => 'required',
                'semester' => 'required',
                'dosen' => 'required',
                'sks' => 'required',
                'deskripsi' => 'required',
                'cp_prodi' => 'required',
                'cp_matkul' => 'required',
                'bobot_penilaian' => 'required',
                'metode_penilaian' => 'required',
                'buku_referensi' => 'required',
            ]);

            // Cari data RPS berdasarkan ID yang sesuai
            $rps = Infomatkul::where('id', $id)->first();

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

    public function infomatkul_delete($id) {
        try {
            // Cari data RPS berdasarkan ID
            $rps = Infomatkul::find($id);

            // Jika data tidak ditemukan, kembalikan pesan error
            if (!$rps) {
                return $this->sendError('Data RPS tidak ditemukan.');
            }

            // Hapus data RPS yang ditemukan
            $rps->delete();

            // Kembalikan response sukses
            return $this->sendResponse([], 'Data RPS berhasil dihapus');
        } catch (\Exception $e) {
            return $this->sendError('Gagal menghapus data RPS', $e->getMessage());
        }
    }
}
