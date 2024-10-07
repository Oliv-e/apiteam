<?php

use App\Http\Controllers\Informasi\MahasiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function(){
    return view('admin.dashboard.index');
});

Route::get('/data-mahasiswa', [MahasiswaController::class, 'index'])->name('data-mahasiswa');
Route::get('/tambah-data-mahasiswa', [MahasiswaController::class, 'create'])->name('tambah-data-mahasiswa');
Route::post('/import-data-mahasiswa', [MahasiswaController::class, 'import'])->name('import-data-mahasiswa');

require __DIR__ .'\auth.php';

Route::middleware('auth:sanctum')->group( function () {
    Route::prefix('api')->group(function() {
        require __DIR__ .'\api\api.php';
    });
});
