<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah kolom parameter di Program
        Schema::table('program_pelatihan', function (Blueprint $table) {
            $table->json('parameter_penilaian')->nullable()->after('harga_pelatihan');
        });

        // 2. Rombak kolom nilai di Pendaftaran
        Schema::table('pendaftaran', function (Blueprint $table) {
            // Hapus nilai lama
            $table->dropColumn(['nilai_teori', 'nilai_praktik']);
            
            // Tambah sistem nilai baru
            $table->json('detail_nilai')->nullable()->after('kehadiran');
            $table->integer('nilai_total')->default(0)->after('detail_nilai');
            $table->decimal('nilai_rata_rata', 5, 2)->default(0)->after('nilai_total');
        });
    }

    public function down(): void
    {
        Schema::table('program_pelatihan', function (Blueprint $table) {
            $table->dropColumn('parameter_penilaian');
        });

        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->dropColumn(['detail_nilai', 'nilai_total', 'nilai_rata_rata']);
            $table->integer('nilai_teori')->default(0);
            $table->integer('nilai_praktik')->default(0);
        });
    }
};