<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin
        User::create([
            'name' => 'Administrator LPK',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('11111111'),
            'role' => 'admin',
        ]);

        // 2. Akun Instruktur
        User::create([
            'name' => 'Bapak Instruktur',
            'email' => 'instruktur@gmail.com',
            'password' => Hash::make('11111111'),
            'role' => 'instruktur',
        ]);

        // 3. Akun Peserta
        User::create([
            'name' => 'Peserta Uji Coba',
            'email' => '1@gmail.com',
            'password' => Hash::make('11111111'),
            'role' => 'peserta',
        ]);
    }
}