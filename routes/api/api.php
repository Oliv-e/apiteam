<?php

use App\Http\Controllers\Api\IntegrationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group( function () {
    // bagian mahasiswa
    Route::get('/mahasiswa', [IntegrationController::class , 'mahasiswa']);
    Route::get('/mahasiswa/{id}', [IntegrationController::class , 'mahasiswa_by_id']);
    Route::post('/mahasiswa', [IntegrationController::class, 'mahasiswa_create']);
    Route::post('/mahasiswa-update/{id}', [IntegrationController::class, 'mahasiswa_update']);
    Route::post('/mahasiswa-delete/{id}', [IntegrationController::class, 'mahasiswa_delete']);

    // bagian dosen
    Route::get('/dosen', [IntegrationController::class, 'dosen']);
    Route::post('/dosen', [IntegrationController::class, 'dosen_create']);

    // bagian admin
    Route::get('/admin', [IntegrationController::class, 'StaffAdmin']);
    Route::post('/StaffAdmin_tambah', [IntegrationController::class,'StaffAdmin_create']);


    Route::prefix('sibaper')->group(function() {
        require __DIR__ .'/sibaper.php';
    });
    Route::prefix('arsip')->group(function() {
        require __DIR__ .'/arsip.php';
    });
    Route::prefix('perwalian')->group(function() {
        require __DIR__ .'/perwalian.php';
    });
    Route::prefix('rps')->group(function() {
        require __DIR__ .'/rps.php';
    });
});
