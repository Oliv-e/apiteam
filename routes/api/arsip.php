<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArsipController;

Route::get('/', function () {
    return redirect()->route('api-data-dokumen-Arsip');
});
Route::get('/data/Dokumen', [ArsipController::class,'Dokumen']);
Route::get('/data/StaffAdmin', [ArsipController::class,'StaffAdmin']);
Route::get('/data/markeddokumen', [ArsipController::class,'markeddokumen']);
Route::post('/data/Dokumen_tambah', [ArsipController::class,'Dokumen_create']);
Route::post('/data/StaffAdmin_tambah', [ArsipController::class,'StaffAdmin_create']);
Route::post('/data/markeddokumen_tambah', [ArsipController::class,'markeddokumen_create']);