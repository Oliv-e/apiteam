<?php

use App\Http\Controllers\Api\IntegrationController;
use App\Http\Controllers\Api\RpsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ReferensiController;
use App\Http\Controllers\Auth\ApiAuthController as AAC;

Route::POST('/login', [AAC::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::POST('/register', [AAC::class, 'register']);
        ROUTE::POST('/logout', [AAC::class, 'logout']);
    });

Route::get('/rps', [rpsController::class, 'index']);
Route::get('/referensi', [ReferensiController::class, 'index'] );

Route::post('/referensi_create', [ReferensiController::class, 'create']);
Route::post('/rps_create', [rpsController::class, 'create']); // Create RPS


Route::middleware(['auth:sanctum'])->group( function () {
    // bagian mahasiswa
    Route::GET('/mahasiswa', [IntegrationController::class , 'mahasiswa']);
    Route::GET('/mahasiswa/{id}', [IntegrationController::class , 'mahasiswa_by_id']);
    Route::POST('/mahasiswa', [IntegrationController::class, 'mahasiswa_create']);
    Route::POST('/mahasiswa-update/{id}', [IntegrationController::class, 'mahasiswa_update']);
    Route::POST('/mahasiswa-delete/{id}', [IntegrationController::class, 'mahasiswa_delete']);

    // bagian dosen
    Route::GET('/dosen', [IntegrationController::class, 'dosen']);
    Route::POST('/dosen', [IntegrationController::class, 'dosen_create']);

    // bagian admin



    Route::prefix('sibaper')->group(function() {
        require __DIR__ .'\sibaper.php';
    });
    Route::prefix('arsip')->group(function() {
        require __DIR__ .'\arsip.php';
    });
    Route::prefix('perwalian')->group(function() {
        require __DIR__ .'\perwalian.php';
    });
    Route::prefix('rps')->group(function() {
        require __DIR__ .'\rps.php';
    });
});
