<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil UserSeeder agar data admin & pegawai terinput
        $this->call([
            UserSeeder::class,
        ]);
    }
}