<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class JamKerjaController extends Controller
{
    public function index()
    {
        $jam = Pengaturan::first() ?? new Pengaturan();
        return view('admin.jam-kerja.index', compact('jam'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'jam_masuk' => 'required',
            'jam_pulang' => 'required',
            'toleransi' => 'required|numeric|min:0',
        ]);

        $pengaturan = Pengaturan::first();

        // Jika data sudah ada, Update. Jika belum ada, Create.
        if ($pengaturan) {
            $pengaturan->update([
                'jam_masuk' => $request->jam_masuk,
                'jam_pulang' => $request->jam_pulang,
                'toleransi' => $request->toleransi,
            ]);
        } else {
            Pengaturan::create([
                'jam_masuk' => $request->jam_masuk,
                'jam_pulang' => $request->jam_pulang,
                'toleransi' => $request->toleransi,
                'lat_long' => '-6.200000,106.816666', // Koordinat dummy (bisa diubah nanti di menu Lokasi)
                'radius' => 50, // Nilai default radius (jika ada kolomnya di DB)
            ]);
        }

        return redirect()->back()->with('success', 'Konfigurasi Jam Kerja berhasil diperbarui!');
    }
}