@extends('layouts.main')

@section('content')

{{-- CDN Swiper CSS & Font Caveat --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<style>
    @import url('https://fonts.googleapis.com/css2?family=Caveat:wght@400;700&display=swap');
    .font-caveat { font-family: 'Caveat', cursive; }
    
    /* Styling Arrow Swiper Custom */
    .swiper-button-next, .swiper-button-prev {
        color: #555 !important;
        background: rgba(255, 255, 255, 0.9);
        width: 45px;
        height: 45px;
        border-radius: 50%;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }
    .swiper-button-next:hover, .swiper-button-prev:hover {
        background: #fff;
        transform: scale(1.1);
    }
    .swiper-button-next:after, .swiper-button-prev:after {
        font-size: 18px !important;
        font-weight: bold;
    }
    
    /* Efek underline pesan sekarang */
    .link-pesan {
        border-bottom: 1.5px solid #333;
        padding-bottom: 2px;
    }
</style>

{{-- ================================================================= --}}
{{-- 1. HARDCODED FIXED BANNER (Parallax Setengah Layar) --}}
{{-- ================================================================= --}}
<section class="fixed top-0 left-0 w-full h-[45vh] md:h-[50vh] -z-10 bg-cover bg-center" style="background-image: url('/images/banner-katalog.png');">
    <div class="absolute inset-0 bg-black/40"></div> 
    <div class="absolute inset-0 flex items-center justify-center">
        <h1 class="text-6xl md:text-8xl font-caveat text-white drop-shadow-xl mt-12 scroll-anim fade-up">Garudeya Kidal</h1>
    </div>
</section>

{{-- ================================================================= --}}
{{-- 2. KONTEN UTAMA (Lebar Maksimal max-w-7xl & Meluncur ke atas) --}}
{{-- ================================================================= --}}
<div class="relative z-10 mt-[35vh] md:mt-[40vh] bg-white pt-12 md:pt-20 pb-20 md:pb-32 rounded-t-3xl shadow-[0_-20px_60px_rgba(0,0,0,0.2)] min-h-screen overflow-hidden">
    {{-- LAYOUT DIPERLEBAR JADI max-w-7xl (sekitar 1280px) --}}
    <div class="max-w-7xl mx-auto px-6 md:px-12">

        {{-- SEARCH BAR --}}
        <div class="mb-14 relative z-50 max-w-4xl mx-auto scroll-anim slide-up delay-100">
            <div class="relative group">
                <input type="text" id="searchInput" placeholder="Cari produk" autocomplete="off"
                       class="w-full border-2 border-gray-200 rounded-full py-4 px-8 text-gray-700 focus:outline-none focus:border-brand-green focus:ring-2 focus:ring-brand-green/20 transition-all text-lg shadow-sm group-hover:shadow-md">
                <div class="absolute right-6 top-1/2 transform -translate-y-1/2 text-gray-400 group-hover:text-brand-green transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
            
            {{-- Dropdown Hasil Pencarian --}}
            <ul id="searchResults" class="absolute z-50 w-full bg-white border border-gray-200 rounded-2xl shadow-xl mt-3 hidden overflow-hidden max-h-72 overflow-y-auto transform origin-top transition-all">
                <!-- Hasil pencarian via JS -->
            </ul>
        </div>

        {{-- SLIDER KATEGORI (Circular) --}}
        <div class="mb-10 relative scroll-anim scale-in delay-200">
            <div class="swiper categorySwiper h-32 md:h-48 overflow-hidden shadow-sm">
                <div class="swiper-wrapper">
                    @forelse($categories as $cat)
                        <div class="swiper-slide cursor-pointer group" onclick="window.location.href='?kategori={{ $cat->slug }}'">
                            <div class="relative w-full h-full bg-brand-dark">
                                <img src="{{ $cat->image ? asset('storage/'.$cat->image) : 'https://via.placeholder.com/800x300?text=Kategori' }}" 
                                     alt="{{ $cat->name }}" 
                                     class="w-full h-full object-cover opacity-80 transition-transform duration-700 group-hover:scale-110 group-hover:opacity-100">
                                <div class="absolute inset-0 bg-black/30 group-hover:bg-black/10 transition-colors duration-300"></div>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <h3 class="text-white text-3xl md:text-4xl font-bold tracking-widest drop-shadow-lg uppercase">{{ $cat->name }}</h3>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="swiper-slide">
                            <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400 font-medium">Belum ada kategori</div>
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="swiper-button-prev !-left-4 md:!-left-6"></div>
            <div class="swiper-button-next !-right-4 md:!-right-6"></div>
        </div>

        {{-- Notifikasi Filter --}}
        @if($categorySlug)
            <div class="mb-10 flex items-center justify-between bg-brand-green/10 border border-brand-green/20 px-6 py-4 rounded-xl scroll-anim fade-up">
                <span class="text-brand-dark font-medium text-lg">Menampilkan kategori: <strong class="uppercase tracking-wide">{{ str_replace('-', ' ', $categorySlug) }}</strong></span>
                <a href="{{ route('produk.index') }}" class="text-sm font-bold text-red-500 hover:text-red-700 bg-white px-4 py-2 rounded-full shadow-sm transition hover:shadow">Hapus Filter ✕</a>
            </div>
        @endif

        @php
            // Array delay untuk animasi staggered (bergantian)
            $delays = ['delay-100', 'delay-200', 'delay-300', 'delay-400'];
        @endphp

        {{-- DISARANKAN UNTUK ANDA --}}
        @if(!$categorySlug && $recommendedProducts->count() > 0)
        <div class="mb-10">
            {{-- Menggunakan class font persis seperti request --}}
            <h2 class="text-4xl md:text-5xl font-serif font-regular text-brand-green italic leading-tight font-caveat mb-10 scroll-anim slide-right">Disarankan untuk anda</h2>
            
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-12 md:gap-x-10">
                @foreach($recommendedProducts as $index => $product)
                    <div class="group flex flex-col scroll-anim fade-up {{ $delays[$index % 4] }}">
                        {{-- GAMBAR BISA DIKLIK MASUK KE DETAIL --}}
                        <a href="{{ route('produk.show', $product->slug) }}" class="relative w-full aspect-[3/4] mb-4 overflow-hidden bg-[#f8f8f8] rounded-sm block">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700">
                        </a>
                        
                        {{-- JUDUL BISA DIKLIK MASUK KE DETAIL --}}
                        <a href="{{ route('produk.show', $product->slug) }}">
                            <h3 class="text-gray-900 font-medium text-xl leading-tight mb-1 group-hover:text-brand-green transition-colors">{{ strtolower($product->name) }}</h3>
                        </a>
                        
                        <p class="text-gray-600 mb-3 text-lg font-serif">Rp. {{ number_format($product->price, 0, ',', '.') }}</p>
                        
                        {{-- TOMBOL LIHAT DETAIL --}}
                        <a href="{{ route('produk.show', $product->slug) }}" class="inline-flex items-center gap-2 text-base font-medium text-gray-800 hover:text-brand-green transition-colors w-max link-pesan group-hover:border-brand-green">
                            Lihat Detail <span class="text-xl leading-none transform group-hover:translate-x-2 transition-transform">→</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- BATIK LAINNYA --}}
        <div>
            <h2 class="text-4xl md:text-5xl font-serif font-regular text-brand-green italic leading-tight font-caveat mb-10 scroll-anim slide-right">{{ $categorySlug ? 'Hasil Pencarian Kategori' : 'Batik lainnya' }}</h2>
            
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-12 md:gap-x-10">
                @forelse($latestProducts as $index => $product)
                    <div class="group flex flex-col scroll-anim fade-up {{ $delays[$index % 4] }}">
                        {{-- GAMBAR BISA DIKLIK MASUK KE DETAIL --}}
                        <a href="{{ route('produk.show', $product->slug) }}" class="relative w-full aspect-[3/4] mb-4 overflow-hidden bg-[#f8f8f8] rounded-sm block">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700">
                        </a>
                        
                        {{-- JUDUL BISA DIKLIK MASUK KE DETAIL --}}
                        <a href="{{ route('produk.show', $product->slug) }}">
                            <h3 class="text-gray-900 font-medium text-xl leading-tight mb-1 group-hover:text-brand-green transition-colors">{{ strtolower($product->name) }}</h3>
                        </a>
                        
                        <p class="text-gray-600 mb-3 text-lg font-serif">Rp. {{ number_format($product->price, 0, ',', '.') }}</p>
                        
                        {{-- TOMBOL LIHAT DETAIL --}}
                        <a href="{{ route('produk.show', $product->slug) }}" class="inline-flex items-center gap-2 text-base font-medium text-gray-800 hover:text-brand-green transition-colors w-max link-pesan group-hover:border-brand-green">
                            Lihat Detail <span class="text-xl leading-none transform group-hover:translate-x-2 transition-transform">→</span>
                        </a>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center text-gray-500 scroll-anim fade-in">
                        <span class="text-2xl font-caveat">Belum ada produk batik untuk ditampilkan.</span>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

{{-- CDN Swiper JS --}}
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<script>
    {{-- SESUDAH: --}}
    const categorySwiper = new Swiper('.categorySwiper', {
        loop: true,
        slidesPerView: 1,
        spaceBetween: 0,
        speed: 600,
        autoplay: {
            delay: 1500,
            disableOnInteraction: false,
            reverseDirection: false,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            768: {
                slidesPerView: 2,
                spaceBetween: 0,
            }
        }
    });

    // 2. Logic Search Autocomplete (AJAX)
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');
    let timeoutId;

    searchInput.addEventListener('input', function() {
        clearTimeout(timeoutId);
        const query = this.value.trim();

        if (query.length < 2) {
            searchResults.innerHTML = '';
            searchResults.classList.add('hidden');
            return;
        }

        timeoutId = setTimeout(() => {
            fetch(`/api/produk/search?q=${query}`)
                .then(response => response.json())
                .then(data => {
                    searchResults.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(product => {
                            const li = document.createElement('li');
                            li.className = 'px-6 py-4 hover:bg-brand-green/10 cursor-pointer border-b border-gray-100 last:border-0 flex items-center gap-4 transition-colors';
                            
                            // Konten dropdown dengan gambar kecil
                            li.innerHTML = `
                                <img src="/storage/${product.image}" class="w-10 h-10 object-cover rounded shadow-sm" onerror="this.src='https://via.placeholder.com/40'">
                                <span class="text-gray-800 font-medium text-lg">${product.name}</span>
                            `;
                            
                            li.addEventListener('click', () => {
                                searchInput.value = product.name;
                                searchResults.classList.add('hidden');
                                window.open(`https://wa.me/{{ $webSettings->whatsapp_number ?? '628123456789' }}?text=Halo,%20saya%20mencari%20${product.name}`, '_blank');
                            });
                            searchResults.appendChild(li);
                        });
                        searchResults.classList.remove('hidden');
                    } else {
                        searchResults.innerHTML = '<li class="px-6 py-5 text-gray-500 text-center italic">Produk tidak ditemukan</li>';
                        searchResults.classList.remove('hidden');
                    }
                })
                .catch(error => console.error('Error fetching search:', error));
        }, 300);
    });

    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.add('hidden');
        }
    });
</script>

@endsection