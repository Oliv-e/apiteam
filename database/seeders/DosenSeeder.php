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
        $dosen = [
            [
                'nip' => 197302061995011001,
                'nama' => "Ferry Faisal",
                'no_hp' => "081234567890"
            ],[
                'nip' => 198406112019031012,
                'nama' => "Lindung Siswanto",
                'no_hp' => "081234567890"
            ]
        ];
        foreach($dosen as $data) {
            Dosen::create($data);
        }

        Jabatan::create([
            'nip' => 198406112019031012,
            'is_kaprodi' => false,
            'is_kajur' => false
        ]);

        Jabatan::create([
            'nip' => 197302061995011001,
            'is_kaprodi' => false,
            'is_kajur' => false
        ]);
    }
}
