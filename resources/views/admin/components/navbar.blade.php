<header class="bg-white/80 backdrop-blur-md sticky top-0 z-40 px-10 py-5 flex justify-between items-center border-b border-gray-100">
    <div class="flex items-center">
        <button class="text-secondary hover:text-primary transition-colors">
            <i class="fa-solid fa-bars-staggered text-2xl"></i>
        </button>
        <h2 class="ml-6 font-bold text-secondary text-lg hidden md:block">SIAGA <span class="text-primary text-sm font-medium ml-2 border-l pl-2 border-gray-200 uppercase tracking-widest">Dashboard Panel</span></h2>
    </div>

    <div class="flex items-center space-x-8">
        <div class="relative cursor-pointer group">
            <div class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-[10px] flex items-center justify-center rounded-full border-2 border-white font-bold">3</div>
            <i class="fa-solid fa-bell text-gray-400 text-xl group-hover:text-primary transition-all"></i>
        </div>

        <div class="flex items-center space-x-4 border-l pl-8 border-gray-100">
            <div class="text-right">
                <p class="text-sm font-bold text-secondary leading-none">{{ Auth::user()->nama_lengkap }}</p>
                <p class="text-[10px] text-primary font-bold uppercase mt-1 tracking-widest">Administrator</p>
            </div>
            <div class="w-12 h-12 rounded-2xl overflow-hidden shadow-lg border-2 border-primary/20 p-0.5">
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->nama_lengkap }}&background=F4C430&color=1F2937" class="w-full h-full rounded-[14px] object-cover">
            </div>
        </div>
    </div>
</header>