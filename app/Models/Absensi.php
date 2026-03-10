<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $fillable = [
        'user_id', 'tanggal', 'jam_masuk', 'jam_pulang', 
        'foto_masuk', 'foto_pulang', 'status', 'keterangan'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
