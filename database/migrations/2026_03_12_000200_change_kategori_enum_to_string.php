<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE menus MODIFY kategori VARCHAR(100) NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE menus MODIFY kategori ENUM('makanan','minuman','snack') NOT NULL DEFAULT 'makanan'");
    }
};
