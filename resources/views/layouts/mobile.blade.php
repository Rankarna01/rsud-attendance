<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>SIAGA Mobile - Pegawai</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#F4C430',
                        secondary: '#1F2937',
                        surface: '#F9FAFB'
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        /* Gaya untuk Navigasi Aktif */
        .active-nav {
            color: #F4C430 !important;
        }

        .active-nav i {
            transform: translateY(-4px);
            color: #F4C430;
            transition: transform 0.3s ease;
        }

        /* Gaya untuk Tombol Tengah (Scan) Aktif */
        .active-scan {
            background-color: #000 !important;
            transform: scale(1.05);
        }

        .active-scan i {
            animation: scanPulse 2s infinite;
        }

        @keyframes scanPulse {
            0% {
                opacity: 1;
                text-shadow: 0 0 0 rgba(244, 196, 48, 0);
            }

            50% {
                opacity: 0.7;
                text-shadow: 0 0 15px rgba(244, 196, 48, 0.8);
            }

            100% {
                opacity: 1;
                text-shadow: 0 0 0 rgba(244, 196, 48, 0);
            }
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-top: 1px solid rgba(255, 255, 255, 0.5);
        }
    </style>
    @stack('styles')
</head>

<body class="bg-surface text-secondary pb-24">

    <nav
        class="sticky top-0 z-40 glass-effect border-b border-gray-100 px-5 py-4 flex justify-between items-center shadow-[0_5px_15px_rgba(0,0,0,0.02)]">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-secondary rounded-xl flex items-center justify-center shadow-lg shadow-gray-300/50">
                <span class="text-primary font-black text-xl">S</span>
            </div>
            <div>
                <h1 class="text-sm font-black uppercase tracking-tighter">SIAGA <span class="text-primary">Mobile</span>
                </h1>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest leading-none mt-0.5">Employee
                    Portal</p>
            </div>
        </div>
        <button
            class="relative w-10 h-10 bg-white rounded-xl text-secondary shadow-sm border border-gray-100 flex items-center justify-center hover:bg-gray-50 transition-colors">
            <i class="fa-solid fa-bell text-lg"></i>
            <span
                class="absolute top-2 right-2 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white animate-pulse"></span>
        </button>
    </nav>

    <main class="p-5">
        @yield('content')
    </main>

    <nav class="fixed bottom-0 left-0 right-0 z-50 glass-effect px-6 py-3 shadow-[0_-10px_30px_rgba(0,0,0,0.05)]">
        <div class="flex justify-between items-end relative">

            <a href="{{ route('pegawai.home') }}"
                class="flex flex-col items-center space-y-1 transition-all w-16 {{ request()->routeIs('pegawai.home') ? 'active-nav' : 'text-gray-400' }}">
                <i class="fa-solid fa-house-chimney text-xl transition-transform"></i>
                <span class="text-[10px] font-bold uppercase tracking-tighter">Home</span>
            </a>

            <a href="{{ route('pegawai.riwayat.index') }}"
                class="flex flex-col items-center space-y-1 transition-all w-16 {{ request()->routeIs('pegawai.riwayat.*') ? 'active-nav' : 'text-gray-400' }}">
                <i class="fa-solid fa-calendar-minus text-xl transition-transform"></i>
                <span class="text-[10px] font-bold uppercase tracking-tighter">Riwayat</span>
            </a>

            <div class="relative -mt-10 px-2">
                <a href="{{ route('pegawai.presensi.create') }}"
                    class="w-16 h-16 bg-secondary rounded-[1.2rem] flex items-center justify-center shadow-2xl shadow-primary/30 border-4 border-white transition-all {{ request()->routeIs('pegawai.presensi.create') ? 'active-scan' : 'hover:-translate-y-1 hover:shadow-primary/50' }}">
                    <i class="fa-solid fa-fingerprint text-primary text-3xl"></i>
                </a>
            </div>

            <a href="{{ route('pegawai.izin.index') }}" class="flex flex-col items-center space-y-1 transition-all w-16 text-gray-400">
                <i class="fa-solid fa-file-signature text-xl transition-transform"></i>
                <span class="text-[10px] font-bold uppercase tracking-tighter">Izin</span>
            </a>

            <a href="{{ route('pegawai.profil.index') }}" class="flex flex-col items-center space-y-1 transition-all w-16 text-gray-400">
                <i class="fa-solid fa-circle-user text-xl transition-transform"></i>
                <span class="text-[10px] font-bold uppercase tracking-tighter">Profil</span>
            </a>

        </div>
    </nav>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'SUKSES',
                text: "{{ session('success') }}",
                confirmButtonColor: '#F4C430',
                customClass: {
                    popup: 'rounded-3xl',
                    confirmButton: 'rounded-xl px-8 font-bold'
                }
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'PERHATIAN',
                text: "{{ session('error') }}",
                confirmButtonColor: '#1F2937',
                customClass: {
                    popup: 'rounded-3xl',
                    confirmButton: 'rounded-xl px-8 font-bold text-primary'
                }
            });
        </script>
    @endif

    @stack('scripts')
</body>

</html>
