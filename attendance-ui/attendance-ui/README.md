# 📱 Employee Attendance System - UI Slicing HTML

Folder ini berisi **semua halaman HTML** dengan styling Tailwind CSS untuk:
- **Admin Dashboard** (6 halaman)
- **Employee Mobile PWA** (6 halaman)

## 📁 Struktur Folder

```
attendance-ui/
├── index.html              ← Halaman utama (navigasi ke semua pages)
├── README.md
├── admin/
│   ├── dashboard.html      ← 📊 Dashboard
│   ├── employees.html      ← 👥 Data Pegawai
│   ├── leave-approvals.html ← 📋 Persetujuan Izin/Cuti
│   ├── attendance-report.html ← 📈 Laporan Absensi
│   ├── calendar-report.html ← 📅 Laporan Kalender
│   └── settings.html       ← ⚙️ Pengaturan Jam Kerja & Lokasi Kantor
└── mobile/
    ├── login.html          ← 🔐 Login
    ├── home.html           ← 🏠 Home
    ├── attendance.html     ← 📷 Attendance Camera
    ├── history.html        ← 📜 Attendance History
    ├── leave.html          ← 📋 Leave Request
    └── profile.html        ← 👤 Profile
```

## 🚀 Cara Menggunakan

### 1. **Buka Index Page**
Buka `index.html` di browser untuk melihat navigasi ke semua halaman:
```
file:///path/to/attendance-ui/index.html
```

### 2. **Admin Dashboard Pages** (dalam folder `admin/`)
| Halaman | File | Fitur |
|---------|------|-------|
| Dashboard | `dashboard.html` | Stat cards, Chart, Recent activity |
| Data Pegawai | `employees.html` | Table karyawan, Add/Edit/Delete |
| Persetujuan Izin/Cuti | `leave-approvals.html` | List permintaan izin, Approve/Reject |
| Laporan Absensi | `attendance-report.html` | Filter (Daily/Weekly/Monthly), Attendance table |
| Laporan Kalender | `calendar-report.html` | Calendar grid dengan status (✓, ✖, S, I) |
| Pengaturan | `settings.html` | Office location, Working hours, Late tolerance |

### 3. **Mobile PWA Pages** (dalam folder `mobile/`)
| Halaman | File | Fitur |
|---------|------|-------|
| Login | `login.html` | Email, Password, Demo credentials |
| Home | `home.html` | Greeting, Time, Attendance status, Quick actions |
| Attendance | `attendance.html` | Camera preview, GPS, Capture button |
| History | `history.html` | List check-in/out records |
| Leave | `leave.html` | Form untuk submit leave request |
| Profile | `profile.html` | User info, Account details, Sign out |

## 🎨 Styling & Design

Semua HTML menggunakan:
- **Tailwind CSS** (via CDN): `https://cdn.tailwindcss.com`
- **Font**: Plus Jakarta Sans (Google Fonts)
- **Color Scheme**:
  - Primary: `#EAB308` (Golden Yellow)
  - Secondary: `#F59E0B` (Orange)
  - Background: `#F8F8F8` (Light Gray)

## 📱 Mobile Responsiveness

### Admin Pages
- Desktop-first design dengan sidebar
- Responsive untuk tablet & mobile
- Max-width: full screen

### Mobile Pages
- Mobile-first design
- Max-width: `max-w-md` (428px)
- Bottom navigation bar
- Safe area padding untuk notch devices

## 🔗 Navigation Links

Semua halaman sudah linked:

**Admin:**
```
index.html → admin/dashboard.html
         → admin/employees.html
         → admin/leave-approvals.html
         → admin/attendance-report.html
         → admin/calendar-report.html
         → admin/settings.html
```

**Mobile:**
```
index.html → mobile/login.html
         → mobile/home.html
         → mobile/attendance.html
         → mobile/history.html
         → mobile/leave.html
         → mobile/profile.html
```

Semua mobile pages memiliki bottom navigation yang menghubungkan ke halaman lain.

## 💾 Cara Mengintegrasikan

### Opsi 1: Standalone HTML
Gunakan HTML files langsung tanpa backend:
```bash
# Buka di browser
open index.html
```

### Opsi 2: Copy ke Web Server
```bash
cp -r attendance-ui/* /var/www/html/
```

### Opsi 3: Integrate dengan React/Vue/Framework
Gunakan HTML sebagai reference untuk component structure dan styling.

## 📝 Demo Credentials (di Login Page)

```
Admin Account:
Email: admin@example.com
Password: password

Employee Account:
Email: user@example.com
Password: password
```

## 🎯 Keunggulan UI Slicing Ini

✅ **Complete & Professional** - Semua halaman sudah siap pakai
✅ **Responsive Design** - Bekerja di desktop, tablet, mobile
✅ **Tailwind CSS** - Easy to customize & maintain
✅ **No Dependencies** - Pure HTML, hanya butuh browser
✅ **Well-Organized** - Folder structure yang rapi
✅ **Self-Contained** - Semua styling inline dengan Tailwind CDN
✅ **Navigation Ready** - Semua halaman sudah linked
✅ **Modern Design** - Golden yellow theme, soft shadows, large radius

## 🛠️ Kustomisasi

### Mengubah Warna
Edit di tag `<style>` dalam `<head>` atau modify Tailwind classes:

```html
<!-- Ganti dari -->
<div class="bg-amber-400 text-white">

<!-- Ke warna lain -->
<div class="bg-blue-500 text-white">
```

### Menambah Konten
Semua halaman menggunakan semantic HTML, mudah untuk:
- Menambah rows di table
- Menambah form fields
- Menambah cards atau components

### Mengubah Font
Modify di `<link>` Google Fonts atau CSS:

```html
<!-- Default -->
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<!-- Ganti dengan font lain -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
```

## 📞 Support

Jika ingin:
- Menambah halaman baru
- Mengintegrasikan dengan backend API
- Menambah form handling dengan JavaScript
- Mengubah layout atau design

Silakan modify HTML files sesuai kebutuhan. Semua files menggunakan standard HTML + Tailwind CSS yang mudah di-customize.

---

**Created**: March 8, 2024
**Format**: HTML with Tailwind CSS
**Status**: Production Ready ✅
