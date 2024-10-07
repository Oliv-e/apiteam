<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jurusan::create([
            'kode_jurusan' => 'ELEKTRO',
            'nama_jurusan' => 'TEKNIK ELEKTRO'
        ]);

        Prodi::create([
            'kode_prodi' => 'TIF',
            'kode_jurusan' => 'ELEKTRO',
            'nama_prodi' => 'Teknik Informatika'
        ]);

        Mahasiswa::create([
            'nim' => 3202216074,
            'nama' => 'Oliver Dillon',
            'kode_prodi' => 'TIF',
            'semester'=> 5,
            'id_kelas'=> 3,
            'nip' => 12221,
            'no_hp'=> '0895411898900',
        ]);
    }
}
