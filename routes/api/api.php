<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MahasiswaController;
        // Mahasiswa
Route::prefix('/mahasiswa')->group(function() {
    Route::get('/', function() {
        return redirect()->route('api-data-mahasiswa');
    });
    Route::get('/data', [MahasiswaController::class , 'index'])->name('api-data-mahasiswa');
    Route::get('/tambah', [MahasiswaController::class , 'tambah'])->name('api-tambah-mahasiswa');
    Route::get('/edit/{nim}', [MahasiswaController::class , 'edit'])->name('api-edit-mahasiswa');
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
