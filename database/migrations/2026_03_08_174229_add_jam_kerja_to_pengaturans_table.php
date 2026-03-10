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
    Schema::table('pengaturans', function (Blueprint $table) {
        $table->time('jam_masuk')->default('08:00');
        $table->time('jam_pulang')->default('16:00');
        $table->integer('toleransi')->default(15); // Dalam menit
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengaturans', function (Blueprint $table) {
            //
        });
    }
};
