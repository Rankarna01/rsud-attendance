@extends('layouts.mobile')

@section('content')
<div class="space-y-6 animate-fadeIn pb-10">
    
    <div class="flex justify-between items-end mb-6">
        <div>
            <h2 class="text-2xl font-black text-secondary uppercase tracking-tighter">Pengajuan <span class="text-primary">Izin</span></h2>
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Sakit, Izin & Cuti</p>
        </div>
        
        <button onclick="openFormModal()" class="w-12 h-12 bg-secondary text-primary rounded-[1.2rem] shadow-xl shadow-secondary/20 flex items-center justify-center hover:-translate-y-1 transition-transform">
            <i class="fa-solid fa-plus text-xl"></i>
        </button>
    </div>

    <div class="space-y-4">
        @forelse($pengajuan as $data)
        <div class="bg-white p-5 rounded-[2rem] border border-gray-100 shadow-sm relative overflow-hidden group">
            <div class="absolute left-0 top-0 bottom-0 w-1.5 
                @if($data->jenis == 'sakit') bg-orange-500 
                @elseif($data->jenis == 'izin') bg-blue-500 
                @else bg-purple-500 @endif">
            </div>

            <div class="flex justify-between items-start mb-4 pl-3">
                <div>
                    <span class="text-[9px] font-black text-white uppercase tracking-widest px-2.5 py-1 rounded-md mb-2 inline-block
                        @if($data->jenis == 'sakit') bg-orange-500 
                        @elseif($data->jenis == 'izin') bg-blue-500 
                        @else bg-purple-500 @endif">
                        {{ $data->jenis }}
                    </span>
                    <h4 class="text-sm font-black text-secondary uppercase tracking-tighter">
                        {{ \Carbon\Carbon::parse($data->tanggal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($data->tanggal_selesai)->format('d M Y') }}
                    </h4>
                </div>
                
                @if($data->status == 'disetujui')
                    <span class="bg-green-50 text-green-600 border border-green-100 px-3 py-1 rounded-xl text-[9px] font-black uppercase tracking-widest flex items-center">
                        <i class="fa-solid fa-check-double mr-1"></i> Disetujui
                    </span>
                @elseif($data->status == 'ditolak')
                    <span class="bg-red-50 text-red-500 border border-red-100 px-3 py-1 rounded-xl text-[9px] font-black uppercase tracking-widest flex items-center">
                        <i class="fa-solid fa-xmark mr-1"></i> Ditolak
                    </span>
                @else
                    <span class="bg-primary/20 text-secondary border border-primary/30 px-3 py-1 rounded-xl text-[9px] font-black uppercase tracking-widest flex items-center animate-pulse">
                        <i class="fa-solid fa-clock mr-1"></i> Menunggu
                    </span>
                @endif
            </div>

            <div class="pl-3 bg-gray-50/50 p-3 rounded-2xl border border-gray-50 text-xs text-gray-500 font-medium">
                {{ $data->alasan }}
            </div>

            @if($data->lampiran)
            <div class="mt-3 pl-3">
                <a href="{{ asset('storage/' . $data->lampiran) }}" target="_blank" class="inline-flex items-center text-[9px] font-black text-blue-500 uppercase tracking-widest bg-blue-50 px-3 py-1.5 rounded-lg border border-blue-100">
                    <i class="fa-solid fa-paperclip mr-2"></i> Lihat Lampiran
                </a>
            </div>
            @endif
        </div>
        @empty
        <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm text-center">
            <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center text-gray-300 mx-auto mb-4">
                <i class="fa-solid fa-file-circle-check text-3xl"></i>
            </div>
            <h3 class="text-sm font-black text-secondary uppercase tracking-widest">Belum Ada Pengajuan</h3>
            <p class="text-[10px] text-gray-400 mt-1 font-medium">Anda belum pernah mengajukan Izin/Sakit/Cuti.</p>
        </div>
        @endforelse
    </div>

</div>

<div id="formModal" class="fixed inset-0 z-[60] hidden transition-all flex flex-col justify-end">
    <div class="absolute inset-0 bg-secondary/60 backdrop-blur-sm z-0" onclick="closeFormModal()"></div>
    
    <div class="relative z-10 bg-white w-full max-h-[90vh] rounded-t-[2.5rem] shadow-2xl overflow-y-auto transform translate-y-full transition-transform duration-300 ease-out" id="modalContent">
        
        <div class="flex justify-center pt-4 pb-2 sticky top-0 bg-white z-20 rounded-t-[2.5rem]">
            <div class="w-12 h-1.5 bg-gray-200 rounded-full"></div>
        </div>

        <div class="px-6 py-4 flex justify-between items-center border-b border-gray-100 sticky top-6 bg-white z-20">
            <h3 class="text-lg font-black text-secondary uppercase tracking-tighter">Form <span class="text-primary">Pengajuan</span></h3>
            <button onclick="closeFormModal()" type="button" class="w-8 h-8 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center hover:bg-gray-100">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="izinForm" action="{{ route('pegawai.izin.store') }}" method="POST" enctype="multipart/form-data" class="p-6 pb-12 space-y-5">
            @csrf
            
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1">Jenis Pengajuan</label>
                <div class="relative">
                    <select name="jenis" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all text-sm font-bold text-secondary appearance-none" required>
                        <option value="izin">Izin (Keperluan Pribadi)</option>
                        <option value="sakit">Sakit (Butuh Surat Dokter)</option>
                        <option value="cuti">Cuti Tahunan</option>
                    </select>
                    <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1">Mulai Tanggal</label>
                    <input type="date" name="tanggal_mulai" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all text-sm font-bold text-secondary" required>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1">Sampai Tanggal</label>
                    <input type="date" name="tanggal_selesai" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all text-sm font-bold text-secondary" required>
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1">Alasan Lengkap</label>
                <textarea name="alasan" rows="3" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all text-sm font-bold text-secondary" placeholder="Jelaskan alasan pengajuan secara singkat..." required></textarea>
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1">Lampiran / Bukti (Opsional)</label>
                <div class="relative w-full h-14 bg-gray-50 border-2 border-dashed border-gray-200 rounded-2xl flex items-center justify-center text-gray-400 overflow-hidden group hover:border-primary transition-colors cursor-pointer">
                    <input type="file" name="lampiran" accept="image/*,.pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="updateFileName(this)">
                    <div id="file-text" class="text-[10px] font-bold uppercase tracking-widest pointer-events-none group-hover:text-primary transition-colors">
                        <i class="fa-solid fa-cloud-arrow-up mr-2 text-sm"></i> Pilih File Foto/PDF
                    </div>
                </div>
                <p class="text-[9px] text-gray-400 mt-2 ml-1 italic font-medium">*Wajib dilampirkan jika mengajukan SAKIT.</p>
            </div>

            <button type="submit" id="btnSubmit" class="w-full bg-primary text-secondary font-black text-sm py-5 rounded-2xl shadow-xl shadow-primary/20 hover:bg-black hover:text-primary transition-all uppercase tracking-[0.2em] mt-4 flex items-center justify-center">
                <span>Kirim Pengajuan</span> <i class="fa-solid fa-paper-plane ml-2"></i>
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const modal = document.getElementById('formModal');
    const modalContent = document.getElementById('modalContent');

    function openFormModal() {
        modal.classList.remove('hidden');
        setTimeout(() => {
            modalContent.classList.remove('translate-y-full');
            modalContent.classList.add('translate-y-0');
        }, 10);
    }

    function closeFormModal() {
        modalContent.classList.remove('translate-y-0');
        modalContent.classList.add('translate-y-full');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function updateFileName(input) {
        const textElement = document.getElementById('file-text');
        if (input.files && input.files[0]) {
            textElement.innerHTML = `<i class="fa-solid fa-file-circle-check mr-2 text-green-500"></i> <span class="text-secondary truncate px-4">${input.files[0].name}</span>`;
            textElement.parentElement.classList.replace('border-gray-200', 'border-primary');
        } else {
            textElement.innerHTML = `<i class="fa-solid fa-cloud-arrow-up mr-2 text-sm"></i> Pilih File Foto/PDF`;
            textElement.parentElement.classList.replace('border-primary', 'border-gray-200');
        }
    }

    // PERBAIKAN: Menambahkan Loading State saat Form disubmit
    document.getElementById('izinForm').addEventListener('submit', function(e) {
        // Jika form lolos validasi HTML5 (required), tampilkan animasi loading
        const btn = document.getElementById('btnSubmit');
        btn.innerHTML = `<i class="fa-solid fa-spinner fa-spin mr-2"></i> MEMPROSES...`;
        btn.classList.add('opacity-75', 'cursor-not-allowed');

        Swal.fire({
            title: 'Mengirim Pengajuan...',
            text: 'Mohon tunggu sebentar, data sedang diunggah.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    });
</script>
@endpush
@endsection