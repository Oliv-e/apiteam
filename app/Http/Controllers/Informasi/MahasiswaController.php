<?php

namespace App\Http\Controllers\Informasi;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use Rap2hpoutre\FastExcel\FastExcel;
use Hash;

class MahasiswaController extends Controller
{
    public function index() {
        $data = Mahasiswa::all();
        return view("admin.mahasiswa.index", compact('data'));
    }
    public function create() {
        return view("admin.mahasiswa.create");
    }
    public function import(Request $request) {
        $file = $request->file('file');
        function alokasi_kelas($abjad) {
            $abjad = strtoupper($abjad);
            return ord($abjad) - 64;
        }
        try {
            $dmhs = (new FastExcel)->import($file, function($line) {
                if (User::where('id', $line['NIM'])->exists()) {
                    throw new \Exception('Data Sudah Ada');
                }
                Mahasiswa::create([
                    'nim' => $line['NIM'],
                    'nama' => $line['NAMA'],
                    'semester' => $line['SEMESTER'],
                    'kode_jurusan' => $line['KODE'],
                    'id_kelas' => alokasi_kelas($line['KELAS']),
                    'no_hp' => $line['NO HP']
                ]);
                User::create([
                    'id' => $line['NIM'],
                    'role' => 'mahasiswa',
                    'email' => $line['EMAIL'],
                    'password' => Hash::make($line['NIM']),
                ]);
            });

            return redirect('data-mahasiswa')->with('success','Data Berhasil Ditambahkan');
        } catch (\Exception $e) {
            return redirect('data-mahasiswa')->with('error', 'Data Gagal Ditambahkan');
        }
    }
}
