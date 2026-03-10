<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = User::where('role', 'pegawai')->latest()->get();
        return view('admin.pegawai.index', compact('pegawai'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nip' => 'required|unique:users,nip',
            'no_hp' => 'required|unique:users,no_hp',
            'password' => 'required|min:6',
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'nip' => $request->nip,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'role' => 'pegawai',
        ]);

        return redirect()->back()->with('success', 'Pegawai baru berhasil didaftarkan ke sistem!');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nip' => ['required', Rule::unique('users')->ignore($user->id)],
            'no_hp' => ['required', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->nama_lengkap = $request->nama_lengkap;
        $user->nip = $request->nip;
        $user->no_hp = $request->no_hp;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Data pegawai ' . $user->nama_lengkap . ' berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Pegawai berhasil dihapus.');
    }
}