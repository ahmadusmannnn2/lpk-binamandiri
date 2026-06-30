<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Instruktur;
use App\Models\ProgramPelatihan;
use App\Models\Kelas;
use App\Models\Pengaturan;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // 1. DATA PENGATURAN WEB (Agar tampilan tidak hancur)
        // ==========================================
        $pengaturan = [
            ['kunci' => 'hero_judul', 'nilai' => 'Creating Value For The World.'],
            ['kunci' => 'hero_deskripsi', 'nilai' => 'Kami percaya pada kekuatan transformatif dari koneksi. Mewujudkan visi Anda menjadi sumber daya Welder Profesional.'],
            ['kunci' => 'tentang_deskripsi', 'nilai' => 'BINA MANDIRI adalah lembaga pelatihan pengelasan, kelistrikan, dan pengecatan di Wonosobo.'],
            ['kunci' => 'kontak_alamat', 'nilai' => "Jl. KH. Hasyim Asy'ari Km. 03 Kalibeber, Wonosobo"],
            ['kunci' => 'kontak_telepon', 'nilai' => '0812 7889 2727'],
            ['kunci' => 'kontak_email', 'nilai' => 'binamandiricentre@gmail.com'],
            ['kunci' => 'nama_lpk_1', 'nilai' => 'LPK'],
            ['kunci' => 'nama_lpk_2', 'nilai' => 'BINA MANDIRI'],
        ];
        foreach ($pengaturan as $p) {
            Pengaturan::create($p);
        }

        // ==========================================
        // 2. AKUN ADMIN
        // ==========================================
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('11111111'),
            'role' => 'admin',
            'email_verified_at' => now(), // Bypass verifikasi email
        ]);

        // ==========================================
        // 3. AKUN & PROFIL INSTRUKTUR
        // ==========================================
        $userInstruktur = User::create([
            'name' => 'Instruktur',
            'email' => 'instruktur@gmail.com',
            'password' => Hash::make('11111111'),
            'role' => 'instruktur',
            'email_verified_at' => now(),
        ]);

        $instruktur = Instruktur::create([
            'user_id' => $userInstruktur->id,
            'nip' => '198001012024011001',
            'nomor_telepon' => '081234567890',
            'keahlian' => 'Pakar GTAW & SMAW', // Disesuaikan dengan migration
            'foto' => null
        ]);

        // ==========================================
        // 4. PROGRAM PELATIHAN & KELAS (Sebagai data awal)
        // ==========================================
        // Dikosongkan sesuai permintaan agar sistem bersih dari awal.
    }
}