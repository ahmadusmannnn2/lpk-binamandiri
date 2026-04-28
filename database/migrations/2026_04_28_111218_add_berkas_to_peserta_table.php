<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peserta', function (Blueprint $table) {
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable()->after('nomor_telepon');
            $table->string('pendidikan_terakhir')->nullable()->after('jenis_kelamin');
            $table->string('file_ijazah')->nullable()->after('pas_foto');
            $table->string('file_ktp')->nullable()->after('file_ijazah');
        });
    }

    public function down(): void
    {
        Schema::table('peserta', function (Blueprint $table) {
            $table->dropColumn(['jenis_kelamin', 'pendidikan_terakhir', 'file_ijazah', 'file_ktp']);
        });
    }
};