<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Absensi;
use App\Models\Cuti;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $pegawai = User::where('role', 'pegawai')->get();
        $bulan = $request->bulan ?: Carbon::now()->format('Y-m');
        $selected_user = $request->user_id;

        // Panggil helper pembuat data
        $dataLaporan = $this->getRekapData($bulan, $selected_user);
        
        $rekap = $dataLaporan['rekap'];
        $stats = $dataLaporan['stats'];

        return view('admin.laporan.index', compact('pegawai', 'rekap', 'stats', 'bulan'));
    }

    public function cetakPdf(Request $request)
    {
        $bulan = $request->bulan ?: Carbon::now()->format('Y-m');
        $selected_user = $request->user_id;
        
        // Panggil helper pembuat data untuk PDF
        $dataLaporan = $this->getRekapData($bulan, $selected_user);
        
        $data = [
            'rekap' => $dataLaporan['rekap'], 
            'stats' => $dataLaporan['stats'],
            'bulan' => $bulan
        ];
        
        // Render PDF menggunakan DomPDF
        $pdf = Pdf::loadView('admin.laporan.pdf', $data)->setPaper('a4', 'landscape');
        return $pdf->download("Rekap_Absensi_RSUD_$bulan.pdf");
    }

    /**
     * Helper Function: Agar logika hitung absen tidak ditulis 2 kali (DRY Principle)
     */
    private function getRekapData($bulan, $selected_user = null) 
    {
        $pegawai = User::where('role', 'pegawai')->get();
        
        // Ambil Jam Masuk dari Pengaturan
        $config = Pengaturan::first();
        $jam_masuk_config = $config ? $config->jam_masuk : '08:00:00';

        $rekap = [];
        foreach ($pegawai as $p) {
            // Skip jika admin memilih filter 1 pegawai tertentu
            if ($selected_user && $p->id != $selected_user) continue;

            $hadir = Absensi::where('user_id', $p->id)->where('tanggal', 'like', "$bulan%")->count();
            $telat = Absensi::where('user_id', $p->id)->where('tanggal', 'like', "$bulan%")->whereTime('jam_masuk', '>', $jam_masuk_config)->count();
            
            $izin = Cuti::where('user_id', $p->id)->where('status', 'disetujui')->where('jenis', 'izin')->where('tanggal_mulai', 'like', "$bulan%")->count();
            $sakit = Cuti::where('user_id', $p->id)->where('status', 'disetujui')->where('jenis', 'sakit')->where('tanggal_mulai', 'like', "$bulan%")->count();
            $cuti = Cuti::where('user_id', $p->id)->where('status', 'disetujui')->where('jenis', 'cuti')->where('tanggal_mulai', 'like', "$bulan%")->count();

            $rekap[] = [
                'nama' => $p->nama_lengkap,
                'nip' => $p->nip,
                'hadir' => $hadir,
                'telat' => $telat,
                'izin' => $izin,
                'sakit' => $sakit,
                'cuti' => $cuti,
            ];
        }

        $stats = [
            'hadir' => collect($rekap)->sum('hadir'),
            'telat' => collect($rekap)->sum('telat'),
            'izin' => collect($rekap)->sum('izin'),
            'sakit' => collect($rekap)->sum('sakit'),
            'cuti' => collect($rekap)->sum('cuti'),
        ];

        return ['rekap' => $rekap, 'stats' => $stats]; 
    }
}