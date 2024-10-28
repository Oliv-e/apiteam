<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Arsip\ArsipController;

// DONE

Route::prefix('dokumen')->group( function () { // uri : /api/arsip/dokumen
    // GET SECTION
    Route::get('/saya', [ArsipController::class,'getDokumenSaya']); // uri : /api/arsip/dokumen/saya , [Berdasarkan user yang sedang login]
    Route::get('/ditandai', [ArsipController::class,'getDokumenDitandai']); // uri : /api/arsip/dokumen/ditandai
    Route::get('/filter/{id}', [ArsipController::class, 'getDokumenFilter']); // uri : /api/arsip/dokumen/filter/{id} , [Berdasarkan id kategori]
    Route::get('/nama/{id}', [ArsipController::class, 'getDokumenNama']); // uri : /api/arsip/dokumen/nama/{id} , [Berdasarkan nama kategori]
    Route::get('/download/{id}', [ArsipController::class, 'getDokumenDownload']); //uri /api/arsip/dokumen/download/{id} , [Berdasarkan id kategori]
    // POST SECTION
    Route::post('/tambah', [ArsipController::class,'setDokumen']); // uri : /api/arsip/dokumen/tambah
    Route::post('/update/{id}', [ArsipController::class,'setDokumenUpdate']); // uri : /api/arsip/dokumen/update/{id}
    Route::post('/hapus/{id}', [ArsipController::class,'setDokumenHapus']); // uri : /api/arsip/dokumen/hapus/{id}
    Route::post('/ditandai/tambah', [ArsipController::class,'setDokumenDitandai']); // uri : /api/arsip/dokumen/ditandai/tambah
});

// Changelist Log --
// Memindahkan Staff Admin, Staff Admin Create ke Integration Controller
// Mengganti routing dengan prefix
// Mengganti metode delete pada route hapus menjadi metode post
// Mengganti nama kelas agar mudah dibaca
