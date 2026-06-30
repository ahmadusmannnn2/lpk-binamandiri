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
        $programs = [
            ['nama' => 'Sertifikasi Plat 3G (Kombinasi)', 'durasi' => 43, 'harga' => 24000000, 'desc' => 'Sertifikat: BNSP | Durasi: 43 hari'],
            ['nama' => 'GTAW (1F, 2F, 3F, 1G, 2G, 3G)', 'durasi' => 32, 'harga' => 19000000, 'desc' => 'Sertifikat: BNSP | Durasi: 32 hari'],
            ['nama' => 'SMAW (1F, 2F, 3F, 1G, 2G, 3G)', 'durasi' => 26, 'harga' => 15000000, 'desc' => 'Sertifikat: BNSP | Durasi: 26 hari'],
            ['nama' => 'FCAW / GMAW (Sertifikasi Plat 3G)', 'durasi' => 28, 'harga' => 16000000, 'desc' => 'Sertifikat: BNSP | Durasi: 28 hari'],
            ['nama' => 'FCAW (Level Pemula)', 'durasi' => 28, 'harga' => 16500000, 'desc' => 'Level: Pemula | Durasi: 28 hari'],
        ];

        foreach ($programs as $prog) {
            $programBaru = ProgramPelatihan::create([
                'nama_program' => $prog['nama'],
                'deskripsi' => $prog['desc'],
                'harga_pelatihan' => $prog['harga'],
                'durasi_hari' => $prog['durasi'],
            ]);

            for ($i = 1; $i <= 5; $i++) {
                Kelas::create([
                    'program_pelatihan_id' => $programBaru->id,
                    'instruktur_id' => $instruktur->id,
                    'nama_kelas' => 'Angkatan ' . $i . ' - ' . explode(' ', $prog['nama'])[0],
                    'kuota_peserta' => 20,
                    'status_kelas' => ($i == 1) ? 'berjalan' : 'menunggu', 
                ]);
            }
        }
    }
}