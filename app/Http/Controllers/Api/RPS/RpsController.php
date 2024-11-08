<?php

namespace App\Http\Controllers\Api\RPS;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\Rps;

class RpsController extends BaseController
{
    // Fungsi untuk mengambil data RPS
    public function index() {
        try {
            // Mengambil data dengan relasi 'dosen' dan 'matkul'
            $data = Rps::select([
                'nip',
                'kode_matkul',
                'id_referensi',
                'deskripsi',
                'cp_prodi',
                'cp_matkul',
                'bobot_penilaian',
                'metode_penilaian',
                'minggu_ke',
                'waktu',
                'tanggal_pembuatan',
                'status_persetujuan',
                'tanggal_persetujuan'
            ])->with([
                'dosen' => function ($q) {
                    // Memilih kolom 'nama' dan 'jabatan' dari relasi dosen
                    $q->select(['nip', 'nama']);
                },
                'matkul' => function ($q) {
                    // Memilih kolom 'kode_matkul' dan 'nama_matkul' dari relasi matkul
                    $q->select(['kode_matkul', 'nama']);
                }
            ])->get();

            return $this->sendResponse($data, 'Sukses mengambil data');
        } catch (\Exception $e) {
            return $this->sendError('Gagal mengambil data', $e->getMessage());
        }
    }

    // Fungsi untuk membuat data rekomendasi baru
    public function create(Request $request) {
        try {
            // Validasi input yang diterima
            $data = $request->validate([
                'nip' => 'required',
                'kode_matkul' => 'required',
                'id_referensi' => 'required',
                'deskripsi' => 'required',
                'cp_prodi' => 'required',
                'cp_matkul' => 'required',
                'bobot_penilaian' => 'required',
                'metode_penilaian' => 'required',
                'minggu_ke' => 'required|integer',
                'waktu' => 'required|integer',
                'cp_tahapan_matkul' => 'required',
                'bahan_kajian' => 'required',
                'sub_bahan_kajian' => 'required',
                'bentuk_pembelajaran' => 'required',
                'bahan_pembelajaran' => 'required',
                'kriteria_penilaian' => 'required',
                'bobot_materi' => 'required',
                'tanggal_pembuatan' => 'required|date',
                'status_persetujuan' => 'required',
                'tanggal_persetujuan' => 'required|date'
            ]);

            // Membuat data baru berdasarkan input yang divalidasi
            Rps::create([
                'nip' => $request->nip,
                'kode_matkul' => $request->kode_matkul,
                'id_referensi' => $request->id_referensi,
                'deskripsi' => $request->deskripsi,
                'cp_prodi' => $request->cp_prodi,
                'cp_matkul' => $request->cp_matkul,
                'bobot_penilaian' => $request->bobot_penilaian,
                'metode_penilaian' => $request->metode_penilaian,
                'minggu_ke' => $request->minggu_ke,
                'waktu' => $request->waktu,
                'cp_tahapan_matkul' => $request->cp_tahapan_matkul,
                'bahan_kajian' => $request->bahan_kajian,
                'sub_bahan_kajian' => $request->sub_bahan_kajian,
                'bentuk_pembelajaran' => $request->bentuk_pembelajaran,
                'bahan_pembelajaran' => $request->bahan_pembelajaran,
                'kriteria_penilaian' => $request->kriteria_penilaian,
                'bobot_materi' => $request->bobot_materi,
                'tanggal_pembuatan' => $request->tanggal_pembuatan,
                'status_persetujuan' => $request->status_persetujuan,
                'tanggal_persetujuan' => $request->tanggal_persetujuan
            ]);

            return $this->sendResponse($data, 'Data RPS berhasil dibuat');
        } catch (\Exception $e) {
            return $this->sendError('Gagal membuat data RPS', $e->getMessage());
        }
    }

    // Fungsi untuk mengambil satu data RPS berdasarkan id (Read Single)
    public function show($id) {
        try {
            $rps = Rps::with(['dosen', 'matkul'])->find($id);
            if (is_null($rps)) {
                return $this->sendError('Data RPS tidak ditemukan');
            }
            return $this->sendResponse($rps, 'Sukses mengambil data');
        } catch (\Exception $e) {
            return $this->sendError('Gagal mengambil data', $e->getMessage());
        }
    }

    // Fungsi untuk memperbarui data RPS (Update)
    public function update(Request $request, $id) {
        try {
            // Validasi input yang diterima
            $data = $request->validate([
                'nip' => 'required',
                'kode_matkul' => 'required',
                'id_referensi' => 'required',
                'deskripsi' => 'required',
                'cp_prodi' => 'required',
                'cp_matkul' => 'required',
                'bobot_penilaian' => 'required',
                'metode_penilaian' => 'required',
                'minggu_ke' => 'required|integer',
                'waktu' => 'required|integer',
                'cp_tahapan_matkul' => 'required',
                'bahan_kajian' => 'required',
                'sub_bahan_kajian' => 'required',
                'bentuk_pembelajaran' => 'required',
                'kriteria_penilaian' => 'required',
                'bobot_materi' => 'required',
                'tanggal_pembuatan' => 'required|date',
                'status_persetujuan' => 'required',
                'tanggal_persetujuan' => 'required|date'
            ]);

            // Menemukan data RPS berdasarkan id
            $rps = Rps::find($id);
            if (is_null($rps)) {
                return $this->sendError('Data RPS tidak ditemukan');
            }

            // Memperbarui data
            $rps->update($data);

            return $this->sendResponse($rps, 'Data RPS berhasil diperbarui');
        } catch (\Exception $e) {
            return $this->sendError('Gagal memperbarui data RPS', $e->getMessage());
        }
    }

    // Fungsi untuk menghapus data RPS (Delete)
    public function delete($id) {
        try {
            // Menemukan data RPS berdasarkan id
            $rps = Rps::findOrFail($id);
            if (is_null($rps)) {
                return $this->sendError('Data RPS tidak ditemukan');
            }

            // Menghapus data
            $rps->delete();

            return $this->sendResponse([], 'Data RPS berhasil dihapus');
        } catch (\Exception $e) {
            return $this->sendError('Gagal menghapus data RPS', $e->getMessage());
        }
    }


    // fungsi untuk mengampil data infomarsi matakuliah

    //tampilkan jadwal pelaksanaan

}
