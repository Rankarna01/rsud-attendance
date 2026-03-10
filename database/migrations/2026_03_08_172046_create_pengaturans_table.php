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
    Schema::create('pengaturans', function (Blueprint $table) {
        $table->id();
        $table->string('nama_lokasi')->default('Kantor RSUD');
        $table->string('lat_long'); // Contoh: -6.12345,106.12345
        $table->integer('radius');   // Dalam meter, contoh: 50
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturans');
    }
};
