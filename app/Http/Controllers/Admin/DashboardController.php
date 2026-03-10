<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Absensi;
use App\Models\Aktivitas;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $hariIni = Carbon::today()->toDateString();
        
        // 1. Total Pegawai (Role Pegawai saja)
        $totalPegawai = User::where('role', 'pegawai')->count();

        // 2. Hadir Hari Ini (Status hadir atau telat)
        $hadir = Absensi::where('tanggal', $hariIni)
                        ->whereIn('status', ['hadir', 'telat'])
                        ->count();

        // 3. Izin / Sakit
        $izinSakit = Absensi::where('tanggal', $hariIni)
                            ->whereIn('status', ['izin', 'sakit'])
                            ->count();

        // 4. Belum Hadir (Total - (Hadir + Izin))
        $belumHadir = $totalPegawai - ($hadir + $izinSakit);

        // 5. Aktivitas Terbaru (Ambil 5 data terakhir)
        $aktivitas = Aktivitas::latest()->limit(5)->get();

        // 6. Data Chart (Contoh 7 hari terakhir)
        $chartData = $this->getChartData();

        return view('admin.dashboard', compact('totalPegawai', 'hadir', 'izinSakit', 'belumHadir', 'aktivitas', 'chartData'));
    }

    private function getChartData() {
        // Logika dummy untuk chart, nanti bisa dibuat dinamis dari database
        return [
            'labels' => ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
            'data' => [65, 80, 85, 90, 75, 95]
        ];
    }
}