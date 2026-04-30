<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('program_pelatihan', function (Blueprint $table) {
            // Tambah kolom durasi_hari (angka)
            $table->integer('durasi_hari')->default(0)->after('harga_pelatihan');
        });
        
        // Kita juga buat kolom tanggal_selesai di kelas jadi nullable (boleh kosong saat diinput)
        Schema::table('kelas', function (Blueprint $table) {
            $table->date('tanggal_selesai')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('program_pelatihan', function (Blueprint $table) {
            $table->dropColumn('durasi_hari');
        });
    }
};