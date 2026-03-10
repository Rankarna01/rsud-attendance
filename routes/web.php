<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController; // Pastikan ini ada!
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\Admin\PersetujuanController;
use App\Http\Controllers\Admin\LokasiController;
use App\Http\Controllers\Admin\JamKerjaController;
use App\Http\Controllers\Admin\KalenderController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Pegawai\PresensiController;
use App\Http\Controllers\Pegawai\HomeController as PegawaiHome;
use App\Http\Controllers\Pegawai\RiwayatController;
use App\Http\Controllers\Pegawai\IzinController;
use App\Http\Controllers\Pegawai\ProfilController;

// Redirect Home ke Login
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Group Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Menu Pegawai
    Route::get('/pegawai', [PegawaiController::class, 'index'])->name('admin.pegawai.index');
    Route::post('/pegawai', [PegawaiController::class, 'store'])->name('admin.pegawai.store');
    Route::put('/pegawai/{id}', [PegawaiController::class, 'update'])->name('admin.pegawai.update');
    Route::delete('/pegawai/{id}', [PegawaiController::class, 'destroy'])->name('admin.pegawai.destroy');


    Route::get('/persetujuan', [PersetujuanController::class, 'index'])->name('admin.persetujuan.index');
    Route::post('/persetujuan/{id}/update', [PersetujuanController::class, 'updateStatus'])->name('admin.persetujuan.update');

    Route::get('/lokasi', [LokasiController::class, 'index'])->name('admin.lokasi.index');
    Route::post('/lokasi/update', [LokasiController::class, 'update'])->name('admin.lokasi.update');


    Route::get('/kalender', [KalenderController::class, 'index'])->name('admin.kalender.index');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.laporan.index');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('admin.laporan.cetak');
    Route::get('/jam-kerja', [JamKerjaController::class, 'index'])->name('admin.jam-kerja.index');
Route::post('/jam-kerja/update', [JamKerjaController::class, 'update'])->name('admin.jam-kerja.update');
Route::get('/laporan/pdf', [LaporanController::class, 'cetakPdf'])->name('admin.laporan.pdf');
});

// Group Pegawai
Route::middleware(['auth', 'role:pegawai'])->prefix('p')->group(function () {
    Route::get('/home', [PegawaiHome::class, 'index'])->name('pegawai.home');

    // Route Absensi
    Route::get('/presensi', [PresensiController::class, 'create'])->name('pegawai.presensi.create');
    Route::post('/presensi', [PresensiController::class, 'store'])->name('pegawai.presensi.store');
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('pegawai.riwayat.index');
    Route::get('/izin', [IzinController::class, 'index'])->name('pegawai.izin.index');
    Route::post('/izin', [IzinController::class, 'store'])->name('pegawai.izin.store');
    // Route Profil
    Route::get('/profil', [ProfilController::class, 'index'])->name('pegawai.profil.index');
    Route::put('/profil', [ProfilController::class, 'update'])->name('pegawai.profil.update');
});