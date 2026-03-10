<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategoris', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            $table->timestamps();
        });

        // Seed default categories
        DB::table('kategoris')->insert([
            ['nama' => 'makanan', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'minuman', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'snack', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('kategoris');
    }
};
