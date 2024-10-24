<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArsipController;

Route::get('/', function () {
    return redirect()->route('api-data-dokumen-Arsip');
});
Route::get('/Dokumen', [ArsipController::class,'Dokumen']);
Route::get('/StaffAdmin', [ArsipController::class,'StaffAdmin']);
Route::get('/markeddokumen', [ArsipController::class,'markeddokumen']);
Route::post('/Dokumen_tambah', [ArsipController::class,'Dokumen_create']);
Route::post('/StaffAdmin_tambah', [ArsipController::class,'StaffAdmin_create']);
Route::post('/markeddokumen_tambah', [ArsipController::class,'markeddokumen_create']);

Route::delete('/data/Dokumen_hapus/{id}', [ArsipController::class,'Dokumen_hapus']);
Route::post('/data/Dokumen_update/{id}', [ArsipController::class,'Dokumen_update']);
Route::get('/data/dokumen_satuan', [ArsipController::class,'satuan_dokumen']);
Route::get('data/dokumen_filter/{id}', [ArsipController::class, 'dokumen_filter']);
Route::get('data/dokumen_nama', [ArsipController::class, 'dokumen_nama']);
Route::get('data/download_Dokumen/{id}', [ArsipController::class, 'download_Dokumen']);