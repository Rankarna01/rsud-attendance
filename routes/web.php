<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

// Redirect halaman utama ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Grup khusus Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard'); // Halaman Dashboard Admin
    })->name('admin.dashboard');
    // Menu admin lainnya nanti di sini...
});

// Grup khusus Pegawai (PWA Mobile)
Route::middleware(['auth', 'role:pegawai'])->prefix('pegawai')->group(function () {
    Route::get('/home', function () {
        return view('pegawai.home'); // Halaman Home PWA
    })->name('pegawai.home');
    // Menu pegawai lainnya nanti di sini...
});
