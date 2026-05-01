<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Instruktur;
use App\Models\ProgramPelatihan;
use App\Models\Kelas;
use App\Models\Peserta;
use App\Models\Pengaturan;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. DATA PENGATURAN WEB (Agar tampilan website tidak hancur)
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

        // 2. AKUN ADMIN & INSTRUKTUR
        User::create([
            'name' => 'Admin LPK Bina Mandiri',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'), // Password: password
            'role' => 'admin',
        ]);

        $userInstruktur = User::create([
            'name' => 'Bapak Doni Khojin',
            'email' => 'instruktur@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'instruktur',
        ]);

        $instruktur = Instruktur::create([
            'user_id' => $userInstruktur->id,
            'nomor_telepon' => '081234567890',
            'spesialisasi_las' => 'Pakar GTAW & SMAW',
            'alamat' => 'Wonosobo, Jawa Tengah'
        ]);

        // 3. PROGRAM PELATIHAN & OTOMATIS BIKIN 5 KELAS PER PROGRAM
        $programs = [
            ['nama' => 'Sertifikasi Plat 3G (Kombinasi)', 'durasi' => 43, 'harga' => 24000000, 'desc' => 'Sertifikat: BNSP | Durasi: 43 hari'],
            ['nama' => 'GTAW (1F, 2F, 3F, 1G, 2G, 3G)', 'durasi' => 32, 'harga' => 19000000, 'desc' => 'Sertifikat: BNSP | Durasi: 32 hari'],
            ['nama' => 'SMAW (1F, 2F, 3F, 1G, 2G, 3G)', 'durasi' => 26, 'harga' => 15000000, 'desc' => 'Sertifikat: BNSP | Durasi: 26 hari'],
            ['nama' => 'FCAW / GMAW (Sertifikasi Plat 3G)', 'durasi' => 28, 'harga' => 16000000, 'desc' => 'Sertifikat: BNSP | Durasi: 28 hari'],
            ['nama' => 'FCAW (Level Pemula)', 'durasi' => 28, 'harga' => 16500000, 'desc' => 'Level: Pemula | Durasi: 28 hari'],
        ];

        foreach ($programs as $prog) {
            // Buat Program
            $programBaru = ProgramPelatihan::create([
                'nama_program' => $prog['nama'],
                'deskripsi' => $prog['desc'],
                'harga_pelatihan' => $prog['harga'],
                'durasi_hari' => $prog['durasi'],
            ]);

            // Bikin 5 Kelas untuk program ini
            for ($i = 1; $i <= 5; $i++) {
                Kelas::create([
                    'program_pelatihan_id' => $programBaru->id,
                    'instruktur_id' => $instruktur->id,
                    'nama_kelas' => 'Angkatan ' . $i . ' - ' . explode(' ', $prog['nama'])[0], // Nama otomatis
                    'kuota_peserta' => 20,
                    // Angkatan 1 dibuat berjalan, sisanya menunggu
                    'status_kelas' => ($i == 1) ? 'berjalan' : 'menunggu', 
                ]);
            }
        }

        // 4. BUAT 10 AKUN PESERTA (Email: 1@gmail.com s/d 10@gmail.com)
        $angkaText = ['Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh'];
        
        for ($i = 1; $i <= 10; $i++) {
            $userPeserta = User::create([
                'name' => 'Peserta ' . $angkaText[$i - 1],
                'email' => $i . '@gmail.com',
                'password' => Hash::make('password'), // Passwordnya sama semua: password
                'role' => 'peserta',
            ]);

            // Buat tabel pesertanya sekalian dengan status belum_isi
            Peserta::create([
                'user_id' => $userPeserta->id,
                'status_biodata' => 'belum_isi'
            ]);
        }
    }
}