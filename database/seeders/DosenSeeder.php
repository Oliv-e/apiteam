<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\Jabatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Dosen::create([
            'nip' => 12221,
            'nama' => "Adam",
            'no_hp' =>" 089512345678"
        ]);

        Jabatan::create([
            'nip' => 12221,
            'is_kaprodi' => false,
            'is_kajur' => false
        ]);
    }
}
