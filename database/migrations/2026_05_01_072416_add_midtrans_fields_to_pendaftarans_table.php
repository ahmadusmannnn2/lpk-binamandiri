<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->string('status_pembayaran')->default('pending')->after('status_pendaftaran');
            $table->string('snap_token')->nullable()->after('status_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropColumn(['status_pembayaran', 'snap_token']);
        });
    }
};