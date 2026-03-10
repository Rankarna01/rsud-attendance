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
    Schema::create('cutis', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->date('tanggal_mulai');
        $table->date('tanggal_selesai');
        $table->enum('jenis', ['izin', 'sakit', 'cuti']);
        $table->text('alasan');
        $table->string('lampiran')->nullable(); // Foto surat dokter/undangan
        $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
        $table->text('keterangan_admin')->nullable(); // Alasan jika ditolak
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cutis');
    }
};
