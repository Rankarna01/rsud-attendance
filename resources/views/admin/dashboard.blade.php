@extends('layouts.admin')

@section('content')
<div class="space-y-6 animate-fadeIn">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-secondary tracking-tight uppercase">System <span class="text-primary">Overview</span></h1>
            <p class="text-gray-500 font-medium text-sm">
                Welcome back, <span class="text-secondary font-bold">{{ Auth::user()->nama_lengkap }}</span>. Monitoring system is active.
            </p>
        </div>
        <div class="flex items-center bg-white p-1 rounded-xl shadow-sm border border-gray-100">
            <div class="bg-primary/10 px-4 py-2 rounded-lg text-primary font-bold text-xs uppercase">
                <i class="fa-solid fa-calendar-day mr-2"></i> {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}
            </div>
            <div id="realtime-clock" class="px-6 py-2 text-secondary font-mono text-xl font-black tabular-nums">
                00:00:00
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-secondary rounded-xl flex items-center justify-center text-primary shadow-lg group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-users text-xl"></i>
                </div>
                <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest">Database</span>
            </div>
            <p class="text-gray-400 text-[10px] font-black uppercase tracking-widest">Total Personnel</p>
            <h3 class="text-secondary text-4xl font-black mt-1 tracking-tighter">{{ $totalPegawai }}</h3>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-green-100 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-user-check text-xl"></i>
                </div>
                <div class="text-right">
                    <span class="text-[10px] font-black text-green-500 uppercase tracking-widest">Live Now</span>
                </div>
            </div>
            <p class="text-gray-400 text-[10px] font-black uppercase tracking-widest">Present Today</p>
            <h3 class="text-secondary text-4xl font-black mt-1 tracking-tighter">{{ $hadir }}</h3>
            <div class="mt-4 w-full bg-gray-50 h-2 rounded-full overflow-hidden">
                <div class="bg-green-500 h-full rounded-full" style="width: {{ $totalPegawai > 0 ? ($hadir / $totalPegawai) * 100 : 0 }}%"></div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-red-100 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-user-xmark text-xl"></i>
                </div>
                <span class="text-[10px] font-black text-red-500 uppercase tracking-widest">Attention</span>
            </div>
            <p class="text-gray-400 text-[10px] font-black uppercase tracking-widest">Not Present</p>
            <h3 class="text-secondary text-4xl font-black mt-1 tracking-tighter">{{ $belumHadir }}</h3>
            <div class="mt-4 w-full bg-gray-50 h-2 rounded-full overflow-hidden">
                <div class="bg-red-500 h-full rounded-full" style="width: {{ $totalPegawai > 0 ? ($belumHadir / $totalPegawai) * 100 : 0 }}%"></div>
            </div>
        </div>

        <div class="bg-primary p-6 rounded-2xl shadow-lg shadow-primary/20 hover:-translate-y-1 transition-all group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-secondary rounded-xl flex items-center justify-center text-primary shadow-lg">
                    <i class="fa-solid fa-envelope-open-text text-xl"></i>
                </div>
                <span class="text-[10px] font-black text-secondary/50 uppercase tracking-widest">Action</span>
            </div>
            <p class="text-secondary/60 text-[10px] font-black uppercase tracking-widest">Permit Requests</p>
            <h3 class="text-secondary text-4xl font-black mt-1 tracking-tighter">{{ $izinSakit }}</h3>
            <p class="text-secondary text-[9px] font-black uppercase mt-4 tracking-widest flex items-center cursor-pointer">
                Review Now <i class="fa-solid fa-arrow-right ml-2 group-hover:translate-x-2 transition-transform"></i>
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-lg font-black text-secondary uppercase tracking-tight">Presence Analytics</h3>
                    <p class="text-gray-400 text-xs font-medium italic">Data tren kehadiran 7 hari terakhir</p>
                </div>
                <div class="p-1 bg-gray-50 rounded-lg flex space-x-1">
                    <button class="px-4 py-1.5 bg-white shadow-sm rounded-md text-[10px] font-black text-secondary uppercase">Weekly</button>
                    <button class="px-4 py-1.5 text-[10px] font-black text-gray-400 uppercase hover:text-secondary">Monthly</button>
                </div>
            </div>
            <div class="h-[350px]">
                <canvas id="mainPresenceChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm flex flex-col">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-lg font-black text-secondary uppercase tracking-tight">System Logs</h3>
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
            </div>
            
            <div class="flex-1 space-y-6 overflow-y-auto pr-2 custom-scrollbar">
                @forelse($aktivitas as $act)
                <div class="flex items-start space-x-4 group">
                    <div class="flex flex-col items-center">
                        <div class="w-2 h-2 rounded-full bg-primary mb-1"></div>
                        <div class="w-[1px] h-12 bg-gray-100 group-last:hidden"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[11px] font-black text-secondary uppercase tracking-tighter leading-none">{{ $act->judul }}</p>
                        <p class="text-[10px] text-gray-400 mt-1 truncate">{{ $act->deskripsi }}</p>
                        <span class="text-[9px] font-bold text-primary uppercase mt-1 block">{{ $act->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                @empty
                <div class="text-center py-20 opacity-40 italic text-xs font-bold text-gray-400">No activity recorded.</div>
                @endforelse
            </div>
            
            <button class="w-full mt-6 py-4 bg-secondary text-primary rounded-xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-black transition-all">
                View All Logs
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function updateTime() {
        const now = new Date();
        document.getElementById('realtime-clock').innerText = now.toLocaleTimeString('id-ID', { hour12: false });
    }
    setInterval(updateTime, 1000); updateTime();

    const ctx = document.getElementById('mainPresenceChart').getContext('2d');
    
    // Create Gradient
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(244, 196, 48, 0.3)');
    gradient.addColorStop(1, 'rgba(255, 255, 255, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartData['labels']),
            datasets: [{
                label: 'Presence %',
                data: @json($chartData['data']),
                borderColor: '#F4C430',
                borderWidth: 5,
                backgroundColor: gradient,
                fill: true,
                tension: 0.4, // Smooth curve
                pointBackgroundColor: '#FFF',
                pointBorderColor: '#F4C430',
                pointBorderWidth: 3,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    grid: { color: '#F9FAFB', borderDash: [5, 5] },
                    ticks: { font: { weight: 'bold', size: 10 }, color: '#9CA3AF' }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { weight: 'bold', size: 10 }, color: '#9CA3AF' }
                }
            }
        }
    });
</script>
@endpush

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #E5E7EB; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #F4C430; }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn { animation: fadeIn 0.5s ease-out forwards; }
</style>
@endsection