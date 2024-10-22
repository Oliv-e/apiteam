<?php

// use App\Http\Controllers\Api\DosenController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RpsController;
use App\Http\Controllers\Api\ReferensiController;

//Route::get('dosen', [DosenController::class, 'index']);
Route::get('rps', [RpsController::class, 'index']);
Route::get('referensi', [ReferensiController::class, 'index'] );
Route::post('referensi_create', [ReferensiController::class, 'create']);


// Route untuk CRUD Rps
Route::get('/rps/{id}', [RpsController::class, 'show']); // Read RPS
Route::post('/rps_create', [RpsController::class, 'create']); // Create RPS
Route::put('/rps/{id}', [RpsController::class, 'update']); // Update RPS
Route::delete('/rps/{id}', [RpsController::class, 'destroy']); // Delete RPS
// Route untuk CRUD Referensi
// Route::get('/referensi/{id}', [ReferensiController::class, 'show']); // Read Referensi
// Route::post('/referensi_create', [ReferensiController::class, 'ref_create']); // Create Referensi
// Route::put('/referensi/{id}', [ReferensiController::class, 'update']); // Update Referensi
// Route::delete('/referensi/{id}', [ReferensiController::class, 'destroy']); // Delete Referensi

Route::post('/rps/infomatkul', [RpsController::class, 'infomatkul']);
