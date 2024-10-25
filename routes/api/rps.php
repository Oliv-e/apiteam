<?php

// use App\Http\Controllers\Api\DosenController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RpsController;
use App\Http\Controllers\Api\ReferensiController;

//Route::get('dosen', [DosenController::class, 'index']);

Route::get('/rps', [rpsController::class, 'index']);
Route::get('/referensi', [ReferensiController::class, 'index'] );

Route::post('/rps_create', [rpsController::class, 'create']); // Create RPS
Route::post('/referensi_create', [ReferensiController::class, 'create']);


// Route untuk CRUD Rps
Route::get('/rps/{id}', [RpsController::class, 'show']); // Read RPS
Route::post('/rps_create', [RpsController::class, 'create']); // Create RPS
Route::put('/rps/{id}', [RpsController::class, 'update']); // Update RPS
Route::delete('/rps', [RpsController::class, 'destroy']); // Delete RPS

Route::put('/referensi/{id}', [ReferensiController::class, 'update']); // Update Referensi


Route::get('/infomatkul', [RpsController::class, 'infomatkul']);
Route::post('/infomatkul/tambah', [RpsController::class, 'infomatkul_create']);
Route::get('/jadwal_pelaksanaan', [RpsController::class, 'jadwal_pelaksanaan']);
Route::post('/jadwal_pelaksanaan/tambah', [RpsController::class, 'jadwal_pelaksanaan_create']);

// Route::get('/rps/infomatkul',)
Route::post('/infomatkul/update/{id_infomatkul}', [RpsController::class, 'infomatkul_update']);
Route::delete('/infomatkul/delete/{id}', [RpsController::class, 'infomatkul_delete']);

Route::post('/jadwal_pelaksanaan/update/{id_jadwal_pelaksanaan}', [RpsController::class, 'jadwal_pelaksanaan_update']);
Route::delete('/jadwal_pelaksanaan/delete/{id}', [RpsController::class, 'jadwal_pelaksanaan_delete']);



