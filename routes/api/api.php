<?php

use App\Http\Controllers\Api\IntegrationController;
use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MahasiswaController;

Route::middleware(['auth:sanctum'])->group( function () {
    Route::GET('/mahasiswa', [IntegrationController::class , 'mahasiswa']);
    Route::GET('/mahasiswa/{id}', [IntegrationController::class , 'mahasiswa_by_id']);
    Route::POST('/mahasiswa', [IntegrationController::class, 'mahasiswa_create']);
    Route::POST('/mahasiswa-update/{id}', [IntegrationController::class, 'mahasiswa_update']);
    Route::POST('/mahasiswa-delete/{id}', [IntegrationController::class, 'mahasiswa_delete']);

    Route::GET('/dosen', [IntegrationController::class, 'dosen']);
    Route::POST('/dosen', [IntegrationController::class, 'dosen_create']);
});

Route::prefix('sibaper')->group(function() {
    require __DIR__ .'\sibaper.php';
});
Route::prefix('sirekap')->group(function() {
    require __DIR__ .'\sirekap.php';
});
Route::prefix('perwalian')->group(function() {
    require __DIR__ .'\perwalian.php';
});
Route::prefix('rps')->group(function() {
    require __DIR__ .'\rps.php';
});
