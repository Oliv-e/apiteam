<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::GET('/', function() {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('dashboard')->group(function() {
        Route::GET('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::GET('/data-mahasiswa', [DashboardController::class, 'data_mahasiswa'])->name('data-mahasiswa');
        Route::GET('/tambah-data-mahasiswa', [DashboardController::class, 'create'])->name('tambah-data-mahasiswa');
        Route::POST('/import-data-mahasiswa', [DashboardController::class, 'import'])->name('import-data-mahasiswa');
    });
});

require __DIR__ .'\auth.php';
