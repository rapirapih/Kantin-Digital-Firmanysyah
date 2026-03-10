<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nama_lengkap')->nullable()->after('name');
            $table->string('nis')->nullable()->after('nama_lengkap');
            $table->string('nik')->nullable()->after('nis');
            $table->string('kelas')->nullable()->after('nik');
            $table->string('jurusan')->nullable()->after('kelas');
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan'])->nullable()->after('jurusan');
            $table->boolean('profile_completed')->default(false)->after('jenis_kelamin');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nama_lengkap', 'nis', 'nik', 'kelas', 'jurusan', 'jenis_kelamin', 'profile_completed']);
        });
    }
};
