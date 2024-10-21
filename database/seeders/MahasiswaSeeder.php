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

        $prodi = [
            [
                'kode_prodi' => 'TIF',
                'kode_jurusan' => 'ELEKTRO',
                'nama_prodi' => 'Teknik Informatika'
            ],[
                'kode_prodi' => 'TRSE',
                'kode_jurusan' => 'ELEKTRO',
                'nama_prodi' => 'Teknik Rekayasa Sistem Elektronik'
            ],[
                'kode_prodi' => 'TIL',
                'kode_jurusan' => 'ELEKTRO',
                'nama_prodi' => 'Teknik Listrik'
            ]
        ];

        foreach ($prodi as $data) {
            Prodi::create($data);
        }

        Mahasiswa::create([
            'nim' => 3202216074,
            'nama' => 'Oliver Dillon',
            'kode_prodi' => 'TIF',
            'semester'=> 5,
            'id_kelas'=> 3,
            'nip' => 198406112019031012,
            'no_hp'=> '0895411898900',
        ]);
    }
}
