<aside class="w-64 bg-secondary min-h-screen text-white flex flex-col shadow-lg border-r border-white/5">
    <div class="p-6 flex items-center space-x-3 border-b border-white/5">
        <div class="w-10 h-10 bg-primary rounded flex items-center justify-center text-secondary shadow-lg">
            <i class="fa-solid fa-fingerprint text-xl"></i>
        </div>
        <div>
            <h1 class="text-xl font-bold tracking-tight text-white leading-none">SI<span class="text-primary">AGA</span></h1>
            <p class="text-[9px] text-gray-400 uppercase tracking-widest mt-1 font-black">RSUD Gusti Abdul Gani</p>
        </div>
    </div>

    <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto">
        
        <div class="text-[10px] font-black text-gray-600 uppercase tracking-[0.2em] px-4 pb-2">Main Dashboard</div>

        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center px-4 py-3 rounded-sm transition-all group {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-secondary font-bold' : 'text-gray-400 hover:bg-white/5 hover:text-primary' }}">
            <i class="fa-solid fa-gauge-high w-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-secondary' : 'text-gray-500 group-hover:text-primary' }}"></i>
            <span class="text-[11px] uppercase font-bold tracking-wider">Dashboard</span>
        </a>

        <div class="text-[10px] font-black text-gray-600 uppercase tracking-[0.2em] px-4 pt-6 pb-2">Main Menu</div>

        <a href="{{ route('admin.pegawai.index') }}" 
           class="flex items-center px-4 py-3 rounded-sm transition-all group {{ request()->routeIs('admin.pegawai.*') ? 'bg-primary text-secondary font-bold' : 'text-gray-400 hover:bg-white/5 hover:text-primary' }}">
            <i class="fa-solid fa-users w-5 mr-3 {{ request()->routeIs('admin.pegawai.*') ? 'text-secondary' : 'text-gray-500 group-hover:text-primary' }}"></i>
            <span class="text-[11px] uppercase font-bold tracking-wider">Data Pegawai</span>
        </a>

        <a href="{{ route('admin.persetujuan.index') }}" 
           class="flex items-center px-4 py-3 rounded-sm transition-all group {{ request()->routeIs('admin.persetujuan.*') ? 'bg-primary text-secondary font-bold' : 'text-gray-400 hover:bg-white/5 hover:text-primary' }}">
            <i class="fa-solid fa-envelope-open-text w-5 mr-3 {{ request()->routeIs('admin.persetujuan.*') ? 'text-secondary' : 'text-gray-500 group-hover:text-primary' }}"></i>
            <span class="text-[11px] uppercase font-bold tracking-wider">Persetujuan Izin</span>
        </a>

        <a href="{{ route('admin.laporan.index') }}" 
           class="flex items-center px-4 py-3 rounded-sm transition-all group {{ request()->routeIs('admin.laporan.*') ? 'bg-primary text-secondary font-bold' : 'text-gray-400 hover:bg-white/5 hover:text-primary' }}">
            <i class="fa-solid fa-chart-line w-5 mr-3 {{ request()->routeIs('admin.laporan.*') ? 'text-secondary' : 'text-gray-500 group-hover:text-primary' }}"></i>
            <span class="text-[11px] uppercase font-bold tracking-wider">Laporan Absensi</span>
        </a>

        <a href="{{ route('admin.kalender.index') }}" 
           class="flex items-center px-4 py-3 rounded-sm transition-all group {{ request()->routeIs('admin.kalender.*') ? 'bg-primary text-secondary font-bold' : 'text-gray-400 hover:bg-white/5 hover:text-primary' }}">
            <i class="fa-solid fa-calendar-days w-5 mr-3 {{ request()->routeIs('admin.kalender.*') ? 'text-secondary' : 'text-gray-500 group-hover:text-primary' }}"></i>
            <span class="text-[11px] uppercase font-bold tracking-wider">Kalender Kerja</span>
        </a>

        <div class="text-[10px] font-black text-gray-600 uppercase tracking-[0.2em] px-4 pt-6 pb-2">System Settings</div>

        <a href="{{ route('admin.lokasi.index') }}" 
           class="flex items-center px-4 py-3 rounded-sm transition-all group {{ request()->routeIs('admin.lokasi.*') ? 'bg-primary text-secondary font-bold' : 'text-gray-400 hover:bg-white/5 hover:text-primary' }}">
            <i class="fa-solid fa-map-location-dot w-5 mr-3 {{ request()->routeIs('admin.lokasi.*') ? 'text-secondary' : 'text-gray-500 group-hover:text-primary' }}"></i>
            <span class="text-[11px] uppercase font-bold tracking-wider">Lokasi Kantor</span>
        </a>

        <a href="{{ route('admin.jam-kerja.index') }}" 
           class="flex items-center px-4 py-3 rounded-sm transition-all group {{ request()->routeIs('admin.jam-kerja.*') ? 'bg-primary text-secondary font-bold' : 'text-gray-400 hover:bg-white/5 hover:text-primary' }}">
            <i class="fa-solid fa-clock-rotate-left w-5 mr-3 {{ request()->routeIs('admin.jam-kerja.*') ? 'text-secondary' : 'text-gray-500 group-hover:text-primary' }}"></i>
            <span class="text-[11px] uppercase font-bold tracking-wider">Atur Jam Kerja</span>
        </a>
    </nav>

    <div class="p-4 border-t border-white/5 bg-black/10">
        <button onclick="confirmLogout()" class="w-full flex items-center px-4 py-3 rounded-sm bg-red-500/10 text-red-500 hover:bg-red-600 hover:text-white transition-all text-[11px] font-black uppercase tracking-widest">
            <i class="fa-solid fa-right-from-bracket mr-3"></i> Keluar System
        </button>
    </div>
</aside>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
    @csrf
</form>

<script>
    function confirmLogout() {
        Swal.fire({
            title: 'KONFIRMASI LOGOUT',
            text: "Apakah Anda yakin ingin keluar dari sistem?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444', 
            cancelButtonColor: '#1F2937',  
            confirmButtonText: 'YA, KELUAR',
            cancelButtonText: 'BATAL',
            customClass: {
                popup: 'rounded-3xl', 
                confirmButton: 'rounded-xl px-6 py-3 font-bold uppercase tracking-widest',
                cancelButton: 'rounded-xl px-6 py-3 font-bold uppercase tracking-widest'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }
</script>