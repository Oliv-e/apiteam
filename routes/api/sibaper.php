<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SibaperController;
use App\Http\Controllers\Api\BeritaAcaraController;
use App\Http\Controllers\Api\DosenController;
use App\Http\Controllers\Api\JadwalController;
use App\Http\Controllers\Api\KelasController;
use App\Http\Controllers\Api\MatkulController;
use App\Http\Controllers\Api\RuangController;

Route::get('/', function() {
    return redirect()->route('api-data-sibaper');
});
Route::get('/data/kelas', [SibaperController::class , 'kelas'])->name('api-data-kelas-sibaper');
Route::get('/data/BeritaAcara', [BeritaAcaraController::class , 'berita_acara'])->name('api-data-berita-acara-sibaper');
Route::get('/data/Dosen', [DosenController::class , 'dosen'])->name('api-data-dosen-sibaper');
Route::get('/data/Jadwal', [JadwalController::class , 'jadwal'])->name('api-data-jadwal-sibaper');
Route::get('/data/Matkul', [MatkulController::class , 'matkul'])->name('api-data-matkul-sibaper');
Route::get('/data/ruang', [RuangController::class , 'ruang'])->name('api-data-ruang-sibaper');
Route::post('/data/BeritaAcara/tambah', [BeritaAcaraController::class , 'berita_acara'])->name('api-data-berita-acara-sibaper-tambah');
Route::post('/data/Kelas/tambah', [KelasController::class , 'kelas'])->name('api-data-kelas-sibaper-tambah');
Route::post('/data/Dosen/tambah', [DosenController::class , 'dosen'])->name('api-data-dosen-sibaper-tambah');
Route::post('/data/Jadwal/tambah', [JadwalController::class , 'jadwal'])->name('api-data-jadwal-sibaper-tambah');
Route::post('/data/matkul/tambah', [MatkulController::class , 'matkul'])->name('api-data-matkul-sibaper-tambah');
Route::post('/data/ruang/tambah', [RuangController::class , 'ruang'])->name('api-data-ruang-sibaper-tambah');
