<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Rap2hpoutre\FastExcel\FastExcel;

class DosenController extends Controller
{
    public function index() {
        $data = Dosen::all();
        return view("admin.dosen.index", compact('data'));
    }
    public function insert() {
        return view("admin.dosen.insert");
    }
    public function import(Request $request) {
        $file = $request->file('file');
        try {
            $ddsn = (new FastExcel())->import($file, function($line) {
                if (User::where('id', $line['NIP'])->exists()) {
                    throw new \Exception('Data Sudah Ada');
                }
                Dosen::create([
                    'nip' => $line['NIP'],
                    'nama' => $line['NAMA'],
                    'no_hp' => $line['NO HP']
                ]);
                User::create([
                    'id' => $line['NIP'],
                    'role' => 'dosen',
                    'email' => $line['EMAIL'],
                    'password' => Hash::make($line['NIP']),
                ]);
            });

            return redirect()->route('dosen')->with('success','Data Berhasil Ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('dosen')->with('error', 'Data Gagal Ditambahkan');
        }
    }
}
