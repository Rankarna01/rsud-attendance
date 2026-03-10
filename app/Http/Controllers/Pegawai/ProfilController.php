<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


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
        ]);

        $user->no_hp = $request->no_hp;

        // Logika Ganti Password
        if ($request->filled('password_lama')) {
            if (!Hash::check($request->password_lama, $user->password)) {
                return redirect()->back()->with('error', 'Password lama tidak sesuai!');
            }
            $user->password = Hash::make($request->password_baru);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}