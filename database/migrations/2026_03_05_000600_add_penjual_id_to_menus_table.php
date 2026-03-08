<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->foreignId('penjual_id')->nullable()->constrained('users')->nullOnDelete();
        });

        $penjualId = DB::table('users')->where('role', 'penjual')->value('id');
        if ($penjualId) {
            DB::table('menus')->whereNull('penjual_id')->update(['penjual_id' => $penjualId]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropConstrainedForeignId('penjual_id');
        });
    }
};
