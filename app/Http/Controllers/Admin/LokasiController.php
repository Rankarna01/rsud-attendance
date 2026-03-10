<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function index()
    {
        // Ambil data pertama, jika tidak ada buat objek kosong
        $lokasi = Pengaturan::first() ?? new Pengaturan();
        return view('admin.lokasi.index', compact('lokasi'));
    }

    public function update(Request $request)
{
    $request->validate([
        'nama_lokasi' => 'required',
        'lat_long' => 'required',
        'radius' => 'required|numeric',
    ]);

    // Menggunakan ID 1 sebagai patokan pengaturan tunggal
    \App\Models\Pengaturan::updateOrCreate(
        ['id' => 1], // Cari ID 1
        [
            'nama_lokasi' => $request->nama_lokasi,
            'lat_long' => $request->lat_long,
            'radius' => $request->radius,
        ]
    );

    return redirect()->back()->with('success', 'Konfigurasi lokasi berhasil disimpan!');
}
}