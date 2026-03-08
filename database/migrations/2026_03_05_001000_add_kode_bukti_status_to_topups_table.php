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
        Schema::table('topups', function (Blueprint $table) {
            $table->string('kode_transaksi')->nullable()->unique()->after('catatan');
            $table->string('bukti_transfer')->nullable()->after('kode_transaksi');
            $table->enum('status', ['pending', 'berhasil'])->default('pending')->after('bukti_transfer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('topups', function (Blueprint $table) {
            $table->dropColumn(['kode_transaksi', 'bukti_transfer', 'status']);
        });
    }
};
