<?php

use App\Http\Controllers\Api\DosenController;
use App\Http\Controllers\Api\rpsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ReferensiController;



// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

//Route::get('dosen', [DosenController::class, 'index']);
Route::get('rps', [rpsController::class, 'index']);
Route::get('referensi', [ReferensiController::class, 'index'] );
Route::post('referensi_create', [ReferensiController::class, 'create']);


// Route untuk CRUD Rps
Route::get('/rps/{id}', [rpsController::class, 'show']); // Read RPS
Route::post('/rps', [rpsController::class, 'create']); // Create RPS
Route::put('/rps/{id}', [rpsController::class, 'update']); // Update RPS
Route::delete('/rps/{id}', [rpsController::class, 'destroy']); // Delete RPS

// Route untuk CRUD Referensi
// Route::get('/referensi/{id}', [ReferensiController::class, 'show']); // Read Referensi
//Route::post('/referensi_create', [ReferensiController::class, 'ref_create']); // Create Referensi
// Route::put('/referensi/{id}', [ReferensiController::class, 'update']); // Update Referensi
// Route::delete('/referensi/{id}', [ReferensiController::class, 'destroy']); // Delete Referensi

