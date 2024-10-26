<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Hash;
use Rap2hpoutre\FastExcel\FastExcel;

class MahasiswaController extends Controller
{
    public function index() {
        $data = Mahasiswa::all()->sortBy('nim');
        return view("admin.mahasiswa.index", compact('data'));
    }
    public function insert() {
        return view("admin.mahasiswa.insert");
    }
    public function import(Request $request) {

        $file = $request->file('file');
        function alokasi_kelas($abjad) {
            $abjad = strtoupper($abjad);
            return ord($abjad) - 64;
        }
        try {
            (new FastExcel())->import($file, function($line) {
                if (User::where('id', $line['NIM'])->exists() || Mahasiswa::where('nim', $line['NIM'])->exists()) {
                    return;
                }
                Mahasiswa::create([
                    'nim' => $line['NIM'],
                    'nama' => $line['NAMA'],
                    'kode_prodi' => $line['KODE PRODI'],
                    'semester' => $line['SEMESTER'],
                    'id_kelas' => alokasi_kelas($line['KELAS']),
                    'nip' => $line['NIP'],
                    'no_hp' => $line['NO HP']
                ]);
                User::create([
                    'id' => $line['NIM'],
                    'role' => 'mahasiswa',
                    'email' => $line['EMAIL'],
                    'password' => Hash::make($line['NIM']),
                ]);
            });

            return redirect()->route('mahasiswa')->with('success','Data Berhasil Ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('mahasiswa')->with('error', 'Data Gagal Ditambahkan');
        }
    }
}
