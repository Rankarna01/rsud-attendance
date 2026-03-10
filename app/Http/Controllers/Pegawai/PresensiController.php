<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PresensiController extends Controller
{
    public function create()
    {
        $today = Carbon::today()->format('Y-m-d');
        $presensi = Presensi::where('user_id', Auth::id())->where('tanggal', $today)->first();
        
        return view('pegawai.presensi.create', compact('presensi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lokasi' => 'required',
            'foto' => 'required' // Menampung base64 image
        ]);

        $user = Auth::user();
        $today = Carbon::today()->format('Y-m-d');
        $now = Carbon::now()->format('H:i:s'); // Sekarang sudah otomatis Asia/Jakarta
        
        // Proses Upload Foto Base64
        $image_parts = explode(";base64,", $request->foto);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        
        $fileName = 'absensi/' . $user->nip . '-' . date('Ymd-His') . '.' . $image_type;
        Storage::disk('public')->put($fileName, $image_base64);

        // Logic Jam Kerja
        $config = Pengaturan::first();
        $jam_masuk_kantor = $config ? $config->jam_masuk : '08:00:00';
        $toleransi = $config ? $config->toleransi : 15;
        $batas_telat = Carbon::parse($jam_masuk_kantor)->addMinutes($toleransi)->format('H:i:s');

        $presensi = Presensi::where('user_id', $user->id)->where('tanggal', $today)->first();

        if (!$presensi) {
            // PROSES ABSEN MASUK
            $is_late = $now > $batas_telat ? true : false;

            Presensi::create([
                'user_id' => $user->id,
                'tanggal' => $today,
                'jam_masuk' => $now,
                'status' => 'hadir',
                'is_late' => $is_late,
                'lokasi_masuk' => $request->lokasi,
                'foto_masuk' => $fileName // Simpan path foto
            ]);

            return redirect()->route('pegawai.home')->with('success', 'Absen Masuk Berhasil dengan validasi Wajah & GPS!');

        } else {
            // PROSES ABSEN PULANG
            if ($presensi->jam_pulang) {
                return redirect()->back()->with('error', 'Anda sudah melakukan Absen Pulang!');
            }

            $presensi->update([
                'jam_pulang' => $now,
                'lokasi_pulang' => $request->lokasi,
                'foto_pulang' => $fileName // Simpan path foto pulang
            ]);

            return redirect()->route('pegawai.home')->with('success', 'Absen Pulang Berhasil! Hati-hati di jalan.');
        }
    }
}