<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'nama_lengkap' => 'Administrator SIAGA',
            'nip' => 'ADM001',
            'no_hp' => '081234567890',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'foto_profile' => null
        ]);

        // Pegawai 1
        User::create([
            'nama_lengkap' => 'Budi Setiawan',
            'nip' => 'PGW001',
            'no_hp' => '085712345670',
            'password' => Hash::make('pegawai123'),
            'role' => 'pegawai',
            'foto_profile' => null
        ]);

        // Pegawai 2
        User::create([
            'nama_lengkap' => 'Siti Rahma',
            'nip' => 'PGW002',
            'no_hp' => '085712345671',
            'password' => Hash::make('pegawai123'),
            'role' => 'pegawai',
            'foto_profile' => null
        ]);
    }
}