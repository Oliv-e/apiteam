<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $abjad = ['','A','B','C','D','E'];
        for ($i = 1; $i < 6; $i++) {
            Kelas::create([
                'id_kelas' => $i,
                'abjad_kelas'=> $abjad[$i],
            ]);
        }
    }
}
