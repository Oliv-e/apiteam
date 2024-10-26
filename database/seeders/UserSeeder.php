<?php

namespace Database\Seeders;

use App\Models\StaffAdmin;
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
            'id' => 12341234,
            'role' => 'staff',
            'email'=> 'oliversmk7rpl@gmail.com',
            'email_verified_at' => Now(),
            'password'=> Hash::make('12341234'),
        ]);
        StaffAdmin::create([
            'id_admin' => 12341234,
            'nama' => 'Super Admin',
            'no_hp' => '0895411898900'
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
