@extends('layouts.admin')

@section('content')
<div class="space-y-6 animate-fadeIn pb-10">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-100 pb-6">
        <div>
            <h2 class="text-3xl font-black text-secondary uppercase tracking-tighter">Analytics <span class="text-primary">Laporan</span></h2>
            <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mt-1">
                Data Periode: <span class="text-secondary">{{ \Carbon\Carbon::parse($bulan)->translatedFormat('F Y') }}</span>
            </p>
        </div>
        
        <form action="{{ route('admin.laporan.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
            <div class="relative">
                <select name="user_id" class="appearance-none text-xs font-bold bg-white border border-gray-100 shadow-sm rounded-xl focus:border-primary focus:ring-1 focus:ring-primary uppercase px-4 py-3 pr-8 outline-none transition-all cursor-pointer text-secondary">
                    <option value="">Semua Pegawai</option>
                    @foreach($pegawai as $p)
                        <option value="{{ $p->id }}" {{ request('user_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_lengkap }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-gray-400">
                    <i class="fa-solid fa-chevron-down text-[10px]"></i>
                </div>
            </div>

            <input type="month" name="bulan" value="{{ $bulan }}" class="text-xs font-bold bg-white border border-gray-100 shadow-sm rounded-xl focus:border-primary focus:ring-1 focus:ring-primary px-4 py-3 outline-none transition-all text-secondary uppercase tracking-widest">
            
            <button type="submit" class="bg-secondary text-primary px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-black transition-all shadow-lg shadow-secondary/20 flex items-center">
                <i class="fa-solid fa-magnifying-glass mr-2"></i> Filter
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="bg-white border border-gray-100 p-6 rounded-[2rem] shadow-sm flex flex-col justify-between">
             <div class="flex items-center justify-between mb-4">
                 <h3 class="text-[10px] font-black text-secondary uppercase tracking-[0.2em]">Summary Performance</h3>
                 <i class="fa-solid fa-chart-pie text-gray-200 text-lg"></i>
             </div>
             
             <div class="relative h-52 w-full flex items-center justify-center">
                 <canvas id="attendanceChart"></canvas>
             </div>
        </div>

        <div class="lg:col-span-2 grid grid-cols-2 md:grid-cols-3 gap-4">
            <div class="bg-white border border-gray-100 p-6 rounded-[2rem] shadow-sm relative overflow-hidden group hover:border-green-500/30 transition-colors">
                <div class="absolute -right-4 -bottom-4 bg-green-50 w-24 h-24 rounded-full flex items-center justify-center opacity-50 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-check-double text-green-500 text-4xl"></i>
                </div>
                <div class="relative z-10">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">Hadir Tepat Waktu</span>
                    <span class="text-4xl font-black text-secondary tabular-nums tracking-tighter">{{ $stats['hadir'] - $stats['telat'] }}</span>
                </div>
            </div>
            
            <div class="bg-white border border-gray-100 p-6 rounded-[2rem] shadow-sm relative overflow-hidden group hover:border-red-500/30 transition-colors">
                <div class="absolute -right-4 -bottom-4 bg-red-50 w-24 h-24 rounded-full flex items-center justify-center opacity-50 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-triangle-exclamation text-red-500 text-4xl"></i>
                </div>
                <div class="relative z-10">
                    <span class="text-[10px] font-black text-red-400 uppercase tracking-widest block mb-1">Total Terlambat</span>
                    <span class="text-4xl font-black text-red-500 tabular-nums tracking-tighter">{{ $stats['telat'] }}</span>
                </div>
            </div>
            
            <div class="bg-white border border-gray-100 p-6 rounded-[2rem] shadow-sm relative overflow-hidden group col-span-2 md:col-span-1 hover:border-blue-500/30 transition-colors">
                <div class="absolute -right-4 -bottom-4 bg-blue-50 w-24 h-24 rounded-full flex items-center justify-center opacity-50 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-file-medical text-blue-500 text-4xl"></i>
                </div>
                <div class="relative z-10">
                    <span class="text-[10px] font-black text-blue-400 uppercase tracking-widest block mb-1">Izin & Sakit</span>
                    <span class="text-4xl font-black text-blue-500 tabular-nums tracking-tighter">{{ $stats['izin'] + $stats['sakit'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white border border-gray-100 shadow-sm rounded-[2rem] overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex flex-col sm:flex-row justify-between items-center gap-4 bg-white">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-primary/20 rounded-xl flex items-center justify-center text-secondary">
                    <i class="fa-solid fa-table-list text-lg"></i>
                </div>
                <h3 class="text-xs font-black text-secondary uppercase tracking-[0.2em]">Rekapitulasi Tabel</h3>
            </div>
            
            <div>
                <a href="{{ route('admin.laporan.pdf', ['bulan' => $bulan, 'user_id' => request('user_id')]) }}" target="_blank"
                   class="bg-red-50 text-red-600 border border-red-100 px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-red-600 hover:text-white transition-all shadow-sm flex items-center">
                    <i class="fa-solid fa-file-pdf mr-2 text-sm"></i> Download PDF Laporan
                </a>
            </div>
        </div>
        
        <div class="overflow-x-auto p-2">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50/50 text-secondary uppercase text-[10px] font-black tracking-[0.1em]">
                    <tr>
                        <th class="px-6 py-5 rounded-tl-xl">Pegawai</th>
                        <th class="px-6 py-5 text-center">Hadir</th>
                        <th class="px-6 py-5 text-center text-red-500">Telat</th>
                        <th class="px-6 py-5 text-center text-blue-500">Izin</th>
                        <th class="px-6 py-5 text-center text-orange-500">Sakit</th>
                        <th class="px-6 py-5 text-center rounded-tr-xl">Cuti</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($rekap as $r)
                    <tr class="hover:bg-gray-50/80 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($r['nama']) }}&background=F4C430&color=1F2937&bold=true" 
                                     class="w-10 h-10 rounded-xl shadow-sm" alt="">
                                <div>
                                    <span class="text-secondary font-black block uppercase text-xs tracking-tight">{{ $r['nama'] }}</span>
                                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">{{ $r['nip'] }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center font-black text-secondary text-lg">{{ $r['hadir'] }}</td>
                        <td class="px-6 py-4 text-center font-black {{ $r['telat'] > 0 ? 'text-red-500' : 'text-gray-300' }} text-lg">{{ $r['telat'] }}</td>
                        <td class="px-6 py-4 text-center font-bold text-gray-500">{{ $r['izin'] }}</td>
                        <td class="px-6 py-4 text-center font-bold text-gray-500">{{ $r['sakit'] }}</td>
                        <td class="px-6 py-4 text-center font-bold text-gray-500">{{ $r['cuti'] }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center opacity-30">
                                <i class="fa-solid fa-folder-open text-5xl mb-4"></i>
                                <p class="font-bold uppercase tracking-[0.2em]">Tidak ada data untuk periode ini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('attendanceChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Hadir', 'Telat', 'Izin', 'Sakit', 'Cuti'],
            datasets: [{
                data: [{{ $stats['hadir'] }}, {{ $stats['telat'] }}, {{ $stats['izin'] }}, {{ $stats['sakit'] }}, {{ $stats['cuti'] }}],
                backgroundColor: ['#F4C430', '#EF4444', '#3B82F6', '#F97316', '#A855F7'],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // INI KUNCI AGAR CHART TIDAK RAKSASA
            plugins: { 
                legend: { 
                    position: 'right', 
                    labels: { 
                        font: { size: 10, family: "'Inter', sans-serif", weight: 'bold' },
                        color: '#6B7280',
                        usePointStyle: true,
                        boxWidth: 8
                    } 
                } 
            },
            cutout: '70%',
            layout: { padding: 10 }
        }
    });
</script>
@endsection