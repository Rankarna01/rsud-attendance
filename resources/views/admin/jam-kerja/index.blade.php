@extends('layouts.admin')

@section('content')
<div class="space-y-6 animate-fadeIn">
    
    <div class="border-b border-gray-100 pb-6">
        <h2 class="text-3xl font-black text-secondary uppercase tracking-tighter">Atur <span class="text-primary">Jam Kerja</span></h2>
        <p class="text-sm text-gray-500 font-medium mt-1">Tentukan standarisasi waktu operasional kehadiran pegawai.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-0 border border-gray-100 rounded-[2rem] overflow-hidden bg-white shadow-sm">
        
        <div class="lg:col-span-5 p-10 border-r border-gray-100 bg-white">
            <form action="{{ route('admin.jam-kerja.update') }}" method="POST" class="space-y-8">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label class="block text-[11px] font-black text-gray-400 uppercase mb-2 tracking-[0.2em] ml-1">Jam Masuk Kantor</label>
                        <input type="time" name="jam_masuk" 
                            value="{{ $jam->jam_masuk ? \Carbon\Carbon::parse($jam->jam_masuk)->format('H:i') : '08:00' }}" 
                            class="w-full px-5 py-4 bg-gray-50 border border-transparent focus:border-primary focus:bg-white rounded-2xl outline-none text-sm font-black text-secondary transition-all shadow-sm">
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-gray-400 uppercase mb-2 tracking-[0.2em] ml-1">Jam Pulang Kantor</label>
                        <input type="time" name="jam_pulang" 
                            value="{{ $jam->jam_pulang ? \Carbon\Carbon::parse($jam->jam_pulang)->format('H:i') : '17:00' }}" 
                            class="w-full px-5 py-4 bg-gray-50 border border-transparent focus:border-primary focus:bg-white rounded-2xl outline-none text-sm font-black text-secondary transition-all shadow-sm">
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-gray-400 uppercase mb-2 tracking-[0.2em] ml-1">Toleransi Telat (Menit)</label>
                        <div class="flex items-center bg-gray-50 border border-transparent focus-within:border-primary focus-within:bg-white rounded-2xl transition-all shadow-sm overflow-hidden">
                            <input type="number" name="toleransi" value="{{ $jam->toleransi ?? 15 }}" min="0"
                                class="flex-1 bg-transparent px-5 py-4 outline-none text-sm font-black text-secondary">
                            <span class="pr-5 text-[10px] font-black text-primary uppercase tracking-widest bg-gray-50/50 py-4">Menit</span>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-50">
                    <button type="submit" 
                        class="w-full bg-secondary text-primary font-black py-4 rounded-xl text-xs uppercase tracking-[0.2em] hover:bg-black hover:text-primary transition-all shadow-lg shadow-secondary/20">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <div class="lg:col-span-7 p-12 bg-gray-50 flex flex-col items-center justify-center relative overflow-hidden">
            <div class="z-10 text-center space-y-8 w-full max-w-lg">
                <div class="p-10 bg-white border border-gray-100 shadow-xl rounded-[2.5rem]">
                    <div class="grid grid-cols-2 gap-8 divide-x divide-gray-100">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-yellow-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <i class="fa-solid fa-sun text-3xl text-yellow-500"></i>
                            </div>
                            <span class="text-4xl font-black text-secondary tabular-nums tracking-tighter">
                                {{ $jam->jam_masuk ? \Carbon\Carbon::parse($jam->jam_masuk)->format('H:i') : '--:--' }}
                            </span>
                            <p class="text-[10px] font-bold text-gray-400 uppercase mt-2 tracking-widest">Waktu Check In</p>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 bg-indigo-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <i class="fa-solid fa-moon text-3xl text-indigo-900"></i>
                            </div>
                            <span class="text-4xl font-black text-secondary tabular-nums tracking-tighter">
                                {{ $jam->jam_pulang ? \Carbon\Carbon::parse($jam->jam_pulang)->format('H:i') : '--:--' }}
                            </span>
                            <p class="text-[10px] font-bold text-gray-400 uppercase mt-2 tracking-widest">Waktu Check Out</p>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-center space-x-4 bg-white/60 p-4 rounded-2xl border border-gray-200 backdrop-blur-sm">
                    <i class="fa-solid fa-clock-rotate-left text-primary text-xl animate-spin-slow"></i>
                    <p class="text-xs font-bold text-gray-500 text-left leading-relaxed">
                        Sistem otomatis menandai <span class="text-red-500 uppercase tracking-widest">terlambat</span> jika absen melewati <br><span class="text-secondary font-black">{{ $jam->toleransi ?? 15 }} Menit</span> dari jam masuk.
                    </p>
                </div>
            </div>

            <div class="absolute -right-20 -bottom-20 opacity-[0.03] pointer-events-none">
                <i class="fa-solid fa-clock text-[40rem]"></i>
            </div>
        </div>
    </div>
</div>

<style>
    .animate-spin-slow { animation: spin 8s linear infinite; }
    @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
</style>

@push('scripts')
<script>
    @if(session('success'))
        Swal.fire({ 
            icon: 'success', 
            title: 'BERHASIL DISIMPAN', 
            text: "{{ session('success') }}", 
            confirmButtonColor: '#1F2937',
            customClass: { 
                popup: 'rounded-[2rem]',
                confirmButton: 'rounded-xl px-8 py-3 font-bold uppercase tracking-widest'
            }
        });
    @endif
</script>
@endpush
@endsection