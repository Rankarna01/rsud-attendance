<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Presensi; // Pastikan Model Presensi ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();

        // Ambil data absen hari ini
        $presensi = Presensi::where('user_id', $user->id)
                            ->whereDate('created_at', $today)
                            ->first();

        // Logic ringkasan (dummy data jika belum ada)
        $stats = [
            'hadir' => Presensi::where('user_id', $user->id)->where('status', 'hadir')->count(),
            'izin' => Presensi::where('user_id', $user->id)->where('status', 'izin')->count(),
            'telat' => Presensi::where('user_id', $user->id)->where('is_late', true)->count(),
        ];

        return view('pegawai.home', compact('user', 'presensi', 'stats'));
    }
}