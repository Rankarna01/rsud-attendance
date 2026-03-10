<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Cuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IzinController extends Controller
{
    public function index()
    {
        // Ambil riwayat izin/cuti pegawai yang sedang login
        $pengajuan = Cuti::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pegawai.izin.index', compact('pengajuan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:izin,sakit,cuti',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048' // Maks 2MB
        ]);

        $data = $request->only(['jenis', 'tanggal_mulai', 'tanggal_selesai', 'alasan']);
        $data['user_id'] = Auth::id();
        $data['status'] = 'pending'; // <--- Ubah jadi 'pending'

        // Proses upload lampiran jika ada
        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $fileName = 'lampiran/' . Auth::user()->nip . '-' . time() . '.' . $file->extension();
            $file->storeAs('public', $fileName);
            $data['lampiran'] = $fileName;
        }

        Cuti::create($data);

        return redirect()->back()->with('success', 'Pengajuan berhasil dikirim dan menunggu persetujuan Admin.');
    }
}
