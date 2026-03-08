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
        $request->validate([
            'login_identity' => 'required|string',
            'password' => 'required',
        ]);

        // Cek apakah input adalah NIP atau No HP (Logika sederhana: jika numerik dan panjang tertentu)
        $loginField = filter_var($request->login_identity, FILTER_VALIDATE_INT) ? 'nip' : 'no_hp';
        
        // Kita juga bisa cek keduanya sekaligus
        $credentials1 = ['nip' => $request->login_identity, 'password' => $request->password];
        $credentials2 = ['no_hp' => $request->login_identity, 'password' => $request->password];

        if (Auth::attempt($credentials1) || Auth::attempt($credentials2)) {
            $request->session()->regenerate();

            // Redirect berdasarkan role
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }
            
            return redirect()->intended('/pegawai/home');
        }

        return back()->withErrors([
            'login_identity' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
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