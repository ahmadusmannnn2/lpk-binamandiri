<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            // Menambahkan kolom kehadiran dan nilai
            $table->integer('kehadiran')->default(0)->after('keterangan_admin'); // dalam bentuk persentase / hari
            $table->integer('nilai_teori')->default(0)->after('kehadiran');
            $table->integer('nilai_praktik')->default(0)->after('nilai_teori');
            $table->enum('status_kelulusan', ['belum_dinilai', 'lulus', 'tidak_lulus'])->default('belum_dinilai')->after('nilai_praktik');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->dropColumn(['kehadiran', 'nilai_teori', 'nilai_praktik', 'status_kelulusan']);
        });
    }
};