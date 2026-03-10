<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    $credentials = $request->validate([
        'login_identity' => 'required',
        'password' => 'required',
    ]);

    // Coba login via NIP
    $authNip = Auth::attempt(['nip' => $request->login_identity, 'password' => $request->password]);
    // Coba login via No HP
    $authHp = Auth::attempt(['no_hp' => $request->login_identity, 'password' => $request->password]);

    if ($authNip || $authHp) {
        $request->session()->regenerate();

        // Cek Role dan Redirect
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard'); // Pakai nama route
        }
        return redirect()->route('pegawai.home');
    }

    return back()->withErrors([
        'login_identity' => 'NIP/No HP atau Password salah.',
    ])->onlyInput('login_identity');
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}