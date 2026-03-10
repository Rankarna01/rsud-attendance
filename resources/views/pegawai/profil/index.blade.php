@extends('layouts.mobile')

@section('content')
<div class="space-y-6 animate-fadeIn pb-10">

    <div class="bg-secondary pt-8 pb-12 px-6 rounded-[2.5rem] shadow-2xl relative overflow-hidden mt-2">
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-primary/10 rounded-full blur-3xl"></div>
        <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-white/5 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 flex flex-col items-center text-center">
            
            <div class="relative mb-4 cursor-pointer group" onclick="document.getElementById('inputFoto').click()">
                @if($user->foto)
                    <img id="previewFoto" src="{{ asset('storage/' . $user->foto) }}" 
                         class="w-24 h-24 rounded-[2rem] border-4 border-white/10 shadow-xl object-cover transition-transform group-hover:scale-105" alt="Avatar">
                @else
                    <img id="previewFoto" src="https://ui-avatars.com/api/?name={{ urlencode($user->nama_lengkap) }}&background=F4C430&color=1F2937&bold=true&size=128" 
                         class="w-24 h-24 rounded-[2rem] border-4 border-white/10 shadow-xl object-cover transition-transform group-hover:scale-105" alt="Avatar Default">
                @endif
                
                <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-primary rounded-full border-4 border-secondary flex items-center justify-center shadow-lg group-hover:bg-white group-hover:text-primary transition-colors">
                    <i class="fa-solid fa-camera text-secondary text-[10px] group-hover:text-primary"></i>
                </div>
            </div>
            <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-1 mb-2 italic">Ketuk foto untuk mengubah</p>
            
            <h2 class="text-2xl font-black text-white tracking-tighter">{{ $user->nama_lengkap }}</h2>
            <p class="text-primary text-xs font-bold uppercase tracking-widest mt-1 mb-3">{{ $user->nip }}</p>
            
            <span class="bg-white/10 border border-white/20 text-white px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest backdrop-blur-sm">
                Pegawai Aktif
            </span>
        </div>
    </div>

    <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm relative -mt-8 z-20 mx-2">
        <div class="flex items-center space-x-3 mb-6 border-b border-gray-50 pb-4">
            <div class="w-10 h-10 bg-primary/20 rounded-xl flex items-center justify-center text-secondary">
                <i class="fa-solid fa-user-shield text-lg"></i>
            </div>
            <div>
                <h3 class="text-sm font-black text-secondary uppercase tracking-tighter">Pengaturan <span class="text-primary">Akun</span></h3>
                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">Update Kontak & Keamanan</p>
            </div>
        </div>

        <form action="{{ route('pegawai.profil.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <input type="file" name="foto" id="inputFoto" class="hidden" accept="image/jpeg, image/png, image/jpg" onchange="previewImage(this)">

            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 ml-1">No. WhatsApp Aktif</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                        <i class="fa-solid fa-phone"></i>
                    </span>
                    <input type="text" name="no_hp" value="{{ $user->no_hp }}" class="w-full pl-10 pr-4 py-3.5 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-primary outline-none transition-all text-sm font-bold text-secondary" required>
                </div>
            </div>

            <div class="p-4 bg-gray-50/50 rounded-2xl border border-gray-100 space-y-4">
                <p class="text-[10px] font-black text-secondary uppercase tracking-widest border-l-4 border-primary pl-2 mb-2">Ubah Password (Opsional)</p>
                
                <div>
                    <label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Password Lama</label>
                    <input type="password" name="password_lama" class="w-full px-4 py-3 bg-white border border-gray-100 rounded-xl focus:border-primary outline-none transition-all text-xs font-bold text-secondary" placeholder="••••••••">
                </div>
                <div>
                    <label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Password Baru</label>
                    <input type="password" name="password_baru" class="w-full px-4 py-3 bg-white border border-gray-100 rounded-xl focus:border-primary outline-none transition-all text-xs font-bold text-secondary" placeholder="Minimal 6 Karakter">
                </div>
            </div>

            <button type="submit" id="btnSaveProfile" class="w-full bg-primary text-secondary font-black text-xs py-4 rounded-2xl shadow-xl shadow-primary/20 hover:bg-black hover:text-primary transition-all uppercase tracking-[0.2em] mt-2 flex justify-center items-center">
                Simpan Perubahan
            </button>
        </form>
    </div>

    <div class="mx-2 mt-8">
        <button onclick="confirmLogout()" class="w-full bg-red-50 border border-red-100 text-red-500 font-black text-xs py-4 rounded-2xl hover:bg-red-500 hover:text-white transition-all uppercase tracking-[0.2em] flex items-center justify-center shadow-sm">
            <i class="fa-solid fa-power-off mr-3 text-lg"></i> Keluar Dari Sistem
        </button>
    </div>

</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
    @csrf
</form>

@push('scripts')
<script>
    // Fitur Live Preview Foto Profil
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                // Ganti src gambar dengan gambar yang baru dipilih
                document.getElementById('previewFoto').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Modal Konfirmasi Logout
    function confirmLogout() {
        Swal.fire({
            title: 'KELUAR SISTEM?',
            text: "Anda harus login kembali untuk melakukan absensi.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444', 
            cancelButtonColor: '#1F2937',  
            confirmButtonText: 'YA, KELUAR',
            cancelButtonText: 'BATAL',
            customClass: {
                popup: 'rounded-[2rem]', 
                confirmButton: 'rounded-xl px-6 py-3 font-bold uppercase tracking-widest',
                cancelButton: 'rounded-xl px-6 py-3 font-bold uppercase tracking-widest'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }

    // Loading State saat Simpan Form
    document.querySelector('form[action="{{ route('pegawai.profil.update') }}"]').addEventListener('submit', function() {
        const btn = document.getElementById('btnSaveProfile');
        btn.innerHTML = `<i class="fa-solid fa-spinner fa-spin mr-2"></i> MENYIMPAN...`;
        btn.classList.add('opacity-75', 'cursor-not-allowed');
    });
</script>
@endpush
@endsection