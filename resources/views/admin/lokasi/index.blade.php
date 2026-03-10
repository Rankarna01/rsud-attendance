@extends('layouts.admin')

@section('content')
<div class="space-y-6 animate-fadeIn">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-100 pb-6">
        <div>
            <h2 class="text-2xl font-black text-secondary uppercase tracking-tighter">Konfigurasi <span class="text-primary">Geofencing</span></h2>
            <p class="text-sm text-gray-500 font-medium">Atur titik pusat absensi dan batasan radius jangkauan perangkat.</p>
        </div>
        <div class="flex items-center space-x-2">
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Status System:</span>
            <div class="flex items-center bg-green-50 px-3 py-1 rounded-full">
                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse mr-2"></div>
                <span class="text-green-600 text-[10px] font-black uppercase">GPS Active</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-0 shadow-2xl shadow-gray-200 border border-gray-200 rounded-sm overflow-hidden bg-white">
        
        <div class="lg:col-span-4 p-8 border-r border-gray-100 flex flex-col justify-between bg-white">
            <form action="{{ route('admin.lokasi.update') }}" method="POST" class="space-y-8">
                @csrf
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-[11px] font-black text-secondary uppercase mb-3 tracking-[0.2em]">Nama Institusi / Lokasi</label>
                        <div class="relative">
                            <input type="text" name="nama_lokasi" value="{{ $lokasi->nama_lokasi ?? 'RSUD CENTRAL' }}" 
                                class="w-full px-4 py-4 bg-gray-50 border-l-4 border-gray-200 outline-none focus:border-primary focus:bg-white transition-all text-sm font-bold text-secondary shadow-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-secondary uppercase mb-3 tracking-[0.2em]">Koordinat Presisi</label>
                        <div class="relative group">
                            <input type="text" name="lat_long" id="lat_long" value="{{ $lokasi->lat_long ?? '-6.200000,106.816666' }}" readonly
                                class="w-full px-4 py-4 bg-secondary text-primary border-0 outline-none text-sm font-mono tracking-tighter shadow-inner cursor-not-allowed">
                            <div class="absolute right-4 top-4 text-primary/50 group-hover:text-primary transition-colors">
                                <i class="fa-solid fa-lock text-xs"></i>
                            </div>
                        </div>
                        <p class="text-[9px] text-gray-400 mt-3 italic font-medium leading-relaxed uppercase tracking-tighter">
                            *Gunakan tombol deteksi atau geser pin pada peta untuk merubah koordinat secara otomatis.
                        </p>
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-secondary uppercase mb-3 tracking-[0.2em]">Radius Jangkauan (Mtr)</label>
                        <div class="flex items-center bg-gray-50 border-l-4 border-gray-200 focus-within:border-primary transition-all">
                            <input type="number" name="radius" id="radius_input" value="{{ $lokasi->radius ?? 50 }}" oninput="updateRadius(this.value)"
                                class="flex-1 bg-transparent px-4 py-4 outline-none text-sm font-black text-secondary">
                            <span class="pr-6 text-[10px] font-black text-gray-400 uppercase tracking-widest italic">Meters</span>
                        </div>
                    </div>
                </div>

                <div class="space-y-3 pt-6 border-t border-gray-50">
                    <button type="button" onclick="getLocation()" 
                        class="w-full bg-white border-2 border-secondary text-secondary font-black py-4 text-[10px] uppercase tracking-[0.2em] hover:bg-secondary hover:text-white transition-all flex items-center justify-center group">
                        <i id="loc-icon" class="fa-solid fa-location-crosshairs mr-2 group-hover:rotate-90 transition-transform"></i> Deteksi Lokasi Saya
                    </button>
                    
                    <button type="submit" 
                        class="w-full bg-primary text-secondary font-black py-5 text-[11px] uppercase tracking-[0.3em] hover:bg-black hover:text-primary transition-all shadow-xl shadow-yellow-500/10">
                        Update Konfigurasi
                    </button>
                </div>
            </form>

            <div class="mt-8 p-4 bg-blue-50/50 border border-blue-100 rounded-sm">
                <div class="flex">
                    <i class="fa-solid fa-circle-info text-blue-400 mt-1"></i>
                    <p class="ml-3 text-[10px] text-blue-600 font-medium leading-normal italic">
                        Pastikan koordinat tersimpan dengan benar agar sistem Geofencing dapat memvalidasi absensi pegawai melalui mobile device.
                    </p>
                </div>
            </div>
        </div>

        <div class="lg:col-span-8 min-h-[550px] relative bg-gray-100">
            <div class="absolute top-6 left-6 z-[1000] flex space-x-2">
                <div class="bg-secondary text-white px-4 py-2 text-[10px] font-black uppercase tracking-widest shadow-2xl flex items-center">
                    <i class="fa-solid fa-map-pin text-primary mr-2"></i> LatLng Tracker
                </div>
            </div>

            <div id="map" class="absolute inset-0 z-10"></div>
        </div>

    </div>
</div>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn { animation: fadeIn 0.5s ease-out; }
    
    /* Styling Leaflet Scale & Zoom biar minimalis */
    .leaflet-control-zoom { border: none !important; border-radius: 0 !important; }
    .leaflet-control-zoom-in, .leaflet-control-zoom-out { background: #1F2937 !important; color: #F4C430 !important; border: 1px solid rgba(255,255,255,0.1) !important; }
    
    /* Marker Shadow */
    .leaflet-marker-icon { filter: drop-shadow(0 4px 6px rgba(0,0,0,0.3)); }
</style>

@push('scripts')
<script>
    // 1. Inisialisasi Data
    const savedCoords = "{{ $lokasi->lat_long ?? '-6.200000,106.816666' }}".split(',');
    const startLat = parseFloat(savedCoords[0]);
    const startLng = parseFloat(savedCoords[1]);
    const startRad = parseInt("{{ $lokasi->radius ?? 50 }}");

    // 2. Setup Map (Leaflet)
    const map = L.map('map', {
        zoomControl: true,
        scrollWheelZoom: true
    }).setView([startLat, startLng], 17);

    // 3. Tile Layer (Gaya Google Maps Clean)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; SIAGA Attendance System'
    }).addTo(map);

    // 4. Marker & Radius Circle
    let marker = L.marker([startLat, startLng], { draggable: true }).addTo(map);
    
    let circle = L.circle([startLat, startLng], {
        color: '#F4C430',
        fillColor: '#F4C430',
        fillOpacity: 0.15,
        weight: 2,
        radius: startRad
    }).addTo(map);

    // 5. Update Position Logic
    function updatePosition(lat, lng) {
        const fixedLat = lat.toFixed(6);
        const fixedLng = lng.toFixed(6);
        document.getElementById('lat_long').value = `${fixedLat},${fixedLng}`;
        circle.setLatLng([lat, lng]);
        map.panTo([lat, lng]);
    }

    marker.on('dragend', function(e) {
        const pos = marker.getLatLng();
        updatePosition(pos.lat, pos.lng);
    });

    function updateRadius(val) {
        circle.setRadius(val || 0);
    }

    // 6. Get Current Location Logic
    function getLocation() {
        const icon = document.getElementById('loc-icon');
        
        if (navigator.geolocation) {
            icon.classList.remove('fa-location-crosshairs');
            icon.classList.add('fa-spinner', 'fa-spin');

            navigator.geolocation.getCurrentPosition((position) => {
                const myLat = position.coords.latitude;
                const myLng = position.coords.longitude;

                marker.setLatLng([myLat, myLng]);
                updatePosition(myLat, myLng);
                
                icon.classList.remove('fa-spinner', 'fa-spin');
                icon.classList.add('fa-location-crosshairs');

                Swal.fire({
                    icon: 'success',
                    title: 'LOKASI TERDETEKSI',
                    text: 'Koordinat berhasil disesuaikan dengan GPS anda.',
                    confirmButtonColor: '#1F2937',
                    customClass: { popup: 'rounded-none' }
                });
            }, (error) => {
                icon.classList.remove('fa-spinner', 'fa-spin');
                icon.classList.add('fa-location-crosshairs');
                Swal.fire({ 
                    icon: 'error', 
                    title: 'GPS ERROR', 
                    text: 'Gagal mengambil lokasi. Pastikan izin browser aktif.',
                    confirmButtonColor: '#EF4444',
                    customClass: { popup: 'rounded-none' }
                });
            }, { enableHighAccuracy: true });
        }
    }

    @if(session('success'))
        Swal.fire({ 
            icon: 'success', 
            title: 'KONFIGURASI UPDATED', 
            text: "{{ session('success') }}", 
            confirmButtonColor: '#F4C430',
            customClass: { popup: 'rounded-none' }
        });
    @endif
</script>
@endpush
@endsection