<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data lama jika ada untuk menghindari duplicate entry saat testing
        User::truncate();

        // 1. Data Admin
        User::create([
            'nama_lengkap' => 'Administrator SIAGA',
            'nip'          => '123456',
            'no_hp'        => '08123456789',
            'password'     => Hash::make('admin123'),
            'role'         => 'admin',
        ]);

        // 2. Data Pegawai
        User::create([
            'nama_lengkap' => 'Budi Setiawan',
            'nip'          => '19900101',
            'no_hp'        => '08571234567',
            'password'     => Hash::make('pegawai123'),
            'role'         => 'pegawai',
        ]);
    }
}