@extends('layouts.mobile') {{-- Menggunakan layout mobile agar terpusat --}}

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center px-6 py-12 bg-surface">
    
    <div class="mb-10 text-center">
        <div class="w-24 h-24 bg-primary rounded-2xl flex items-center justify-center mx-auto shadow-lg rotate-12 mb-6">
            <i class="fa-solid fa-fingerprint text-white text-5xl -rotate-12"></i>
        </div>
        <h1 class="text-3xl font-bold text-secondary">SIAGA</h1>
        <p class="text-gray-500">Sistem Absensi Pegawai Online</p>
    </div>

    <div class="w-full max-w-sm bg-white p-8 rounded-3xl shadow-xl border border-gray-100">
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">NIP atau No. HP</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <input type="text" name="login_identity" 
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all" 
                            placeholder="Masukkan NIP atau No. HP" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" name="password" 
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all" 
                            placeholder="••••••••" required>
                    </div>
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center text-gray-500 italic">
                        <input type="checkbox" class="rounded border-gray-300 text-primary mr-2"> Ingat saya
                    </label>
                    <a href="#" class="text-primary font-semibold hover:underline">Lupa Password?</a>
                </div>

                <button type="submit" 
                    class="w-full bg-primary hover:bg-dark-gold text-white font-bold py-4 rounded-xl shadow-lg shadow-yellow-200 transition-all active:scale-95">
                    MASUK SEKARANG
                </button>
            </div>
        </form>
    </div>

    <p class="mt-8 text-gray-400 text-sm">
        Versi 1.0.0 &copy; {{ date('Y') }} SIAGA App
    </p>
</div>
@endsection