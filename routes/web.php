<?php

use App\Http\Controllers\Page\DashboardController;
use App\Http\Controllers\System\DosenController;
use App\Http\Controllers\System\MahasiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('dashboard')->group(function() {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::prefix('mahasiswa')->group(function () {
            Route::get('/', [MahasiswaController::class, 'index'])->name('mahasiswa');
            Route::get('/insert', [MahasiswaController::class, 'insert'])->name('insert-mahasiswa');
            Route::post('/insert', [MahasiswaController::class, 'import'])->name('import-mahasiswa');
        });
        Route::prefix('dosen')->group(function () {
            Route::get('/', [DosenController::class, 'index'])->name('dosen');
            Route::get('/insert', [DosenController::class, 'insert'])->name('insert-dosen');
            Route::post('/insert', [DosenController::class, 'import'])->name('import-dosen');
        });
    });
});

require __DIR__ .'/auth.php';
