<?php

use App\Http\Controllers\Api\JanjiTemuController;
use App\Http\Controllers\Api\KHSController;
use App\Http\Controllers\Api\KonsultasiController;
use App\Http\Controllers\Api\Perwalian\DosenController;
use App\Http\Controllers\Api\RekomendasiController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     echo "TEST";
// });

// Route untuk mengambil data rekomendasi

Route::get('/rekomendasi', [RekomendasiController::class, 'rekomendasi']);
Route::post('/rek-tambah', [RekomendasiController::class, 'rekomendasi_create']);

Route::get('/khs', [KHSController::class, 'khs']);
Route::post('/khs-tambah', [KHSController::class, 'khs_create']);

//api dosen
Route::get('/d/konsul', [DosenController::class, 'konsul']);
Route::get('/d/janjitemu/{nip}', [DosenController::class, 'janji_temu']);
Route::get('/d/mahasiswa', [DosenController::class, 'mhs_bimbingan']);

//api mahasiswa
Route::post('/m/janjitemu-tambah', [JanjiTemuController::class, 'janji_temu_create']);

Route::post('/konsul-tambah', [KonsultasiController::class, 'konsul_create']);
Route::put('/konsul-edit/{nim}', [KonsultasiController::class, 'konsul_update']);
Route::delete('/konsul-hapus/{nim}', [KonsultasiController::class, 'konsul_delete']);




