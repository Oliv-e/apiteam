<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SibaperController;
use App\Http\Controllers\Api\BeritaAcaraController;
use App\Http\Controllers\Api\DosenController;
use App\Http\Controllers\Api\JadwalController;
use App\Http\Controllers\Api\KelasController;
use App\Http\Controllers\Api\MatkulController;
use App\Http\Controllers\Api\RuangController;
use App\Http\Controllers\Api\RpsController;

Route::get('/', function() {
    return redirect()->route('api-data-sibaper');
});
Route::get('/data/homepage', [SibaperController::class, 'Homepage'])->name('api-data-sibaper-homepage');
Route::get('/data/historypage', [SibaperController::class, 'Historypage'])->name('api-data-sibaper');
Route::post('/data/BeritaAcara/tambah', [SibaperController::class, 'berita_acara_create']);


Route::get('/data/kelas', [SibaperController::class , 'kelas'])->name('api-data-kelas-sibaper');
Route::post('/data/Kelas/tambah', [KelasController::class , 'kelas'])->name('api-data-kelas-sibaper-tambah');

Route::get('/data/Dosen', [DosenController::class , 'dosen'])->name('api-data-dosen-sibaper');
Route::post('/data/Dosen/tambah', [DosenController::class , 'dosen'])->name('api-data-dosen-sibaper-tambah');

Route::get('/data/Jadwal', [JadwalController::class , 'jadwal'])->name('api-data-jadwal-sibaper');
Route::post('/data/Jadwal/tambah', [JadwalController::class , 'jadwal'])->name('api-data-jadwal-sibaper-tambah');

Route::get('/data/Matkul', [MatkulController::class , 'matkul'])->name('api-data-matkul-sibaper');
Route::post('/data/matkul/tambah', [MatkulController::class , 'matkul'])->name('api-data-matkul-sibaper-tambah');

Route::get('/data/ruang', [RuangController::class , 'ruang'])->name('api-data-ruang-sibaper');
Route::post('/data/ruang/tambah', [RuangController::class , 'ruang'])->name('api-data-ruang-sibaper-tambah');

Route::get('/kelas-by-dosen-by-today', [SibaperController::class, 'kelas_by_dosen_today']);

// // Route::get('/data/BeritaAcara/show/{id}', [BeritaAcaraController::class, 'berita_acara_show']);
// Route::get('/data/BeritaAcara', [BeritaAcaraController::class , 'berita_acara'])->name('api-data-berita-acara-sibaper');
// Route::post('/data/BeritaAcara/tambah', [BeritaAcaraController::class , 'berita_acara_create'])->name('api-data-berita-acara-sibaper-tambah');
// Route::post('/data/BeritaAcara/update/{nip}', [BeritaAcaraController::class, 'berita_acara_update']);
// Route::delete('/data/BeritaAcara/hapus/{nip}', [BeritaAcaraController::class, 'berita_acara_hapus']);


Route::get('/data/rps', [RpsController::class, 'index']); // Untuk mengambil semua data RPS
Route::get('rps/{id}', [RpsController::class, 'show']); // Untuk mengambil data RPS berdasarkan ID