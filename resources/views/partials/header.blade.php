<header id="main-header" class="fixed top-0 w-full z-50 transition-all duration-500 bg-transparent py-4 px-6 md:px-12 flex justify-between items-center">
    <div class="flex items-center gap-4">
        {{-- Ambil Logo Polinema dari DB, kalau kosong pakai bawaan --}}
        <img src="{{ !empty($webSettings->logo_polinema) ? asset('storage/'.$webSettings->logo_polinema) : '/images/logo-polinema.png' }}" alt="Polinema" class="h-10 w-auto">
        
        {{-- Ambil Logo UMKM dari DB, kalau kosong pakai bawaan --}}
        <img src="{{ !empty($webSettings->logo_umkm) ? asset('storage/'.$webSettings->logo_umkm) : '/images/logo-garudeya.jpeg' }}" alt="Batik Garudeya" class="h-10 w-auto rounded-full object-cover bg-white">
        
        {{-- Ambil Nama Web dari DB, pisah kata jadi dua baris (opsional, menyesuaikan) --}}
        <span id="header-title" class="text-white font-bold text-lg hidden md:block drop-shadow-md transition-colors duration-300">
            {{ $webSettings->website_name ?? 'Batik Garudeya Kidal' }}
        </span>
    </div>

    <nav id="main-nav" class="hidden md:flex relative items-center gap-1 font-semibold drop-shadow-md z-10 p-1">
        
        <div id="nav-indicator" class="absolute top-1 bottom-1 left-0 rounded-full bg-white transition-all duration-300 ease-out -z-10 shadow-sm" style="width: 0px; transform: translateX(0px);"></div>

        @php 
            $currentRoute = request()->path(); 
        @endphp

        <a href="/" class="nav-link relative px-5 py-1.5 rounded-full transition-colors duration-300 {{ $currentRoute == '/' ? 'active-link' : '' }}">Beranda</a>
        <a href="/profil" class="nav-link relative px-5 py-1.5 rounded-full transition-colors duration-300 {{ $currentRoute == 'profil' ? 'active-link' : '' }}">Profil</a>
        <a href="/produk" class="nav-link relative px-5 py-1.5 rounded-full transition-colors duration-300 {{ $currentRoute == 'produk' ? 'active-link' : '' }}">Produk</a>
        <a href="/artikel" class="nav-link relative px-5 py-1.5 rounded-full transition-colors duration-300 {{ $currentRoute == 'artikel' ? 'active-link' : '' }}">Artikel</a>
        <a href="/kontak" class="nav-link relative px-5 py-1.5 rounded-full transition-colors duration-300 {{ $currentRoute == 'kontak' ? 'active-link' : '' }}">Kontak</a>
    </nav>

    <a href="https://wa.me/{{ $webSettings->whatsapp_number ?? '628123456789' }}?text={{ urlencode($webSettings->whatsapp_message ?? 'Halo Batik Garudeya') }}" 
        target="_blank" 
        class="bg-[#25D366] hover:bg-[#20ba5a] text-white px-5 py-2 rounded-full font-semibold flex items-center gap-2 transition shadow-lg group">
        <span>Pesan</span>
        <img src="/images/icons/whatsapp.png" alt="WhatsApp" class="w-5 h-5 object-contain transition-transform group-hover:scale-110">
    </a>
</header>