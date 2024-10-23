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
