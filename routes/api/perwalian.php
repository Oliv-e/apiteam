<?php

use App\Http\Controllers\Api\JanjiTemuController;
use App\Http\Controllers\Api\KHSController;
use App\Http\Controllers\Api\KonsultasiController;
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

Route::get('/konsul', [KonsultasiController::class, 'konsul']);
Route::post('/konsul-tambah', [KonsultasiController::class, 'konsul_create']);

Route::get('/janjitemu', [JanjiTemuController::class, 'janji_temu']);
Route::post('/janjitemu-tambah', [JanjiTemuController::class, 'janji_temu_create']);