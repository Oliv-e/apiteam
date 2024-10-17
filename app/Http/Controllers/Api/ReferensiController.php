<?php

namespace App\Http\Controllers\Api;

use App\Models\Referensi;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;

class ReferensiController extends BaseController
{
    // Fungsi untuk mengambil semua data referensi
    public function index() {
        try {
            // Mengambil data referensi
            $data = Referensi::select([
                'id_referensi',
                'buku_referensi',
            ])->get();

            return $this->sendResponse($data, 'Sukses mengambil data');
        } catch (\Exception $e) {
            return $this->sendError('Gagal mengambil data', $e->getMessage());
        }
    }

    // Fungsi untuk membuat data referensi baru
    public function create(Request $request) {
        // Validasi input yang diterima
        $data = $request->validate([
            'buku_referensi' => 'required|string|max:255',
        ]);

        // Membuat data baru berdasarkan input yang divalidasi
        // $referensi = 
        Referensi::create([
            'buku_referensi' => $request -> buku_referensi
        ]);

        return $this->sendResponse($data, 'Data referensi berhasil dibuat');
        // try {
            
        // } catch (\Exception $e) {
        //     return $this->sendError('Gagal membuat data referensi', $e->getMessage());
        // }
    }

    // Fungsi untuk mengambil satu data referensi berdasarkan id (Read Single)
    public function show($id) {
        try {
            $referensi = Referensi::find($id);
            if (is_null($referensi)) {
                return $this->sendError('Data referensi tidak ditemukan');
            }
            return $this->sendResponse($referensi, 'Sukses mengambil data');
        } catch (\Exception $e) {
            return $this->sendError('Gagal mengambil data', $e->getMessage());
        }
    }

     // Fungsi untuk memperbarui data referensi (Update)
     public function update(Request $request, $id) {
        try {
            // Validasi input yang diterima
            $data = $request->validate([
                'buku_referensi' => 'required|string|max:255',
            ]);

            // Menemukan data referensi berdasarkan id
            $referensi = Referensi::find($id);
            if (is_null($referensi)) {
                return $this->sendError('Data referensi tidak ditemukan');
            }

            // Memperbarui data
            $referensi->update($data);

            return $this->sendResponse($referensi, 'Data referensi berhasil diperbarui');
        } catch (\Exception $e) {
            return $this->sendError('Gagal memperbarui data referensi', $e->getMessage());
        }
    }

    
    // Fungsi untuk menghapus data referensi (Delete)
    public function destroy($id) {
        try {
            // Menemukan data referensi berdasarkan id
            $referensi = Referensi::find($id);
            if (is_null($referensi)) {
                return $this->sendError('Data referensi tidak ditemukan');
            }

            // Menghapus data
            $referensi->delete();

            return $this->sendResponse([], 'Data referensi berhasil dihapus');
        } catch (\Exception $e) {
            return $this->sendError('Gagal menghapus data referensi', $e->getMessage());
        }
    }
}
