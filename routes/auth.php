<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController as AC;
use App\Http\Controllers\Auth\ApiAuthController as AAC;

Route::get('/login', [AC::class, 'login'])->name('login'); // uri : /login
Route::post('/login', [AC::class, 'authenticate'])->name('login'); // uri : //login , method : POST
Route::get('/logout', [AC::class, 'logout'])->name('logout'); // uri : /logout

Route::prefix('api')->group(function () { // uri : api/
    Route::post('/login', [AAC::class, 'login']); // uri : api/login
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/register', [AAC::class, 'register']); // uri : api/register
        Route::post('/logout', [AAC::class, 'logout']); // uri : api/logout
    });
});
