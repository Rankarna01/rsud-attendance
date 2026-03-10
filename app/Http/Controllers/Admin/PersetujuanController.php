<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cuti;
use Illuminate\Http\Request;

class PersetujuanController extends Controller
{
    public function index()
    {
        // Tampilkan yang pending di atas
        $data = Cuti::with('user')->latest()->get();
        return view('admin.persetujuan.index', compact('data'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'keterangan_admin' => 'nullable|string'
        ]);

        $cuti = Cuti::findOrFail($id);
        $cuti->update([
            'status' => $request->status,
            'keterangan_admin' => $request->keterangan_admin
        ]);

        return redirect()->back()->with('success', 'Status permohonan berhasil diperbarui!');
    }
}