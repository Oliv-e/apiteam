<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController as AC;
use App\Http\Controllers\Auth\ApiAuthController as AAC;

Route::GET('/login', [AC::class, 'login'])->name('login');
Route::POST('/login', [AC::class, 'authenticate'])->name('login');
Route::GET('/logout', [AC::class, 'logout'])->name('logout');