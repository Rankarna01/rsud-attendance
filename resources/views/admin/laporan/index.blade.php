@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-100 pb-6">
        <div>
            <h2 class="text-2xl font-black text-secondary uppercase tracking-tighter">Analytics <span class="text-primary">Laporan</span></h2>
            <p class="text-sm text-gray-500 font-medium italic">Data Periode: {{ \Carbon\Carbon::parse($bulan)->translatedFormat('F Y') }}</p>
        </div>
        
        <form action="{{ route('admin.laporan.index') }}" method="GET" class="flex items-center space-x-2">
            <select name="user_id" class="text-xs font-bold border-gray-200 focus:border-primary uppercase px-4 py-2">
                <option value="">Semua Pegawai</option>
                @foreach($pegawai as $p)
                    <option value="{{ $p->id }}" {{ request('user_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_lengkap }}</option>
                @endforeach
            </select>
            <input type="month" name="bulan" value="{{ $bulan }}" class="text-xs font-bold border-gray-200 focus:border-primary px-4 py-2">
            <button type="submit" class="bg-secondary text-primary px-6 py-2 text-[10px] font-black uppercase tracking-widest hover:bg-black transition-all shadow-lg">
                <i class="fa-solid fa-magnifying-glass mr-1"></i> Filter
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white border border-gray-200 p-8 shadow-sm">
             <h3 class="text-[10px] font-black text-secondary uppercase tracking-[0.2em] mb-8">Summary Performance</h3>
             <canvas id="attendanceChart"></canvas>
        </div>

        <div class="lg:col-span-2 grid grid-cols-2 md:grid-cols-3 gap-4">
            <div class="bg-white border-b-4 border-primary p-6 shadow-sm">
                <span class="text-[10px] font-bold text-gray-400 uppercase block mb-1">Hadir Tepat Waktu</span>
                <span class="text-3xl font-black text-secondary">{{ $stats['hadir'] - $stats['telat'] }}</span>
            </div>
            <div class="bg-white border-b-4 border-red-500 p-6 shadow-sm">
                <span class="text-[10px] font-bold text-gray-400 uppercase block mb-1">Total Terlambat</span>
                <span class="text-3xl font-black text-red-500">{{ $stats['telat'] }}</span>
            </div>
            <div class="bg-white border-b-4 border-blue-500 p-6 shadow-sm">
                <span class="text-[10px] font-bold text-gray-400 uppercase block mb-1">Izin & Sakit</span>
                <span class="text-3xl font-black text-blue-500">{{ $stats['izin'] + $stats['sakit'] }}</span>
            </div>
        </div>
    </div>

    <div class="bg-white border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="text-[10px] font-black text-secondary uppercase tracking-[0.2em]">Live Table Preview</h3>
            <div class="flex space-x-2">
                <a href="{{ route('admin.laporan.pdf', ['bulan' => $bulan, 'user_id' => request('user_id')]) }}" 
                   class="bg-red-600 text-white px-5 py-2.5 text-[10px] font-black uppercase tracking-widest hover:bg-red-700 shadow-lg">
                    <i class="fa-solid fa-file-pdf mr-2"></i> Download PDF
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-white border-b border-gray-200 text-secondary uppercase text-[10px] font-black tracking-widest">
                    <tr>
                        <th class="px-6 py-5">Pegawai</th>
                        <th class="px-6 py-5 text-center">Hadir</th>
                        <th class="px-6 py-5 text-center text-red-500">Telat</th>
                        <th class="px-6 py-5 text-center text-blue-500">Izin</th>
                        <th class="px-6 py-5 text-center text-orange-500">Sakit</th>
                        <th class="px-6 py-5 text-center">Cuti</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 italic font-medium text-gray-600">
                    @forelse($rekap as $r)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="text-secondary font-bold not-italic block uppercase text-xs">{{ $r['nama'] }}</span>
                            <span class="text-[9px] text-gray-400 font-mono">{{ $r['nip'] }}</span>
                        </td>
                        <td class="px-6 py-4 text-center font-bold text-secondary">{{ $r['hadir'] }}</td>
                        <td class="px-6 py-4 text-center font-bold text-red-500">{{ $r['telat'] }}</td>
                        <td class="px-6 py-4 text-center">{{ $r['izin'] }}</td>
                        <td class="px-6 py-4 text-center">{{ $r['sakit'] }}</td>
                        <td class="px-6 py-4 text-center">{{ $r['cuti'] }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-400 uppercase text-[10px] font-bold tracking-widest">Tidak ada data untuk periode ini</td>
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
                backgroundColor: ['#F4C430', '#1F2937', '#3B82F6', '#F97316', '#A855F7'],
                borderWidth: 0
            }]
        },
        options: {
            plugins: { legend: { position: 'bottom', labels: { font: { size: 9, weight: 'bold' }, boxWidth: 10 } } },
            cutout: '75%'
        }
    });
</script>
@endsection