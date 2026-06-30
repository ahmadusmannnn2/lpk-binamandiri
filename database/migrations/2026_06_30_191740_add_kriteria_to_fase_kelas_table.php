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
        Schema::table('fase_kelas', function (Blueprint $table) {
            $table->json('kriteria_penilaian')->nullable()->after('target_pertemuan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fase_kelas', function (Blueprint $table) {
            $table->dropColumn('kriteria_penilaian');
        });
    }
};
