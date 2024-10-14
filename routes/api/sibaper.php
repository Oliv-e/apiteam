<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SibaperController;
use App\Http\Controllers\Api\BeritaAcaraController;

Route::get('/', function() {
    return redirect()->route('api-data-sibaper');
});
Route::get('/data/kelas', [SibaperController::class , 'kelas'])->name('api-data-kelas-sibaper');
Route::get('/data/BeritaAcara', [BeritaAcaraController::class , 'berita_acara'])->name('api-data-berita-acara-sibaper');
Route::get('/data/jadwal', [SibaperController::class , 'jadwal'])->name('api-data-jadwal-sibaper');
Route::get('/data/ruang', [SibaperController::class , 'ruang'])->name('api-data-ruang-sibaper');
Route::post('/data/BeritaAcara/tambah', [BeritaAcaraController::class , 'berita_acara_create'])->name('api-data-berita-acara-sibaper-tambah');