<?php

use App\Http\Controllers\Api\Arsip\ArsipController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ApiAuthController as AAC;
use App\Http\Controllers\Api\IntegrationController;

Route::post('/login', [AAC::class, 'login']); // uri : api/login

Route::get('/', [ArsipController::class,'getDokumen']); // uri : /api/arsip/dokumen/

Route::middleware(['auth:sanctum'])->group( function () {
    // Auth
    Route::post('/register', [AAC::class, 'register']); // uri : api/register
    Route::post('/logout', [AAC::class, 'logout']); // uri : api/logout
    // bagian mahasiswa
    Route::get('/mahasiswa', [IntegrationController::class , 'mahasiswa']);
    Route::get('/mahasiswa/{id}', [IntegrationController::class , 'mahasiswa_by_id']);
    Route::post('/mahasiswa', [IntegrationController::class, 'mahasiswa_create']);
    Route::post('/mahasiswa-update/{id}', [IntegrationController::class, 'mahasiswa_update']);
    Route::post('/mahasiswa-delete/{id}', [IntegrationController::class, 'mahasiswa_delete']);

    // bagian dosen
    Route::get('/dosen', [IntegrationController::class, 'dosen']);
    Route::post('/dosen', [IntegrationController::class, 'dosen_create']);
    Route::post('/dosen-update/{id}', [IntegrationController::class, 'dosen_update']);
    Route::post('/dosen-delete/{id}', [IntegrationController::class, 'dosen_delete']);

    // bagian admin
    Route::get('/admin', [IntegrationController::class, 'StaffAdmin']);
    Route::post('/admin', [IntegrationController::class,'StaffAdmin_create']);
    Route::post('/admin-update/{id}', [IntegrationController::class, 'admin_update']);
    Route::post('/admin-delete/{id}', [IntegrationController::class, 'admin_delete']);


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
