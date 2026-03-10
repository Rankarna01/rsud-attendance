# SIAGA - Sistem Absensi RSUD Gusti Abdul Gani 🏥

SIAGA (Sistem Absensi Kepegawaian) adalah platform presensi digital terpadu berbasis web dan PWA (Progressive Web App) yang dibangun menggunakan Laravel. Sistem ini dirancang khusus untuk instansi kesehatan (RSUD) dengan fitur pelacakan lokasi (Geofencing) dan validasi foto wajah (Live Capture) untuk mencegah kecurangan absensi.

## ✨ Fitur Utama

**👨‍💻 Admin Panel (Web Dashboard)**
* Dashboard analitik kehadiran pegawai real-time.
* Manajemen Data Pegawai (CRUD).
* Pengaturan Jam Operasional & Toleransi Keterlambatan.
* Pengaturan Lokasi Kantor (Titik Kordinat / Geofencing).
* Persetujuan Izin, Sakit, dan Cuti (Approval System).
* Cetak Laporan Kehadiran Bulanan (Export to PDF).

**📱 Employee Portal (Mobile PWA)**
* Presensi "Tap In" & "Tap Out" berbasis GPS.
* Validasi kehadiran menggunakan Live Camera (Selfie).
* Pengajuan Izin/Sakit/Cuti beserta upload bukti lampiran pendukung.
* Riwayat absensi bulanan lengkap dengan log waktu dan lokasi (Google Maps link).
* Manajemen Profil Pegawai.

---

## 🛠️ Persyaratan Sistem (Prerequisites)

Sebelum menginstal aplikasi ini, pastikan komputer/server Anda telah terinstal:
* PHP >= 8.1
* Composer
* MySQL / MariaDB
* Node.js & NPM (Opsional, untuk *compile* aset jika diperlukan)

---

## 🚀 Panduan Instalasi

Anda dapat menginstal proyek ini menggunakan dua cara: melalui **Git Clone** (Disarankan) atau **Download Manual (ZIP)**.

### Opsi 1: Melalui Git Clone (Sangat Disarankan)

1. Buka Terminal / Command Prompt.
2. Clone repository github ini ke dalam folder lokal Anda:
   ```bash
   git clone [https://github.com/Rankarna01/rsud-attendance.git](https://github.com/Rankarna01/rsud-attendance.git)