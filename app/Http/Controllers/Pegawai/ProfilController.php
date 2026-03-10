<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('pegawai.profil.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'no_hp' => ['required', Rule::unique('users')->ignore($user->id)],
            'password_lama' => 'nullable|required_with:password_baru',
            'password_baru' => 'nullable|min:6|required_with:password_lama',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validasi foto maksimal 2MB
        ]);

        $user->no_hp = $request->no_hp;

        // Logika Upload Foto Profil
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            // Simpan foto baru
            $file = $request->file('foto');
            $namaFile = $user->nip . '-' . time() . '.' . $file->extension();
            
            // PERBAIKAN: Tambahkan parameter 'public' di akhir agar masuk ke disk yang benar
            $file->storeAs('profil', $namaFile, 'public');
            
            $user->foto = 'profil/' . $namaFile;
        }

        // Logika Ganti Password
        if ($request->filled('password_lama')) {
            if (!Hash::check($request->password_lama, $user->password)) {
                return redirect()->back()->with('error', 'Password lama tidak sesuai!');
            }
            $user->password = Hash::make($request->password_baru);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil dan foto berhasil diperbarui!');
    }
}