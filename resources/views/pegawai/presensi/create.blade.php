@extends('layouts.mobile')

@section('content')
<div class="space-y-6 animate-fadeIn min-h-[70vh] flex flex-col justify-center">
    
    <div class="text-center space-y-2 mb-4">
        <h2 class="text-2xl font-black text-secondary uppercase tracking-tighter">Face <span class="text-primary">Recognition</span></h2>
        <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Arahkan wajah ke dalam area</p>
    </div>

    <div class="relative w-72 h-72 mx-auto flex items-center justify-center">
        <div class="absolute inset-0 border-[4px] border-primary/30 rounded-[3rem] animate-pulse"></div>
        <div class="absolute inset-4 border-[2px] border-primary/50 rounded-[2.5rem]"></div>
        
        <div class="relative z-10 w-full h-full bg-secondary rounded-[3rem] shadow-2xl overflow-hidden border-4 border-white/20">
            <video id="webcam" autoplay playsinline class="w-full h-full object-cover transform scale-x-[-1]"></video>
            
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-50">
                <i class="fa-solid fa-expand text-6xl text-white"></i>
            </div>
        </div>
    </div>

    <canvas id="canvas" class="hidden"></canvas>
    
    <form id="form-presensi" action="{{ route('pegawai.presensi.store') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="lokasi" id="input-lokasi">
        <input type="hidden" name="foto" id="input-foto">
    </form>

    <div class="mt-8 px-6">
        @if(!$presensi)
            <button type="button" onclick="captureAndSubmit()" id="btn-absen" class="w-full bg-primary text-secondary font-black text-lg py-5 rounded-[2rem] shadow-xl shadow-primary/30 hover:bg-black hover:text-primary transition-all uppercase tracking-[0.2em] flex items-center justify-center">
                <i class="fa-solid fa-camera mr-3"></i> TAP IN SEKARANG
            </button>
        @elseif(!$presensi->jam_pulang)
            <button type="button" onclick="captureAndSubmit()" id="btn-absen" class="w-full bg-red-500 text-white font-black text-lg py-5 rounded-[2rem] shadow-xl shadow-red-500/30 hover:bg-red-700 transition-all uppercase tracking-[0.2em] flex items-center justify-center">
                <i class="fa-solid fa-camera mr-3"></i> TAP OUT SEKARANG
            </button>
        @else
            <div class="w-full bg-gray-100 text-gray-400 font-black text-lg py-5 rounded-[2rem] uppercase tracking-[0.2em] flex items-center justify-center">
                <i class="fa-solid fa-check-double mr-3"></i> SUDAH ABSEN
            </div>
        @endif
    </div>

    <div class="flex justify-between items-center bg-white p-4 rounded-2xl border border-gray-100 shadow-sm mt-4">
        <div class="flex items-center space-x-2">
            <i class="fa-solid fa-camera text-gray-400" id="cam-icon"></i>
            <span class="text-[9px] font-bold text-gray-500 uppercase tracking-widest" id="cam-status">Kamera Aktif</span>
        </div>
        <div class="flex items-center space-x-2">
            <span class="text-[9px] font-bold text-orange-500 uppercase tracking-widest" id="gps-status">Mencari GPS...</span>
            <i class="fa-solid fa-satellite-dish text-orange-500 animate-pulse" id="gps-icon"></i>
        </div>
    </div>

</div>

@push('scripts')
<script>
    const video = document.getElementById('webcam');
    const canvas = document.getElementById('canvas');
    let gpsLocation = null;

    // 1. Inisialisasi Kamera Depan saat halaman dimuat
    navigator.mediaDevices.getUserMedia({ video: { facingMode: "user" } })
        .then(function(stream) {
            video.srcObject = stream;
        })
        .catch(function(err) {
            document.getElementById('cam-status').innerText = "Kamera Error/Diblokir";
            document.getElementById('cam-icon').classList.replace('text-gray-400', 'text-red-500');
            Swal.fire({ icon: 'error', title: 'KAMERA ERROR', text: 'Mohon izinkan akses kamera pada browser Anda.' });
        });

    // 2. Dapatkan Lokasi GPS secara asinkron agar tidak menunggu lama saat ditekan
    if (navigator.geolocation) {
        navigator.geolocation.watchPosition(
            (position) => {
                gpsLocation = `${position.coords.latitude},${position.coords.longitude}`;
                document.getElementById('gps-status').innerText = "GPS Terkunci";
                document.getElementById('gps-status').classList.replace('text-orange-500', 'text-green-500');
                document.getElementById('gps-icon').classList.replace('text-orange-500', 'text-green-500');
                document.getElementById('gps-icon').classList.remove('animate-pulse');
            },
            (error) => {
                document.getElementById('gps-status').innerText = "GPS Diblokir";
                document.getElementById('gps-status').classList.replace('text-orange-500', 'text-red-500');
            },
            { enableHighAccuracy: true, maximumAge: 10000 }
        );
    }

    // 3. Fungsi Eksekusi (Jepret Foto + Submit)
    function captureAndSubmit() {
        if (!gpsLocation) {
            Swal.fire({ icon: 'warning', title: 'MENCARI GPS', text: 'Tunggu sebentar, lokasi Anda belum terkunci.', confirmButtonColor: '#F4C430' });
            return;
        }

        const btn = document.getElementById('btn-absen');
        btn.innerHTML = `<i class="fa-solid fa-spinner fa-spin mr-3"></i> MEMPROSES...`;
        btn.disabled = true;

        // Jepret foto dari tag video ke canvas
        const context = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        
        // Membalikkan gambar agar tidak mirror (seperti kaca) saat disimpan
        context.translate(canvas.width, 0);
        context.scale(-1, 1);
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        
        // Konversi ke format Base64 JPEG
        const photoData = canvas.toDataURL('image/jpeg', 0.8);
        
        // Isi form tersembunyi
        document.getElementById('input-foto').value = photoData;
        document.getElementById('input-lokasi').value = gpsLocation;

        Swal.fire({
            title: 'Memverifikasi Data...',
            text: 'Menyimpan bukti foto dan koordinat lokasi Anda.',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        // Hentikan kamera agar lampu indikator mati
        const stream = video.srcObject;
        const tracks = stream.getTracks();
        tracks.forEach(track => track.stop());

        // Submit form
        document.getElementById('form-presensi').submit();
    }
</script>
@endpush
@endsection