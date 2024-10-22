<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
            'id' => 197302061995011001,
            'role' => 'dosen',
            'email' => 'ferryfaisal@gmail.com',
            'email_verified_at' => Now(),
            'password' => Hash::make('12341234'),
        ]);
    }
}
