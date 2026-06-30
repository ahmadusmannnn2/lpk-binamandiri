<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instruktur', function (Blueprint $table) {
            $table->id();
            // Menghubungkan instruktur dengan akun login (tabel users)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Kolom-kolom yang dibutuhkan oleh sistem
            $table->string('nip', 50)->nullable();
            $table->string('nomor_telepon')->nullable();
            $table->string('keahlian')->nullable();
            $table->string('foto')->nullable();
            $table->text('alamat')->nullable(); // Tetap dibiarkan jika sewaktu-waktu dibutuhkan
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instruktur');
    }
};