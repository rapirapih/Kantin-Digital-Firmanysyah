<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE orders MODIFY COLUMN status_pesanan ENUM('menunggu','diproses','siap_diambil','selesai','dibatalkan') DEFAULT 'menunggu'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE orders MODIFY COLUMN status_pesanan ENUM('menunggu','diproses','selesai','dibatalkan') DEFAULT 'menunggu'");
    }
};
