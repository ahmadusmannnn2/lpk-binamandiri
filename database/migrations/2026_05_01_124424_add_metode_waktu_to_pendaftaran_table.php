<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->string('metode_pembayaran')->nullable()->after('status_pembayaran');
            $table->dateTime('waktu_pembayaran')->nullable()->after('metode_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->dropColumn(['metode_pembayaran', 'waktu_pembayaran']);
        });
    }
};