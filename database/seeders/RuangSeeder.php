<?php

namespace Database\Seeders;

use App\Models\Ruang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RuangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ruang = [
            [
                'id_ruang' => "TI-1",
                'nama_ruang' => "Teori Teknik Informatika 1"
            ],[
                'id_ruang' => "TI-2",
                'nama_ruang' => "Teori Teknik Informatika 2"
            ]
        ];
        foreach ($ruang as $data) {
            Ruang::create($data);
        }
    }
}
