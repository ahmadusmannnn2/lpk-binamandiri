<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peserta', function (Blueprint $table) {
            // Menambahkan status verifikasi biodata
            $table->enum('status_biodata', ['belum_isi', 'menunggu', 'disetujui', 'ditolak'])->default('belum_isi')->after('file_ktp');
            // Menambahkan catatan admin jika biodata ditolak (misal: "KTP buram")
            $table->text('catatan_biodata')->nullable()->after('status_biodata');
        });
    }

    public function down(): void
    {
        Schema::table('peserta', function (Blueprint $table) {
            $table->dropColumn(['status_biodata', 'catatan_biodata']);
        });
    }
};