<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        // Filter bulan (Default: Bulan Ini)
        $bulanTerpilih = $request->bulan ?: Carbon::now()->format('Y-m');
        $namaBulan = Carbon::parse($bulanTerpilih)->translatedFormat('F Y');

        // Ambil data riwayat presensi user yang login sesuai bulan
        $riwayat = Presensi::where('user_id', Auth::id())
                    ->where('tanggal', 'like', "$bulanTerpilih%")
                    ->orderBy('tanggal', 'desc')
                    ->get();

        return view('pegawai.riwayat.index', compact('riwayat', 'bulanTerpilih', 'namaBulan'));
    }
}