<?php

namespace App\Http\Controllers\Api\RPS;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\Infomatkul;
use App\Models\Jabatan;
use App\Models\Dosen;
use App\Models\Matkul;
use Illuminate\Support\Facades\Auth;

class MatkulController extends BaseController
{
    //tampilkan my rps
    public function my_rps(Request $request) {
        try {
            $nip = Auth::user()->id;
             
            // // Mengambil semua data RPS dari database
            // $data = Infomatkul::all();
            
            // Ambil semua nilai nim mahasiswa yang terkait dengan nip dosen yang sedang login
            $dosen = Dosen::where('nip', $nip);
    
            // Query untuk mengambil data dari Infomatkul dan join dengan Matkul
            $data = Infomatkul::select([
                'infomatkul.id',
                'matkul.nama',
                'infomatkul.kode_matkul',
                'infomatkul.semester',
                'infomatkul.sks',
            ])
            ->join('matkul', 'infomatkul.kode_matkul', '=', 'matkul.kode_matkul') // Join tabel Matkul
            ->where('infomatkul.nip', $nip)
            ->where('infomatkul.status', 'disetujui')
            ->get();

            // Jika data berhasil ditemukan, kembalikan dengan pesan sukses
            return $this->sendResponse($data, 'Data My RPS berhasil ditampilkan');
        } catch (\Exception $e) {
            // Jika terjadi error, kembalikan pesan error
            return $this->sendError('Gagal menampilkan data My RPS', $e->getMessage());
        }
    }
    
    //tampilkan library
    public function library(Request $request) {
        try {
            $nip = Auth::user()->id;
             
            // Mengambil semua data RPS dari database
            $data = Infomatkul::all();
            
            // Ambil semua nilai nim mahasiswa yang terkait dengan nip dosen yang sedang login
            // $dosen = Dosen::where('nip', $nip);
    
            // Query untuk mengambil data dari Infomatkul dan join dengan Matkul
            $data = Infomatkul::select([
                'infomatkul.id',
                'matkul.nama',
                'infomatkul.kode_matkul',
                'infomatkul.semester',
                'infomatkul.sks',
            ])
            ->join('matkul', 'infomatkul.kode_matkul', '=', 'matkul.kode_matkul') // Join tabel Matkul
            // ->where('infomatkul.nip', $nip)
            ->where('infomatkul.status', 'disetujui')
            ->get();

            // Jika data berhasil ditemukan, kembalikan dengan pesan sukses
            return $this->sendResponse($data, 'Data Library berhasil ditampilkan');
        } catch (\Exception $e) {
            // Jika terjadi error, kembalikan pesan error
            return $this->sendError('Gagal menampilkan data Library', $e->getMessage());
        }
    }
    
    
    // tampilkan daftar acc yg perlu di acc kaprodi
    public function daftarRps(Request $request) {
        try {
            // Mendapatkan nip dari user yang sedang login
            $nip = Auth::user()->id;
    
            // Mengecek apakah dosen tersebut adalah kaprodi
            $isKaprodi = Jabatan::where('nip', $nip)->value('is_kaprodi');
    
            // Jika dosen bukan kaprodi, kembalikan pesan error
            if (!$isKaprodi) {
                return $this->sendError('Akses ditolak: Anda bukan kaprodi.');
            }
    
            // Query untuk mengambil data dari Infomatkul
            $data = Infomatkul::select([
                'infomatkul.id',
                'infomatkul.kode_matkul',
                'matkul.nama AS nama_matkul',
                'dosen.nama AS nama_dosen',
                'infomatkul.status',
                'infomatkul.keterangan'
            ])
            ->join('matkul', 'infomatkul.kode_matkul', '=', 'matkul.kode_matkul')
            ->join('dosen', 'infomatkul.nip', '=', 'dosen.nip')
            ->where('infomatkul.status', '!=', 'disetujui')
            ->get();
    
            // Jika tidak ada data
            if ($data->isEmpty()) {
                return $this->sendError('Tidak ada data yang ditemukan.');
            }
    
            // Cek jika ada permintaan untuk menyetujui atau menolak
            if ($request->has('action')) {
                $action = $request->input('action'); // Ambil nilai action
                $idInfomatkul = $request->input('id');
    
                // Temukan Infomatkul berdasarkan ID
                $infomatkul = Infomatkul::find($idInfomatkul);
    
                if (!$infomatkul) {
                    return $this->sendError('Infomatkul tidak ditemukan.');
                }
    
                // Proses penolakan
                if ($action === 'tidak disetujui') {
                    if (!$request->has('keterangan')) {
                        return $this->sendError('Keterangan harus diisi saat menolak.');
                    }
                    // Update status dan keterangan saat menolak
                    $infomatkul->status = 'tidak disetujui';
                    $infomatkul->keterangan = $request->input('keterangan');
                }
                // Proses persetujuan
                else if ($action === 'disetujui') {
                    // Update status saat menyetujui
                    $infomatkul->status = 'disetujui';
                    $infomatkul->keterangan = null; // Kosongkan keterangan saat disetujui
                } else {
                    return $this->sendError('Aksi tidak dikenali.');
                }
    
                // Simpan perubahan
                if (!$infomatkul->save()) {
                    return $this->sendError('Gagal menyimpan perubahan.');
                }
    
                return $this->sendResponse($infomatkul, $action === 'tidak disetujui' ? 'Infomatkul ditolak dengan keterangan.' : 'Infomatkul berhasil disetujui.');
            }
    
            // Kembalikan data
            return $this->sendResponse($data, 'Data RPS berhasil ditampilkan');
        } catch (\Exception $e) {
            return $this->sendError('Gagal menampilkan data RPS', $e->getMessage());
        }
    }

    //dashboard jumlah rps
    public function dashboard(Request $request) {
        try {
            // Hitung total Infomatkul
            $totalInfomatkul = Infomatkul::count();
    
            // Hitung Infomatkul yang belum disetujui (status 'proses')
            $belumDisetujui = Infomatkul::where('status', 'proses')->count();
    
            // Hitung Infomatkul yang sudah disetujui (status 'disetujui')
            $sudahDisetujui = Infomatkul::where('status', 'disetujui')->count();
    
            // Kembalikan hasil sebagai respons
            return $this->sendResponse([
                'total_infomatkul' => $totalInfomatkul,
                'belum_disetujui' => $belumDisetujui,
                'sudah_disetujui' => $sudahDisetujui,
            ], 'Data jumlah Infomatkul berhasil dihitung');
        } catch (\Exception $e) {
            // Jika terjadi error, kembalikan pesan error
            return $this->sendError('Gagal menghitung jumlah Infomatkul', $e->getMessage());
        }
    }


    //tambah infomatkul
    public function infomatkul_create(Request $request) {
        try {
            $nip = Auth::user()->id;
    
            // Ambil data dosen berdasarkan nip
            $dosen = Dosen::where('nip', $nip)->first();
            if (!$dosen) {
                return $this->sendError('Dosen tidak ditemukan');
            }
            
            
            // Menampilkan nama dosen di sini (misalnya, dalam log, atau mempersiapkan variabel untuk tampilan)
            $namaDosen = $dosen->nama;
            // Anda bisa menggunakan $namaDosen di tampilan Anda sesuai kebutuhan
    
            // Validasi input yang diterima
            $data = $request->validate([
                'kode_matkul' => 'required|unique:matkul,kode_matkul',
                'nama' => 'required|string|max:255',
                'semester' => 'required',
                'sks' => 'required|integer',
                'deskripsi' => 'required',
                'cp_prodi' => 'required',
                'cp_matkul' => 'required',
                'bobot_penilaian' => 'required',
                'metode_penilaian' => 'required',
                'buku_referensi' => 'required',
            ]);
    
            // Simpan data ke tabel matkul
            $matkul = Matkul::create([
                'kode_matkul' => $data['kode_matkul'],
                'nama' => $data['nama'],
                'semester' => $data['semester'],
                'sks' => $data['sks'],
            ]);
    
            // Simpan data ke tabel infomatkul
            Infomatkul::create([
                'kode_matkul' => $matkul->kode_matkul,
                'semester' => $matkul->semester,
                'nip' => $nip,
                'sks' => $matkul->sks,
                'deskripsi' => $data['deskripsi'],
                'cp_prodi' => $data['cp_prodi'],
                'cp_matkul' => $data['cp_matkul'],
                'bobot_penilaian' => $data['bobot_penilaian'],
                'metode_penilaian' => $data['metode_penilaian'],
                'buku_referensi' => $data['buku_referensi'],
                'nama_dosen' => $dosen->nama, // Menyimpan nama dosen
            ]);
    
            // Respons sukses tanpa menyertakan nama dosen
            return $this->sendResponse($data, 'Info mata kuliah berhasil ditambahkan');
        } catch (\Exception $e) {
            return $this->sendError('Gagal menyimpan data!', $e->getMessage());
        }
    }


    
    //detail rps
    public function detail_rps(Request $request, $id) {
        try {
            $nip = Auth::user()->id; // Ambil NIP dari pengguna yang terautentikasi
    
            // Query untuk mengambil data dari Infomatkul berdasarkan ID, status, dan NIP
            $data = Infomatkul::select([
                'id',
                'kode_matkul',
                'semester',
                'sks',
                'deskripsi',
                'cp_prodi',
                'cp_matkul',
                'bobot_penilaian',
                'metode_penilaian',
                'buku_referensi',
            ])
            ->where('id', $id) // Filter berdasarkan ID
            ->where('nip', $nip) // Filter berdasarkan NIP dosen yang sedang login
            ->where('status', 'disetujui') // Filter berdasarkan status yang disetujui
            ->first();
    
            if (!$data) {
                return $this->sendError('Data tidak ditemukan!', 'ID atau status tidak valid.');
            }
    
            // Jika data berhasil ditemukan, kembalikan dengan pesan sukses
            return $this->sendResponse($data, 'Data Infomatkul berhasil ditampilkan');
        } catch (\Exception $e) {
            // Jika terjadi error, kembalikan pesan error
            return $this->sendError('Gagal menampilkan data Infomatkul', $e->getMessage());
        }
    }
    
    //update data rps berdasarkan id
    public function infomatkul_update(Request $request, $id) {
        try {
            $nip = Auth::user()->id;
            
            // Cari data infomatkul berdasarkan ID dan validasi akses
            $infomatkul = Infomatkul::where('id', $id)
                ->where('nip', $nip)
                ->where('status', 'disetujui')
                ->first();
    
            if (!$infomatkul) {
                return $this->sendError('Info mata kuliah tidak ditemukan!', 'ID tidak valid atau akses ditolak.');
            }
    
            // Validasi input yang diterima
            $data = $request->validate([
                'kode_matkul' => 'required',
                'nama' => 'required',
                'semester' => 'required',
                'sks' => 'required|integer',
                // 'deskripsi' => 'required',
                // 'cp_prodi' => 'required',
                // 'cp_matkul' => 'required',
                // 'bobot_penilaian' => 'required',
                // 'metode_penilaian' => 'required',
                // 'buku_referensi' => 'required',
            ]);
    
            // Update data di tabel infomatkul
            $infomatkul->update([
                'kode_matkul' => $data['kode_matkul'],
                'semester' => $data['semester'],
                'sks' => $data['sks'],
                // 'deskripsi' => $data['deskripsi'],
                // 'cp_prodi' => $data['cp_prodi'],
                // 'cp_matkul' => $data['cp_matkul'],
                // 'bobot_penilaian' => $data['bobot_penilaian'],
                // 'metode_penilaian' => $data['metode_penilaian'],
                // 'buku_referensi' => $data['buku_referensi'],
            ]);
    
            // Jika ada tabel matkul yang juga perlu diperbarui
            $matkul = Matkul::where('kode_matkul', $data['kode_matkul'])->first();
            if ($matkul) {
                // Update data di tabel matkul jika diperlukan
                $matkul->update([
                    'kode_matkul' => $data['kode_matkul'], // Simpan nama mata kuliah jika ada
                    'nama' => $data['nama'], // Simpan nama mata kuliah jika ada
                    'semester' => $data['semester'],
                    'sks' => $data['sks'],
                ]);
            }
    
            // Kembalikan respons dengan data yang diperbarui
            return $this->sendResponse($infomatkul, 'Data Infomatkul berhasil diperbarui.');
        } catch (\Exception $e) {
            return $this->sendError('Gagal memproses permintaan!', $e->getMessage());
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
