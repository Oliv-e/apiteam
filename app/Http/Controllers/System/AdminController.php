<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\StaffAdmin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index() {
        $data = StaffAdmin::all();
        return view("admin.staff.index", compact('data'));
    }
    public function insert() {
        return view('admin.staff.insert');
    }
    public function import(Request $request) {
        $request->validate([
            'id_admin' => 'required',
            'nama' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'no_hp' => 'required',
        ]);

        User::create([
            'id' => $request->id_admin,
            'email' => $request->email,
            'role' => 'staff',
            'password' => Hash::make($request->password)
        ]);

        StaffAdmin::create([
            'id_admin' => $request->id_admin,
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->route('staff')->with('success', 'Data Berhasil ditambahkan');
    }
}
