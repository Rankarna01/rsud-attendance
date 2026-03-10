@extends('layouts.mobile')

@section('content')
<div class="space-y-6 animate-fadeIn pb-10">
    
    <div class="bg-secondary p-7 rounded-[1.5rem] shadow-2xl relative overflow-hidden">
        <div class="absolute -right-10 -top-10 w-48 h-48 bg-primary/20 rounded-full blur-[40px] animate-pulse"></div>
        <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-white/5 rounded-full blur-[30px]"></div>
        
        <div class="relative z-10 flex items-center justify-between border-b border-white/10 pb-5 mb-5">
            <div class="flex items-center space-x-4">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->nama_lengkap) }}&background=F4C430&color=1F2937&bold=true" 
                     class="w-14 h-14 rounded-[1.2rem] border-2 border-primary shadow-lg" alt="Avatar">
                <div>
                    <p class="text-gray-400 text-[10px] font-black uppercase tracking-[0.2em] mb-0.5">Welcome Back,</p>
                    <h2 class="text-white text-xl font-black tracking-tight leading-none">{{ explode(' ', $user->nama_lengkap)[0] }}</h2>
                    <div class="mt-1.5 inline-flex items-center px-2.5 py-0.5 bg-primary/20 border border-primary/30 rounded-md text-[9px] text-primary font-black uppercase tracking-widest">
                        NIP: {{ $user->nip }}
                    </div>
                </div>
            </div>
        </div>

        <div class="relative z-10 flex justify-between items-end">
            <div>
                <p class="text-primary text-[10px] font-black uppercase tracking-[0.2em] mb-1">Waktu Server (WIB)</p>
                <div class="flex items-baseline space-x-1">
                    <h1 id="live-time" class="text-white text-5xl font-black tracking-tighter tabular-nums drop-shadow-lg">00:00</h1>
                    <span id="live-sec" class="text-gray-400 text-lg font-bold">00</span>
                </div>
            </div>
            <div class="text-right">
                <div class="bg-white/10 backdrop-blur-sm border border-white/10 p-2.5 rounded-2xl inline-block text-center">
                    <p id="live-day" class="text-white font-black text-sm uppercase tracking-widest">Senin</p>
                    <p id="live-date" class="text-gray-400 text-[9px] font-bold uppercase tracking-widest mt-0.5">01 Jan 2026</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex flex-col items-center text-center group transition-all hover:border-primary/30">
            <div class="w-12 h-12 bg-green-50 text-green-500 rounded-2xl flex items-center justify-center mb-4 text-xl shadow-inner group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-clock"></i>
            </div>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none">Waktu Masuk</p>
            <h4 class="text-secondary font-black text-2xl mt-1.5 tracking-tighter tabular-nums">
                {{ $presensi ? substr($presensi->jam_masuk, 0, 5) : '--:--' }}
            </h4>
        </div>
        
        <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex flex-col items-center text-center group transition-all hover:border-primary/30">
            <div class="w-12 h-12 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center mb-4 text-xl shadow-inner group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none">Waktu Pulang</p>
            <h4 class="text-secondary font-black text-2xl mt-1.5 tracking-tighter tabular-nums">
                {{ $presensi && $presensi->jam_pulang ? substr($presensi->jam_pulang, 0, 5) : '--:--' }}
            </h4>
        </div>
    </div>

    <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm">
        <h3 class="text-sm font-black text-secondary uppercase tracking-widest mb-6 border-l-4 border-primary pl-4">Laporan Bulan Ini</h3>
        <div class="flex justify-between items-center px-2">
            <div class="flex flex-col items-center">
                <span class="text-3xl font-black text-secondary tracking-tighter">{{ $stats['hadir'] }}</span>
                <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest mt-1">Hadir</span>
            </div>
            <div class="w-[1px] h-10 bg-gray-100"></div>
            <div class="flex flex-col items-center">
                <span class="text-3xl font-black text-orange-500 tracking-tighter">{{ $stats['izin'] }}</span>
                <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest mt-1">Izin</span>
            </div>
            <div class="w-[1px] h-10 bg-gray-100"></div>
            <div class="flex flex-col items-center">
                <span class="text-3xl font-black text-red-500 tracking-tighter">{{ $stats['telat'] }}</span>
                <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest mt-1">Telat</span>
            </div>
        </div>
    </div>

    <div class="bg-primary p-6 rounded-[2rem] shadow-xl shadow-primary/20 flex items-center justify-between relative overflow-hidden group">
        <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform duration-500">
            <i class="fa-solid fa-camera text-8xl text-secondary"></i>
        </div>
        <div class="relative z-10 pr-10">
            <h4 class="text-secondary font-black text-lg leading-tight uppercase tracking-tighter">Sudah Absen Hari Ini?</h4>
            <p class="text-secondary/80 text-[10px] font-bold mt-1 uppercase tracking-widest leading-snug">Pastikan kamera & GPS aktif saat tap absensi.</p>
        </div>
        <i class="fa-solid fa-chevron-right text-secondary/30 text-xl group-hover:translate-x-1 transition-transform"></i>
    </div>
</div>

@push('scripts')
<script>
    function updateClock() {
        const now = new Date();
        
        // Format Waktu
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        
        document.getElementById('live-time').innerText = `${hours}:${minutes}`;
        document.getElementById('live-sec').innerText = seconds;

        // Format Tanggal Bahasa Indonesia
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        
        const dayName = days[now.getDay()];
        const date = now.getDate();
        const monthName = months[now.getMonth()];
        const year = now.getFullYear();

        document.getElementById('live-day').innerText = dayName;
        document.getElementById('live-date').innerText = `${date} ${monthName} ${year}`;
    }

    // Jalankan setiap 1 detik
    setInterval(updateClock, 1000);
    // Jalankan pertama kali agar tidak menunggu 1 detik
    updateClock();
</script>
@endpush
@endsection