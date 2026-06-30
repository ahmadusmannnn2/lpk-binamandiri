<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peserta', function (Blueprint $table) {
            // 1. Alamat Domisili (beda dengan alamat KTP)
            $table->text('alamat_domisili')->nullable()->after('alamat');
            // 2. Pengalaman Bekerja
            $table->text('pengalaman_bekerja')->nullable()->after('alamat_domisili');
            // 3. Perusahaan Terakhir
            $table->string('perusahaan_terakhir')->nullable()->after('pengalaman_bekerja');
            // 4. Keperluan Mendaftar
            $table->text('keperluan_mendaftar')->nullable()->after('perusahaan_terakhir');
            // 5. Status Perkawinan
            $table->enum('status_perkawinan', ['Belum Menikah', 'Menikah', 'Cerai Hidup', 'Cerai Mati'])->nullable()->after('keperluan_mendaftar');
            // 6. Rekomendasi dari siapa
            $table->string('rekomendasi_dari')->nullable()->after('status_perkawinan');
            // 7. Sertifikat Pendukung (disimpan sebagai path file)
            $table->string('file_sertifikat_pendukung')->nullable()->after('rekomendasi_dari');
        });
    }

    public function down(): void
    {
        Schema::table('peserta', function (Blueprint $table) {
            $table->dropColumn([
                'alamat_domisili',
                'pengalaman_bekerja',
                'perusahaan_terakhir',
                'keperluan_mendaftar',
                'status_perkawinan',
                'rekomendasi_dari',
                'file_sertifikat_pendukung',
            ]);
        });
    }
};
