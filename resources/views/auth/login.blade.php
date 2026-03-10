<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        body { font-family: 'Inter', sans-serif; }
        .bg-pattern {
            background-image: radial-gradient(#F4C430 1px, transparent 1px);
            background-size: 20px 20px;
            opacity: 0.1;
        }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-6xl p-4 md:p-8">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col lg:flex-row min-h-[600px] border border-gray-100">
            
            <div class="w-full lg:w-1/2 p-10 md:p-16 flex flex-col justify-center relative">
                <div class="absolute -top-20 -left-20 w-64 h-64 bg-primary/5 rounded-full blur-3xl"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center space-x-4 mb-10">
                        <div class="w-14 h-14 bg-gray-50 rounded-xl flex items-center justify-center shadow-sm p-2 border border-gray-100">
                            <img src="{{ asset('logo.png') }}" alt="Logo RSUD" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <h1 class="text-xl font-black tracking-tight text-secondary leading-none uppercase">
                                RSUD <br><span class="text-primary text-2xl">Gusti Abdul Gani</span>
                            </h1>
                            <p class="text-[9px] text-gray-400 uppercase tracking-widest mt-1.5 font-bold">Portal Absensi Terpusat</p>
                        </div>
                    </div>

                    <h2 class="text-2xl font-black text-secondary uppercase tracking-tight mb-2">Secure <span class="text-primary">Login</span></h2>
                    <p class="text-sm text-gray-500 font-medium mb-8">Silakan masuk menggunakan kredensial NIP/No.HP yang telah terdaftar.</p>

                    <form action="{{ route('login') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-secondary uppercase tracking-widest ml-1">NIP / No HP</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 group-focus-within:text-primary transition-colors">
                                    <i class="fa-solid fa-id-card"></i>
                                </span>
                                <input type="text" name="login_identity" value="{{ old('login_identity') }}"
                                    class="w-full pl-12 pr-4 py-4 bg-gray-50 border border-transparent rounded-2xl focus:ring-0 focus:border-primary focus:bg-white outline-none transition-all text-sm font-bold text-secondary shadow-sm" 
                                    placeholder="Masukkan NIP atau No HP" required>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-secondary uppercase tracking-widest ml-1">Password</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 group-focus-within:text-primary transition-colors">
                                    <i class="fa-solid fa-lock"></i>
                                </span>
                                <input type="password" name="password" 
                                    class="w-full pl-12 pr-4 py-4 bg-gray-50 border border-transparent rounded-2xl focus:ring-0 focus:border-primary focus:bg-white outline-none transition-all text-sm font-bold text-secondary shadow-sm" 
                                    placeholder="••••••••" required>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-2">
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary">
                                <span class="text-xs font-bold text-gray-500">Ingat Saya</span>
                            </label>
                            <a href="#" class="text-xs font-bold text-primary hover:text-secondary transition-colors border-b border-transparent hover:border-secondary pb-0.5">Lupa Password?</a>
                        </div>

                        <button type="submit" 
                            class="w-full bg-secondary hover:bg-black text-primary font-black py-4 rounded-2xl shadow-lg transition-all active:scale-[0.98] mt-4 flex justify-center items-center text-xs uppercase tracking-[0.2em]">
                            Masuk Sistem <i class="fa-solid fa-arrow-right-to-bracket ml-2"></i>
                        </button>
                    </form>
                </div>
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
                popup: 'rounded-3xl',
                title: 'font-black uppercase tracking-tight',
                confirmButton: 'rounded-xl px-8 py-3 font-bold uppercase tracking-widest text-primary'
            }
        });
    </script>
    @endif

</body>
</html>