@extends('layouts.admin')

@section('content')
<div class="space-y-6 animate-fadeIn">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-100 pb-6">
        <div>
            <h2 class="text-2xl font-black text-secondary uppercase tracking-tighter">Track Record <span class="text-primary">Kehadiran</span></h2>
            <p class="text-sm text-gray-500 font-medium">Visualisasi absensi bulanan periode <span class="text-secondary font-bold">{{ $namaBulan }}</span></p>
        </div>
        
        <form action="" method="GET" class="flex items-center space-x-2">
            <input type="month" name="bulan" value="{{ $bulanTerpilih }}" 
                class="text-xs font-bold border-gray-200 focus:border-primary px-4 py-2 uppercase outline-none shadow-sm">
            <button type="submit" class="bg-secondary text-primary px-6 py-2 text-[10px] font-black uppercase tracking-widest hover:bg-black transition-all shadow-lg">
                Tampilkan
            </button>
        </form>
    </div>

    <div class="flex flex-wrap gap-4 bg-white p-4 border border-gray-100 shadow-sm">
        <div class="flex items-center text-[10px] font-bold uppercase tracking-widest"><div class="w-3 h-3 bg-primary mr-2"></div> Hadir</div>
        <div class="flex items-center text-[10px] font-bold uppercase tracking-widest"><div class="w-3 h-3 bg-secondary mr-2"></div> Telat</div>
        <div class="flex items-center text-[10px] font-bold uppercase tracking-widest"><div class="w-3 h-3 bg-blue-500 mr-2"></div> Izin</div>
        <div class="flex items-center text-[10px] font-bold uppercase tracking-widest"><div class="w-3 h-3 bg-orange-500 mr-2"></div> Sakit</div>
        <div class="flex items-center text-[10px] font-bold uppercase tracking-widest"><div class="w-3 h-3 bg-red-600 mr-2"></div> Alfa</div>
    </div>

    <div class="bg-white border border-gray-200 shadow-2xl shadow-gray-200 rounded-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="sticky left-0 z-20 bg-gray-50 px-6 py-5 text-[10px] font-black text-secondary uppercase tracking-[0.2em] border-r border-gray-200 min-w-[220px]">
                            Nama Pegawai
                        </th>
                        @for($i = 1; $i <= $jumlahHari; $i++)
                        <th class="px-2 py-5 text-center text-[10px] font-black text-gray-400 border-r border-gray-100 min-w-[38px]">
                            {{ sprintf('%02d', $i) }}
                        </th>
                        @endfor
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($matrix as $m)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="sticky left-0 z-10 bg-white px-6 py-4 border-r border-gray-200 shadow-[4px_0_10px_rgba(0,0,0,0.03)]">
                            <span class="text-[11px] font-black text-secondary uppercase tracking-tighter block leading-none">{{ $m['user']->nama_lengkap }}</span>
                            <span class="text-[9px] text-gray-400 font-mono mt-1 block">{{ $m['user']->nip }}</span>
                        </td>
                        
                        @foreach($m['days'] as $tgl => $status)
                        <td class="p-1 border-r border-gray-100">
                            <div class="w-full h-9 flex items-center justify-center transition-all cursor-help
                                @if($status == 'hadir') bg-primary/20 border-b-2 border-primary
                                @elseif($status == 'telat') bg-secondary text-primary
                                @elseif($status == 'izin') bg-blue-500/20 border-b-2 border-blue-500
                                @elseif($status == 'sakit') bg-orange-500/20 border-b-2 border-orange-500
                                @elseif($status == 'cuti') bg-purple-500/20 border-b-2 border-purple-500
                                @else bg-red-50 text-red-200
                                @endif"
                                title="Tanggal {{ $tgl }}: {{ strtoupper($status) }}">
                                
                                @if($status == 'hadir') <i class="fa-solid fa-check text-[10px] text-secondary"></i>
                                @elseif($status == 'telat') <i class="fa-solid fa-clock text-[10px]"></i>
                                @elseif($status == 'alfa') <i class="fa-solid fa-xmark text-[10px]"></i>
                                @else <span class="text-[9px] font-black uppercase text-secondary">{{ substr($status, 0, 1) }}</span>
                                @endif
                            </div>
                        </td>
                        @endforeach
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ $jumlahHari + 1 }}" class="px-6 py-20 text-center text-gray-400 text-xs font-bold uppercase tracking-widest">Data Tidak Ditemukan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-white px-6 py-4 border-t border-gray-100">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest italic">
                    Menampilkan {{ $pegawai->firstItem() }} - {{ $pegawai->lastItem() }} dari {{ $pegawai->total() }} Pegawai
                </p>
                <div class="attendance-pagination">
                    {{ $pegawai->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .overflow-x-auto::-webkit-scrollbar { height: 8px; }
    .overflow-x-auto::-webkit-scrollbar-track { background: #f8f8f8; }
    .overflow-x-auto::-webkit-scrollbar-thumb { background: #1F2937; border-radius: 0px; }
    .overflow-x-auto::-webkit-scrollbar-thumb:hover { background: #F4C430; }

    /* Custom Styling Pagination biar tetep matching tema kita */
    .attendance-pagination nav svg { width: 1.5rem; height: 1.5rem; }
    .attendance-pagination span[aria-current="page"] > span { background-color: #F4C430 !important; color: #1F2937 !important; border: none !important; font-weight: 900 !important; }
</style>
@endsection