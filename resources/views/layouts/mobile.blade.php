<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>SIAGA Mobile</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#F4C430',
                        'secondary': '#1F2937',
                        'surface': '#FFFFFF',
                        'dark-gold': '#B8860B'
                    },
                    fontFamily: { 'poppins': ['Poppins', 'sans-serif'] }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Poppins', sans-serif; overflow-x: hidden; }
        .glass-effect {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
        }
        /* Style khusus untuk Tombol Absen Tengah */
        .btn-absensi {
            filter: drop-shadow(0px 4px 10px rgba(244, 196, 48, 0.4));
        }
    </style>
</head>
<body class="bg-gray-50 text-secondary">

    <div class="max-w-md mx-auto min-h-screen bg-white relative pb-24 shadow-2xl">
        
        @yield('content')

        @include('pegawai.components.bottom-nav')

    </div>

    @stack('scripts')
</body>
</html>