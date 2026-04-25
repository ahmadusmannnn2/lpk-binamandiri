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
            $table->string('nomor_telepon')->nullable();
            $table->string('spesialisasi_las')->nullable(); // contoh: SMAW, GTAW, dll
            $table->text('alamat')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instruktur');
    }
};