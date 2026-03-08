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
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('nama_lengkap');
        $table->string('nip')->unique(); // Sebagai ID Login Utama
        $table->string('no_hp')->unique(); // Sebagai ID Login Alternatif
        $table->string('password');
        $table->enum('role', ['admin', 'pegawai'])->default('pegawai');
        $table->string('foto_profile')->nullable();
        $table->rememberToken();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
