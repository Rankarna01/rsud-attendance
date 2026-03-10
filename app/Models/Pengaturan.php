<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $fillable = [
        'jam_masuk', 
        'jam_pulang', 
        'toleransi',
        'lat_long', // <--- Pastikan ini ditambahkan
        'radius'
    ];
}
