<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Sibaper\SibaperController;
use App\Http\Controllers\Api\Sibaper\BeritaAcaraController;
use App\Http\Controllers\Api\Sibaper\DosenController;
use App\Http\Controllers\Api\Sibaper\JadwalController;
use App\Http\Controllers\Api\Sibaper\KelasController;
use App\Http\Controllers\Api\Sibaper\MatkulController;
use App\Http\Controllers\Api\Sibaper\RuangController;
use App\Http\Controllers\Api\RPS\RpsController;

Route::get('/', function() {
    return redirect()->route('api-data-sibaper');
});
Route::get('/data/homepage', [SibaperController::class, 'Homepage']);
Route::get('/data/historypage', [SibaperController::class, 'Historypage']);
Route::post('/data/BeritaAcara/tambah', [SibaperController::class, 'berita_acara_create']);
Route::get('/kelas-by-dosen-by-today', [SibaperController::class, 'kelas_by_dosen_today']);
Route::get('/data/Jadwal', [JadwalController::class , 'jadwal']);
Route::get('/data/rps', [RpsController::class, 'index']); // Untuk mengambil semua data RPS
Route::get('rps/{id}', [RpsController::class, 'show']); // Untuk mengambil data RPS berdasarkan ID

// Route::post('/data/Jadwal/tambah', [JadwalController::class , 'jadwal']);
// Route::get('/data/Matkul', [MatkulController::class , 'matkul']);
// Route::post('/data/matkul/tambah', [MatkulController::class , 'matkul']);
// Route::get('/data/ruang', [RuangController::class , 'ruang']);
// Route::post('/data/ruang/tambah', [RuangController::class , 'ruang']);
// Route::get('/data/BeritaAcara/show/{id}', [BeritaAcaraController::class, 'berita_acara_show']);
// Route::get('/data/BeritaAcara', [BeritaAcaraController::class , 'berita_acara']);
// Route::post('/data/BeritaAcara/tambah', [BeritaAcaraController::class , 'berita_acara_create']);
// Route::post('/data/BeritaAcara/update/{nip}', [BeritaAcaraController::class, 'berita_acara_update']);
// Route::delete('/data/BeritaAcara/hapus/{nip}', [BeritaAcaraController::class, 'berita_acara_hapus']);


