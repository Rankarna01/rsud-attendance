@extends('layouts.mobile')

@section('content')
<div class="space-y-6 animate-fadeIn">
    
    <div class="flex justify-between items-end mb-6">
        <div>
            <h2 class="text-2xl font-black text-secondary uppercase tracking-tighter">Riwayat <span class="text-primary">Absen</span></h2>
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Audit Trail & Log</p>
        </div>
        
        <form action="{{ route('pegawai.riwayat.index') }}" method="GET" class="relative">
            <input type="month" name="bulan" value="{{ $bulanTerpilih }}" onchange="this.form.submit()"
                class="bg-white border border-gray-100 shadow-sm text-secondary text-xs font-bold px-4 py-2 rounded-xl outline-none focus:border-primary transition-all uppercase appearance-none">
        </form>
    </div>

    <div class="space-y-4">
        @forelse($riwayat as $data)
        <div class="bg-white p-5 rounded-[2rem] border border-gray-100 shadow-sm relative overflow-hidden group">
            
            <div class="flex justify-between items-center mb-4 border-b border-gray-50 pb-3">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center text-secondary font-black shadow-inner">
                        {{ \Carbon\Carbon::parse($data->tanggal)->format('d') }}
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-secondary uppercase tracking-widest">{{ \Carbon\Carbon::parse($data->tanggal)->translatedFormat('l') }}</p>
                        <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">{{ \Carbon\Carbon::parse($data->tanggal)->translatedFormat('M Y') }}</p>
                    </div>
                </div>
                
                @if($data->status == 'hadir')
                    @if($data->is_late)
                        <span class="bg-red-50 text-red-500 border border-red-100 px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest flex items-center">
                            <i class="fa-solid fa-triangle-exclamation mr-1"></i> Terlambat
                        </span>
                    @else
                        <span class="bg-green-50 text-green-600 border border-green-100 px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest flex items-center">
                            <i class="fa-solid fa-check mr-1"></i> Tepat Waktu
                        </span>
                    @endif
                @else
                    <span class="bg-primary/20 text-secondary border border-primary/30 px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest">
                        {{ $data->status }}
                    </span>
                @endif
            </div>

            <div class="grid grid-cols-2 gap-4">
                
                <div class="bg-gray-50/50 p-3 rounded-2xl border border-gray-100/50">
                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest block mb-2">Tap In (Masuk)</span>
                    <div class="flex items-center space-x-3">
                        @if($data->foto_masuk)
                            <img src="{{ asset('storage/' . $data->foto_masuk) }}" onclick="previewImage(this.src)"
                                class="w-12 h-12 rounded-xl object-cover shadow-sm border-2 border-white cursor-pointer active:scale-95 transition-transform">
                        @else
                            <div class="w-12 h-12 rounded-xl bg-gray-200 flex items-center justify-center text-gray-400 border-2 border-white">
                                <i class="fa-solid fa-image-polaroid"></i>
                            </div>
                        @endif
                        <div>
                            <p class="text-sm font-black text-secondary tabular-nums tracking-tighter">{{ $data->jam_masuk ?? '--:--' }}</p>
                            @if($data->lokasi_masuk)
                                <a href="https://maps.google.com/?q={{ $data->lokasi_masuk }}" target="_blank" class="text-[8px] font-bold text-blue-500 uppercase flex items-center mt-0.5">
                                    <i class="fa-solid fa-location-dot mr-1"></i> Lihat Maps
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50/50 p-3 rounded-2xl border border-gray-100/50">
                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest block mb-2">Tap Out (Pulang)</span>
                    <div class="flex items-center space-x-3">
                        @if($data->foto_pulang)
                            <img src="{{ asset('storage/' . $data->foto_pulang) }}" onclick="previewImage(this.src)"
                                class="w-12 h-12 rounded-xl object-cover shadow-sm border-2 border-white cursor-pointer active:scale-95 transition-transform">
                        @else
                            <div class="w-12 h-12 rounded-xl bg-gray-200 flex items-center justify-center text-gray-400 border-2 border-white">
                                <i class="fa-solid fa-clock"></i>
                            </div>
                        @endif
                        <div>
                            <p class="text-sm font-black text-secondary tabular-nums tracking-tighter">{{ $data->jam_pulang ?? '--:--' }}</p>
                            @if($data->lokasi_pulang)
                                <a href="https://maps.google.com/?q={{ $data->lokasi_pulang }}" target="_blank" class="text-[8px] font-bold text-blue-500 uppercase flex items-center mt-0.5">
                                    <i class="fa-solid fa-location-dot mr-1"></i> Lihat Maps
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
        @empty
        <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm text-center">
            <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center text-gray-300 mx-auto mb-4">
                <i class="fa-solid fa-folder-open text-3xl"></i>
            </div>
            <h3 class="text-sm font-black text-secondary uppercase tracking-widest">Belum Ada Riwayat</h3>
            <p class="text-[10px] text-gray-400 mt-1 font-medium">Data absensi pada bulan {{ $namaBulan }} masih kosong.</p>
        </div>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
    // Fungsi untuk memperbesar foto saat di-klik
    function previewImage(url) {
        Swal.fire({
            imageUrl: url,
            imageAlt: 'Bukti Foto Absensi',
            showConfirmButton: false,
            showCloseButton: true,
            background: 'transparent',
            backdrop: 'rgba(31, 41, 55, 0.9)', // Warna secondary transparan
            customClass: {
                image: 'rounded-3xl shadow-2xl border-4 border-white',
                closeButton: 'text-white hover:text-primary transition-colors'
            }
        });
    }
</script>
@endpush
@endsection