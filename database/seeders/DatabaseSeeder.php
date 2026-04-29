<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Instruktur;
use App\Models\Peserta;
use App\Models\ProgramPelatihan;
use App\Models\Kelas;
use App\Models\Pengaturan;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BUAT AKUN USERS (Sesuai Permintaan)
        $admin = User::create([
            'name' => 'Admin LPK Bina Mandiri',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('11111111'),
            'role' => 'admin',
        ]);

        $userInstruktur = User::create([
            'name' => 'Bapak Doni Khojin', // Sesuai data klien sebelumnya
            'email' => 'instruktur@gmail.com',
            'password' => Hash::make('11111111'),
            'role' => 'instruktur',
        ]);

        $userPeserta = User::create([
            'name' => 'Peserta Ahmad',
            'email' => '1@gmail.com',
            'password' => Hash::make('11111111'),
            'role' => 'peserta',
        ]);

        // 2. BUAT PROFIL INSTRUKTUR & PESERTA
        $instruktur = Instruktur::create([
            'user_id' => $userInstruktur->id,
            'nomor_telepon' => '081234567890',
            'spesialisasi_las' => 'Pakar GTAW & SMAW',
            'alamat' => 'Wonosobo, Jawa Tengah',
        ]);

        Peserta::create([
            'user_id' => $userPeserta->id,
            'nik' => '3307000000000001',
            'nomor_telepon' => '089876543210',
            'jenis_kelamin' => 'Laki-laki',
        ]);

        // 3. MASUKKAN 5 DATA PROGRAM DARI KLIEN
        $programs = [
            [
                'nama_program' => 'Sertifikasi Plat 3G (Kombinasi)',
                'deskripsi' => 'Sertifikat: BNSP | Durasi: 43 hari',
                'harga_pelatihan' => 24000000,
            ],
            [
                'nama_program' => 'GTAW (1F, 2F, 3F, 1G, 2G, 3G)',
                'deskripsi' => 'Sertifikat: BNSP | Durasi: 32 hari',
                'harga_pelatihan' => 19000000,
            ],
            [
                'nama_program' => 'SMAW (1F, 2F, 3F, 1G, 2G, 3G)',
                'deskripsi' => 'Sertifikat: BNSP | Durasi: 26 hari',
                'harga_pelatihan' => 15000000,
            ],
            [
                'nama_program' => 'FCAW / GMAW (Sertifikasi Plat 3G)',
                'deskripsi' => 'Sertifikat: BNSP | Durasi: 28 hari',
                'harga_pelatihan' => 16000000,
            ],
            [
                'nama_program' => 'FCAW (Level Pemula)',
                'deskripsi' => 'Level: Pemula | Durasi: 28 hari',
                'harga_pelatihan' => 16500000,
            ],
        ];

        foreach ($programs as $prog) {
            ProgramPelatihan::create($prog);
        }

        // 4. BUAT KELAS DUMMY UNTUK PROGRAM 1 & 2
        Kelas::create([
            'program_pelatihan_id' => 1,
            'instruktur_id' => $instruktur->id,
            'nama_kelas' => 'Angkatan 1 - Plat 3G Kombinasi',
            'kuota_peserta' => 20,
            'tanggal_mulai' => now()->addDays(7),
            'tanggal_selesai' => now()->addDays(50),
            'status_kelas' => 'menunggu',
        ]);

        Kelas::create([
            'program_pelatihan_id' => 2,
            'instruktur_id' => $instruktur->id,
            'nama_kelas' => 'Angkatan 1 - Spesialis GTAW',
            'kuota_peserta' => 15,
            'tanggal_mulai' => now()->subDays(5),
            'tanggal_selesai' => now()->addDays(27),
            'status_kelas' => 'berjalan',
        ]);

        // 5. MASUKKAN PENGATURAN WEBSITE
        $pengaturan = [
            ['kunci' => 'hero_judul', 'nilai' => 'Creating Value For The World.'],
            ['kunci' => 'hero_deskripsi', 'nilai' => 'Kami percaya pada kekuatan transformatif dari koneksi. Mewujudkan visi Anda menjadi sumber daya Welder Profesional.'],
            ['kunci' => 'tentang_deskripsi', 'nilai' => 'BINA MANDIRI adalah lembaga pelatihan pengelasan, kelistrikan, dan pengecatan di Wonosobo.'],
            ['kunci' => 'kontak_alamat', 'nilai' => 'Jl. KH. Hasyim Asy\'ari Km. 03 Kalibeber, Wonosobo'],
            ['kunci' => 'kontak_telepon', 'nilai' => '0812 7889 2727'],
            ['kunci' => 'kontak_email', 'nilai' => 'binamandiricentre@gmail.com'],
            ['kunci' => 'nama_lpk_1', 'nilai' => 'LPK'],
            ['kunci' => 'nama_lpk_2', 'nilai' => 'BINA MANDIRI'],
        ];

        foreach ($pengaturan as $setting) {
            Pengaturan::create($setting);
        }
    }
}