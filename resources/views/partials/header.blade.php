<header id="main-header" class="fixed top-0 w-full z-50 transition-all duration-500 bg-transparent py-4 px-6 md:px-12 flex justify-between items-center">
    
    {{-- KIRI: Hamburger (mobile) + Logo --}}
    <div class="flex items-center gap-3">

        {{-- Hamburger Button (hanya mobile) --}}
        <button id="hamburger-btn" class="md:hidden flex flex-col justify-center items-center w-9 h-9 gap-1.5 focus:outline-none z-50 relative" aria-label="Menu">
            <span class="hamburger-line block w-6 h-0.5 bg-white rounded-full transition-all duration-300 drop-shadow"></span>
            <span class="hamburger-line block w-6 h-0.5 bg-white rounded-full transition-all duration-300 drop-shadow"></span>
            <span class="hamburger-line block w-6 h-0.5 bg-white rounded-full transition-all duration-300 drop-shadow"></span>
        </button>

        <img src="{{ !empty($webSettings->logo_polinema) ? asset('storage/'.$webSettings->logo_polinema) : '/images/logo-polinema.png' }}" alt="Polinema" class="h-10 w-auto">
        <img src="{{ !empty($webSettings->logo_umkm) ? asset('storage/'.$webSettings->logo_umkm) : '/images/logo-garudeya.jpeg' }}" alt="Batik Garudeya" class="h-10 w-auto rounded-full object-cover bg-white">
        <span id="header-title" class="text-white font-bold text-lg hidden md:block drop-shadow-md transition-colors duration-300">
            {{ $webSettings->website_name ?? 'Batik Garudeya Kidal' }}
        </span>
    </div>

    {{-- TENGAH: Nav Desktop --}}
    <nav id="main-nav" class="hidden md:flex relative items-center gap-1 font-semibold drop-shadow-md z-10 p-1">
        <div id="nav-indicator" class="absolute top-1 bottom-1 left-0 rounded-full bg-white transition-all duration-300 ease-out -z-10 shadow-sm" style="width: 0px; transform: translateX(0px);"></div>
        <a href="/" class="nav-link relative px-5 py-1.5 rounded-full transition-colors duration-300 {{ request()->is('/') ? 'active-link' : '' }}">Beranda</a>
        <a href="/profil" class="nav-link relative px-5 py-1.5 rounded-full transition-colors duration-300 {{ request()->is('profil*') ? 'active-link' : '' }}">Profil</a>
        <a href="/produk" class="nav-link relative px-5 py-1.5 rounded-full transition-colors duration-300 {{ request()->is('produk*') ? 'active-link' : '' }}">Produk</a>
        <a href="/artikel" class="nav-link relative px-5 py-1.5 rounded-full transition-colors duration-300 {{ request()->is('artikel*') ? 'active-link' : '' }}">Artikel</a>
        <a href="/kontak" class="nav-link relative px-5 py-1.5 rounded-full transition-colors duration-300 {{ request()->is('kontak*') ? 'active-link' : '' }}">Kontak</a>
    </nav>

    {{-- KANAN: Tombol WA --}}
    <a href="https://wa.me/{{ $webSettings->whatsapp_number ?? '628123456789' }}?text={{ urlencode($webSettings->whatsapp_message ?? 'Halo Batik Garudeya') }}" 
        target="_blank" 
        class="bg-[#25D366] hover:bg-[#20ba5a] text-white px-5 py-2 rounded-full font-semibold flex items-center gap-2 transition shadow-lg group">
        <span>Pesan</span>
        <img src="/images/icons/whatsapp.png" alt="WhatsApp" class="w-5 h-5 object-contain transition-transform group-hover:scale-110">
    </a>
</header>

{{-- ===== OVERLAY (backdrop gelap) ===== --}}
<div id="mobile-overlay" class="fixed inset-0 bg-black/50 z-40 opacity-0 pointer-events-none transition-opacity duration-300 md:hidden"></div>

{{-- ===== MOBILE DRAWER ===== --}}
<aside id="mobile-drawer" class="fixed top-0 left-0 h-full w-72 max-w-[80vw] z-50 bg-white shadow-2xl flex flex-col -translate-x-full transition-transform duration-300 ease-in-out md:hidden">
    
    {{-- Header Drawer --}}
    <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
        <div class="flex items-center gap-3">
            <img src="{{ !empty($webSettings->logo_umkm) ? asset('storage/'.$webSettings->logo_umkm) : '/images/logo-garudeya.jpeg' }}" alt="Logo" class="h-10 w-10 rounded-full object-cover">
            <span class="font-bold text-gray-800 text-base leading-tight">{{ $webSettings->website_name ?? 'Batik Garudeya' }}</span>
        </div>
        <button id="close-drawer" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-700 transition">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    {{-- Menu Items --}}
    <nav class="flex flex-col flex-1 px-4 py-6 gap-1">

        @php
            $mobileLinks = [
                ['href' => '/',        'label' => 'Beranda', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'active' => request()->is('/')],
                ['href' => '/profil',  'label' => 'Profil',  'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'active' => request()->is('profil*')],
                ['href' => '/produk',  'label' => 'Produk',  'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z', 'active' => request()->is('produk*')],
                ['href' => '/artikel', 'label' => 'Artikel', 'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 12h6m-6 4h6', 'active' => request()->is('artikel*')],
                ['href' => '/kontak',  'label' => 'Kontak',  'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'active' => request()->is('kontak*')],
            ];
        @endphp

        @foreach($mobileLinks as $link)
        <a href="{{ $link['href'] }}"
           class="mobile-nav-item flex items-center gap-4 px-4 py-3 rounded-xl font-semibold text-sm transition-all duration-200
                  {{ $link['active'] 
                     ? 'bg-brand-green text-white shadow-md' 
                     : 'text-gray-600 hover:bg-gray-100 hover:text-brand-green' }}">
            
            {{-- Indikator bar kiri --}}
            <span class="w-1 h-6 rounded-full {{ $link['active'] ? 'bg-white' : 'bg-transparent' }} transition-all duration-200"></span>
            
            {{-- Icon --}}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 flex-shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $link['icon'] }}"/>
            </svg>

            <span>{{ $link['label'] }}</span>

            {{-- Arrow aktif --}}
            @if($link['active'])
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 ml-auto opacity-70">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            @endif
        </a>
        @endforeach
    </nav>

    {{-- Footer Drawer: Tombol WA --}}
    <div class="px-6 py-5 border-t border-gray-100">
        <a href="https://wa.me/{{ $webSettings->whatsapp_number ?? '628123456789' }}?text={{ urlencode($webSettings->whatsapp_message ?? 'Halo Batik Garudeya') }}"
           target="_blank"
           class="flex items-center justify-center gap-2 w-full bg-[#25D366] hover:bg-[#20ba5a] text-white py-3 rounded-xl font-semibold transition shadow-md">
            <img src="/images/icons/whatsapp.png" alt="WA" class="w-5 h-5 object-contain">
            <span>Pesan via WhatsApp</span>
        </a>
        <p class="text-center text-xs text-gray-400 mt-3">© {{ date('Y') }} {{ $webSettings->website_name ?? 'Batik Garudeya Kidal' }}</p>
    </div>
</aside>

{{-- ===== SCRIPT DRAWER ===== --}}
<script>
(function () {
    const btn      = document.getElementById('hamburger-btn');
    const drawer   = document.getElementById('mobile-drawer');
    const overlay  = document.getElementById('mobile-overlay');
    const closeBtn = document.getElementById('close-drawer');
    const lines    = document.querySelectorAll('.hamburger-line');

    function openDrawer() {
        drawer.classList.remove('-translate-x-full');
        overlay.classList.remove('opacity-0', 'pointer-events-none');
        overlay.classList.add('opacity-100');
        document.body.style.overflow = 'hidden';
        // Animasi hamburger → X
        lines[0].style.transform = 'translateY(8px) rotate(45deg)';
        lines[1].style.opacity   = '0';
        lines[2].style.transform = 'translateY(-8px) rotate(-45deg)';
    }

    function closeDrawer() {
        drawer.classList.add('-translate-x-full');
        overlay.classList.add('opacity-0', 'pointer-events-none');
        overlay.classList.remove('opacity-100');
        document.body.style.overflow = '';
        // Reset hamburger
        lines[0].style.transform = '';
        lines[1].style.opacity   = '';
        lines[2].style.transform = '';
    }

    btn.addEventListener('click', openDrawer);
    closeBtn.addEventListener('click', closeDrawer);
    overlay.addEventListener('click', closeDrawer);
})();
</script>