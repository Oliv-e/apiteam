<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RPS\RpsController;
use App\Http\Controllers\Api\RPS\ReferensiController;
use App\Http\Controllers\Api\RPS\JadwalController;
use App\Http\Controllers\Api\RPS\MatkulController;

Route::prefix('')->group( function () { // uri : api/rps
    // GET SECTION
    Route::get('/', [RpsController::class, 'index']); // uri : api/rps/
    Route::get('/{id}', [RpsController::class, 'show']); // uri : api/rps/{id}
    // POST SECTION
    Route::post('/create', [RpsController::class, 'create']); // uri : api/rps/create
    Route::post('/update/{id}', [RpsController::class, 'update']); // uri : api/rps/update/{id}
    Route::post('/delete/{id}', [RpsController::class, 'delete']); // uri : api/rps/delete
});

Route::prefix('referensi')->group( function () {
    // GET SECTION
    Route::get('/', [ReferensiController::class, 'index'] ); // uri : api/rps/referensi
    // POST SECTION
    Route::post('/create', [ReferensiController::class, 'create']);  // uri : api/rps/referensi/create
    Route::post('/update/{id}', [ReferensiController::class, 'update']); // uri : api/rps/referensi/update/{id}
});

Route::prefix('infomatkul')->group( function () {
    // GET SECTION
    Route::get('/', [MatkulController::class, 'infomatkul']); // uri : api/rps/infomatkul
    // POST SECTION
    Route::post('/create', [MatkulController::class, 'infomatkul_create']); // uri : api/rps/infomatkul/create
    Route::post('/update/{id}', [MatkulController::class, 'infomatkul_update']); // uri : api/rps/infomatkul/update/{id}
    Route::post('/delete/{id}', [MatkulController::class, 'infomatkul_delete']); // uri : api/rps/infomatkul/delete/{id}
});

Route::prefix('jadwal')->group( function () {
    // GET SECTION
    Route::get('/', [JadwalController::class, 'jadwal_pelaksanaan']); // uri : api/rps/jadwal
    // POST SECTION
    Route::post('/create', [JadwalController::class, 'jadwal_pelaksanaan_create']); // uri : api/rps/jadwal/create
    Route::post('/update/{id}', [JadwalController::class, 'jadwal_pelaksanaan_update']); // uri : api/rps/jadwal/update/{id}
    Route::post('/delete/{id}', [JadwalController::class, 'jadwal_pelaksanaan_delete']); // uri : api/rps/jadwal/delete/{id}
});

// Changelist Log --
// Mengganti routing dengan prefix
// Mengganti metode delete pada route hapus , metode put pada route update menjadi metode post


