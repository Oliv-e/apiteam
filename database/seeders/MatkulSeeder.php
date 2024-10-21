<?php

namespace Database\Seeders;

use App\Models\Matkul;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MatkulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $matkul = [
            [
                'kode_matkul' => 'TIF10118',
                'nama_matkul' => 'Pancasila',
                'jumlah_jam' => 2,
                'sks' => 2
            ],[
                'kode_matkul' => 'TIF10218',
                'nama_matkul' => 'Matematika 1',
                'jumlah_jam' => 3,
                'sks' => 2
            ]
        ];

        foreach ($matkul as $data) {
            Matkul::create($data);
        }
    }
}
