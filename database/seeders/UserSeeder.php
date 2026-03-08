<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
{
    // Data Admin
    \App\Models\User::create([
        'nama_lengkap' => 'Administrator SIAGA',
        'nip' => '123456',
        'no_hp' => '08123456789',
        'password' => bcrypt('admin123'),
        'role' => 'admin',
    ]);

    // Data Pegawai Contoh
    \App\Models\User::create([
        'nama_lengkap' => 'Budi Setiawan',
        'nip' => '19900101',
        'no_hp' => '08571234567',
        'password' => bcrypt('pegawai123'),
        'role' => 'pegawai',
    ]);
}
}
