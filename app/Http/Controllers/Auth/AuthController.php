<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login() {
        if (Auth::check()) {
            return redirect('dashboard');
        }

        return view('auth.page.login');
    }
    public function authenticate(Request $request) {
        // dd($request);
        $credentials = $request->validate([
            'id' => ['required'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'err' => 'ID atau Password yang anda masukkan salah!'
        ]);
    }
    public function logout() {
        Auth::logout();
        return redirect()->intended('login');
    }
}
