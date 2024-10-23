<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'id' => 3202216074,
            'role' => 'mahasiswa',
            'email'=> 'oliversmk7rpl@gmail.com',
            'email_verified_at' => Now(),
            'password'=> Hash::make('12341234'),
        ]);
        User::create([
            'id' => 12221,
            'role' => 'dosen',
            'email' => 'adam@gmail.com',
            'email_verified_at' => Now(),
            'password' => Hash::make('12341234'),
        ]);
        $this->call(MahasiswaSeeder::class);
        $this->call(DosenSeeder::class);
        $this->call(KelasSeeder::class);
    }
}
