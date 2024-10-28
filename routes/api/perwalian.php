<?php

use App\Http\Controllers\Api\KHSController;
use App\Http\Controllers\Api\KonsultasiController;
use App\Http\Controllers\Api\Perwalian\DosenController;
use App\Http\Controllers\Api\Perwalian\MhsController;
use App\Http\Controllers\Api\RekomendasiController;
use Illuminate\Support\Facades\Route;

// Route untuk mengambil data rekomendasi
// Route::get('/rekomendasi', [RekomendasiController::class, 'rekomendasi']);
// Route::post('/rek-tambah', [RekomendasiController::class, 'rekomendasi_create']);
// Route::get('/khs', [KHSController::class, 'khs']);
// Route::post('/khs-tambah', [KHSController::class, 'khs_create']);

//api dosen
Route::get('/d/konsul', [DosenController::class, 'konsul']);
Route::get('/d/janjitemu', [DosenController::class, 'janji_temu']);
Route::get('/d/mahasiswa', [DosenController::class, 'mhs_bimbingan']);
Route::get('/d/rekomendasi', [DosenController::class, 'rekomendasi']);
Route::post('/d/janjitemu/tambah', [DosenController::class, 'janji_temu_create']);

//api mahasiswa
Route::get('/m/janjitemu', [MhsController::class, 'janji_temu']);
Route::post('/m/janjitemu/tambah', [MhsController::class, 'janji_temu_create']);
Route::get('/m/rekomendasi', [MhsController::class, 'rekomendasi']);
Route::post('/m/rekomendasi/tambah', [MhsController::class, 'rekomendasi_create']);
