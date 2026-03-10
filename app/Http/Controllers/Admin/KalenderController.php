<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi; // Asumsi model absensi sudah ada
use Illuminate\Http\Request;

class KalenderController extends Controller
{
    public function index(Request $request)
{
    $bulanTerpilih = $request->bulan ?: \Carbon\Carbon::now()->format('Y-m');
    $date = \Carbon\Carbon::parse($bulanTerpilih);
    $jumlahHari = $date->daysInMonth;
    $namaBulan = $date->translatedFormat('F Y');

    // Ambil Pegawai dengan Pagination 10 data
    $pegawai = \App\Models\User::where('role', 'pegawai')
                ->orderBy('nama_lengkap', 'asc')
                ->paginate(10)
                ->withQueryString(); // Agar filter bulan tidak hilang saat pindah page

    $matrix = [];
    foreach ($pegawai as $p) {
        $dataPerHari = [];
        for ($tgl = 1; $tgl <= $jumlahHari; $tgl++) {
            $fullDate = $date->format('Y-m-') . sprintf('%02d', $tgl);
            
            $cekAbsen = \App\Models\Absensi::where('user_id', $p->id)->where('tanggal', $fullDate)->first();
            $cekCuti = \App\Models\Cuti::where('user_id', $p->id)
                        ->where('status', 'disetujui')
                        ->where('tanggal_mulai', '<=', $fullDate)
                        ->where('tanggal_selesai', '>=', $fullDate)
                        ->first();

            $status = 'alfa'; 
            if ($cekAbsen) {
                $status = ($cekAbsen->jam_masuk > '08:15:00') ? 'telat' : 'hadir';
            } elseif ($cekCuti) {
                $status = $cekCuti->jenis; 
            }
            $dataPerHari[$tgl] = $status;
        }
        
        $matrix[] = [
            'user' => $p,
            'days' => $dataPerHari
        ];
    }

    return view('admin.kalender.index', compact('matrix', 'pegawai', 'jumlahHari', 'namaBulan', 'bulanTerpilih'));
}
}