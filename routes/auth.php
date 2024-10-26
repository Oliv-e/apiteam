<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController as AC;

Route::get('/login', [AC::class, 'login'])->name('login'); // uri : /login
Route::post('/login', [AC::class, 'authenticate'])->name('login'); // uri : //login , method : POST
Route::get('/logout', [AC::class, 'logout'])->name('logout'); // uri : /logout

