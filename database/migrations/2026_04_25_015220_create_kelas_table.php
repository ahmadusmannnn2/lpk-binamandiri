<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            // Menghubungkan kelas dengan program pelatihan dan instruktur
            $table->foreignId('program_pelatihan_id')->constrained('program_pelatihan')->onDelete('cascade');
            $table->foreignId('instruktur_id')->constrained('instruktur')->onDelete('cascade');
            $table->string('nama_kelas');
            $table->integer('kuota_peserta')->default(20);
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->enum('status_kelas', ['menunggu', 'berjalan', 'selesai'])->default('menunggu');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};