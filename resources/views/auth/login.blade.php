<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Login - Absensi RSUD Gusti Abdul Gani</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#F4C430',
                        secondary: '#1F2937',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; -webkit-tap-highlight-color: transparent; }
        .bg-pattern {
            background-image: radial-gradient(#F4C430 1px, transparent 1px);
            background-size: 20px 20px;
            opacity: 0.1;
        }
        /* Custom placeholder color untuk menyamai desain mobile */
        .input-custom::placeholder { color: #F4C430; opacity: 0.8; }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen relative overflow-x-hidden">

    <div class="fixed inset-0 lg:hidden bg-gradient-to-b from-[#F4C430] to-[#EAB308] z-0"></div>

    <div class="relative z-10 w-full min-h-screen lg:min-h-[600px] lg:max-w-6xl lg:mx-auto lg:my-10 lg:bg-white lg:shadow-2xl lg:rounded-3xl flex flex-col lg:flex-row overflow-hidden">
        
        <div class="lg:hidden h-[35vh] flex flex-col items-center justify-center text-white relative px-6">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-white/20 backdrop-blur-md rounded-2xl p-2 shadow-lg border border-white/30 flex items-center justify-center">
                    <img src="{{ asset('logo.png') }}" alt="Logo RSUD" class="w-full h-full object-contain drop-shadow-md">
                </div>
                <div>
                    <h1 class="text-4xl font-black tracking-widest drop-shadow-md">SIAGA</h1>
                    <p class="text-sm font-medium opacity-90 drop-shadow-md tracking-wider">Aplikasi Absensi RSUD</p>
                </div>
            </div>
            
            <div class="absolute right-6 top-10 opacity-20">
                <i class="fa-solid fa-map-location-dot text-6xl"></i>
            </div>
        </div>

        <div class="flex-1 bg-white rounded-t-[3rem] lg:rounded-none lg:w-1/2 px-8 py-10 lg:p-16 flex flex-col justify-center relative shadow-[0_-10px_40px_rgba(0,0,0,0.1)] lg:shadow-none z-20">
            
            <div class="hidden lg:flex items-center space-x-4 mb-10">
                <div class="w-14 h-14 bg-gray-50 rounded-xl flex items-center justify-center shadow-sm p-2 border border-gray-100">
                    <img src="{{ asset('logo.png') }}" alt="Logo RSUD" class="w-full h-full object-contain">
                </div>
                <div>
                    <h1 class="text-xl font-black tracking-tight text-secondary leading-none uppercase">
                        RSUD <br><span class="text-primary text-2xl">Gusti Abdul Gani</span>
                    </h1>
                </div>
            </div>

            <h2 class="text-4xl font-normal text-gray-800 mb-10 mt-2 lg:mt-0 lg:font-black lg:text-secondary lg:uppercase lg:tracking-tight">
                Login
            </h2>

            <form action="{{ route('login') }}" method="POST" class="space-y-6 flex-1 lg:flex-none flex flex-col">
                @csrf
                
                <div class="relative shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-2xl lg:rounded-2xl bg-white border border-gray-100 focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/20 transition-all">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-5 text-secondary">
                        <i class="fa-solid fa-envelope text-lg"></i>
                    </span>
                    <input type="text" name="login_identity" value="{{ old('login_identity') }}"
                        class="w-full pl-14 pr-6 py-4 bg-transparent outline-none text-gray-700 font-semibold input-custom rounded-2xl" 
                        placeholder="NIP / No HP" required>
                </div>

                <div class="relative shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-2xl lg:rounded-2xl bg-white border border-gray-100 focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/20 transition-all">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-5 text-secondary">
                        <i class="fa-solid fa-key text-lg"></i>
                    </span>
                    <input type="password" name="password" 
                        class="w-full pl-14 pr-12 py-4 bg-transparent outline-none text-gray-700 font-semibold input-custom rounded-2xl" 
                        placeholder="Password" required>
                    <span class="absolute inset-y-0 right-0 flex items-center pr-5 text-gray-400">
                        <i class="fa-solid fa-eye-slash"></i>
                    </span>
                </div>

                <div class="mt-8 flex justify-center lg:justify-start">
                    <button type="submit" 
                        class="w-3/4 lg:w-full bg-gradient-to-r from-[#F4C430] to-[#D4A017] text-white font-bold text-lg py-4 rounded-full lg:rounded-2xl shadow-[0_10px_25px_rgba(244,196,48,0.4)] hover:scale-105 active:scale-95 transition-all tracking-wide flex justify-center items-center">
                        Login
                    </button>
                </div>

                <div class="mt-auto pt-16 text-center lg:hidden">
                    <p class="text-gray-400 text-xs font-medium tracking-wide">Absensi Online Berbasis GPS</p>
                </div>
            </form>
        </div>

        <div class="hidden lg:flex w-1/2 bg-secondary relative overflow-hidden items-center justify-center p-16">
            <div class="absolute inset-0 bg-pattern"></div>
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary/10 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/3"></div>
            
            <div class="relative z-10 w-full max-w-md">
                <div class="mb-10">
                    <i class="fa-solid fa-hospital-user text-6xl text-primary mb-6"></i>
                    <h3 class="text-3xl font-black text-white leading-tight uppercase tracking-tight">Sistem Absensi<br><span class="text-primary">RSUD Gusti Abdul Gani</span></h3>
                    <p class="text-sm text-gray-400 mt-4 leading-relaxed font-medium">Platform presensi digital terpadu dengan integrasi lokasi real-time dan manajemen data terpusat.</p>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center space-x-4 bg-white/5 p-4 rounded-2xl border border-white/10 backdrop-blur-sm">
                        <div class="w-10 h-10 bg-primary/20 rounded-xl flex items-center justify-center text-primary">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-black text-white uppercase tracking-widest">Geofencing Tracking</h4>
                            <p class="text-[10px] text-gray-400 mt-0.5">Validasi lokasi presisi tinggi.</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4 bg-white/5 p-4 rounded-2xl border border-white/10 backdrop-blur-sm">
                        <div class="w-10 h-10 bg-primary/20 rounded-xl flex items-center justify-center text-primary">
                            <i class="fa-solid fa-file-shield"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-black text-white uppercase tracking-widest">Secure Data</h4>
                            <p class="text-[10px] text-gray-400 mt-0.5">Enkripsi data pegawai & aktivitas.</p>
                        </div>
                    </div>
                </div>
            </div>

            <p class="absolute bottom-8 left-16 text-[10px] text-gray-500 font-bold uppercase tracking-[0.2em]">
                &copy; {{ date('Y') }} RSUD Gusti Abdul Gani
            </p>
        </div>
        
    </div>

    @if($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'AKSES DITOLAK',
            text: '{{ $errors->first() }}',
            confirmButtonColor: '#1F2937',
            background: '#ffffff',
            customClass: {
                popup: 'rounded-[2rem]',
                title: 'font-black uppercase tracking-tight',
                confirmButton: 'rounded-xl px-8 py-3 font-bold uppercase tracking-widest text-primary'
            }
        });
    </script>
    @endif

</body>
</html>