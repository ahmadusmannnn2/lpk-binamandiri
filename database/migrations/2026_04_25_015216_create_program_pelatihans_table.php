<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_pelatihan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_program');
            $table->text('deskripsi')->nullable();
            $table->integer('harga_pelatihan')->default(0);
            $table->timestamps();
            $table->softDeletes(); // Fitur hapus aman
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_pelatihan');
    }
};