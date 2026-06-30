<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nilai_fase', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained('pendaftaran')->cascadeOnDelete();
            $table->foreignId('fase_kelas_id')->constrained('fase_kelas')->cascadeOnDelete();
            $table->json('detail_nilai')->nullable();
            $table->decimal('nilai_rata_rata', 5, 2)->nullable();
            $table->text('catatan_instruktur')->nullable();
            $table->enum('status_kelulusan', ['belum_dinilai', 'lulus', 'tidak_lulus', 'mengulang'])->default('belum_dinilai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_fase');
    }
};
