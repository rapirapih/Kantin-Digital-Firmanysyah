<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'user', 'penjual', 'pembeli') NOT NULL DEFAULT 'pembeli'");
        }

        DB::table('users')
            ->where('role', 'user')
            ->update(['role' => 'pembeli']);

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'penjual', 'pembeli') NOT NULL DEFAULT 'pembeli'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'user', 'penjual', 'pembeli') NOT NULL DEFAULT 'user'");
        }

        DB::table('users')
            ->where('role', 'pembeli')
            ->update(['role' => 'user']);

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'user') NOT NULL DEFAULT 'user'");
        }
    }
};
