<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom materi di tabel pertemuan
        Schema::table('pertemuan', function (Blueprint $table) {
            $table->string('file_materi')->nullable()->after('tanggal');
        });

        // Tambah kolom nilai dan catatan di tabel absensi
        Schema::table('absensi', function (Blueprint $table) {
            $table->integer('nilai')->nullable()->after('status');
            $table->text('catatan')->nullable()->after('nilai');
        });
    }

    public function down(): void
    {
        Schema::table('pertemuan', function (Blueprint $table) {
            $table->dropColumn('file_materi');
        });

        Schema::table('absensi', function (Blueprint $table) {
            $table->dropColumn(['nilai', 'catatan']);
        });
    }
};