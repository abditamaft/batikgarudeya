@extends('layouts.main')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    @import url('https://fonts.googleapis.com/css2?family=Caveat:wght@700&display=swap');
    .font-handwriting { font-family: 'Caveat', cursive; }
    
    /* Swiper Styling Premium */
    .swiper-button-next, .swiper-button-prev {
        color: #1e462c !important; /* Warna Hijau Brand */
        background: rgba(255, 255, 255, 0.9);
        width: 45px !important;
        height: 45px !important;
        border-radius: 50%;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        border: 1px solid #f0f0f0;
        backdrop-filter: blur(4px);
        transition: all 0.3s ease;
    }
    .swiper-button-next:hover, .swiper-button-prev:hover {
        background: #ffffff;
        transform: scale(1.1);
    }
    .swiper-button-next:after, .swiper-button-prev:after {
        font-size: 18px !important;
        font-weight: 900;
    }
    .swiper-pagination-bullet-active {
        background: #1e462c !important;
        transform: scale(1.2);
    }
</style>

{{-- Inisialisasi Alpine.js State --}}
<div x-data="{ 
    searchQuery: '', 
    categoryFilter: 'semua' }">

    {{-- ================================================================= --}}
    {{-- 1. BANNER HERO --}}
    {{-- ================================================================= --}}
    <section class="fixed top-0 left-0 w-full h-[45vh] md:h-[50vh] -z-10 bg-cover bg-center" style="background-image: url('/images/banner-katalog.png');">
        <div class="absolute inset-0 bg-black/50"></div> 
        <div class="absolute inset-0 flex items-center justify-center">
            <h1 class="text-6xl md:text-8xl font-caveat text-white drop-shadow-2xl mt-12 scroll-anim fade-up delay-100 tracking-wide">
                Jurnal Garudeya
            </h1>
        </div>
    </section>

    {{-- ================================================================= --}}
    {{-- 2. WRAPPER KONTEN UTAMA (Diperlebar max-w-7xl & Background Krem Terang) --}}
    {{-- ================================================================= --}}
    <div class="relative z-10 mt-[35vh] md:mt-[40vh] bg-[#Faf7f2] pt-12 md:pt-16 pb-16 md:pb-24 rounded-t-3xl shadow-[0_-20px_60px_rgba(0,0,0,0.2)] overflow-hidden">
        
        <div class="max-w-7xl mx-auto px-4 md:px-8">
            
            {{-- JUDUL HALAMAN --}}
            <div class="text-center mb-10 md:mb-12 scroll-anim fade-up">
                <span class="inline-block text-xs font-bold tracking-[0.3em] uppercase text-brand-green/60 mb-3">Pusat Informasi</span>
                <h1 class="text-5xl md:text-6xl font-caveat font-bold text-gray-900 italic">Artikel & Berita</h1>
                <div class="flex items-center justify-center gap-3 mt-4">
                    <span class="h-px w-12 bg-brand-green/30"></span>
                    <span class="text-brand-green text-lg">✦</span>
                    <span class="h-px w-12 bg-brand-green/30"></span>
                </div>
            </div>

            {{-- ================================================================= --}}
            {{-- 3. ARTIKEL TERPOPULER (Swiper Premium) --}}
            {{-- ================================================================= --}}
            <section class="mb-14 scroll-anim slide-right">
                <div class="flex items-center justify-between mb-6 px-2">
                    <h2 class="text-4xl md:text-5xl font-caveat font-bold text-gray-900">Sedang <span class="text-brand-green italic">Trending</span></h2>
                </div>
                
                <div class="swiper mySwiper rounded-2xl overflow-hidden pb-10">
                    <div class="swiper-wrapper">
                        @forelse($viewTerbanyak as $populer)
                        <div class="swiper-slide">
                            {{-- Card Populer Premium --}}
                            <div class="relative group overflow-hidden rounded-2xl h-[300px] md:h-[420px] shadow-lg border border-gray-100 bg-white">
                                <a href="{{ route('artikel.showDetail', [$populer->category->slug, $populer->slug]) }}" class="block w-full h-full">
                                    <img src="{{ asset('storage/'.$populer->thumbnail) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                </a>
                                {{-- Overlay Gradient --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-[#1a1a1a] via-black/40 to-transparent pointer-events-none"></div>
                                
                                {{-- Konten --}}
                                <div class="absolute bottom-0 left-0 right-0 p-5 md:p-8 z-10">
                                    <div class="flex items-center gap-2 mb-3">
                                        <span class="bg-red-500/90 backdrop-blur text-white text-[10px] md:text-xs font-bold px-3 py-1 rounded-full shadow-sm">🔥 Terpopuler</span>
                                        <span class="bg-white/20 backdrop-blur text-white text-[10px] md:text-xs font-medium px-3 py-1 rounded-full border border-white/20">{{ $populer->category->name ?? 'Berita' }}</span>
                                    </div>
                                    <a href="{{ route('artikel.showDetail', [$populer->category->slug, $populer->slug]) }}">
                                        <h3 class="text-white text-xl md:text-3xl font-medium font-bold leading-tight line-clamp-2 mb-2 group-hover:text-brand-green transition-colors drop-shadow-md">{{ $populer->title }}</h3>
                                    </a>
                                    <div class="flex items-center gap-4 text-white/70 text-xs md:text-sm mt-3 font-medium">
                                        <span>👁 {{ $populer->views ?? 0 }} Tayangan</span>
                                        <span>📅 {{ $populer->created_at->format('d M Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="swiper-slide py-20 text-center bg-white border border-gray-100 rounded-2xl shadow-sm">
                            <p class="text-gray-500 italic">Belum ada artikel trending.</p>
                        </div>
                        @endforelse
                    </div>
                    <div class="swiper-button-next !right-2 md:!right-4"></div>
                    <div class="swiper-button-prev !left-2 md:!left-4"></div>
                    <div class="swiper-pagination"></div>
                </div>
            </section>

            {{-- ================================================================= --}}
            {{-- 4. FILTER & PENCARIAN DOM --}}
            {{-- ================================================================= --}}
            <section class="mb-8 scroll-anim fade-up">
                <div class="bg-white p-4 md:p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
                    
                    <h2 class="text-4xl font-caveat font-bold text-gray-900 hidden md:block">Semua <span class="text-brand-green italic">Artikel</span></h2>
                    
                    <div class="flex flex-col sm:flex-row w-full md:w-auto gap-3">
                        <!-- Dropdown Kategori -->
                        <div class="relative w-full sm:w-48">
                            <select x-model="categoryFilter" class="w-full bg-gray-50 border border-gray-200 text-gray-700 font-medium rounded-xl px-4 py-2.5 appearance-none focus:outline-none focus:ring-2 focus:ring-brand-green cursor-pointer text-sm transition-all">
                                <option value="semua">Semua Kategori</option>
                                @foreach($daftarKategori as $category)
                                    <option value="{{ $category->slug }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>

                        <!-- Input Pencarian -->
                        <div class="relative w-full sm:w-64">
                            <input type="text" x-model="searchQuery" placeholder="Cari judul artikel..." class="w-full bg-gray-50 border border-gray-200 text-gray-700 rounded-xl px-4 py-2.5 pl-10 focus:outline-none focus:ring-2 focus:ring-brand-green text-sm transition-all">
                            <div class="absolute inset-y-0 left-3 flex items-center">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            {{-- ================================================================= --}}
            {{-- 5. GRID KARTU ARTIKEL (HP: 2 Kolom, PC: 4 Kolom) --}}
            {{-- ================================================================= --}}
            <section class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6">
                @forelse($artikelWithSearchFilter as $index => $article)
                @php $delayClass = 'delay-' . (($index % 4) + 1) * 100; @endphp
                
                <div class="bg-white rounded-xl md:rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 flex flex-col h-full group scroll-anim scale-in {{ $delayClass }}"
                     x-show="(categoryFilter === 'semua' || categoryFilter === '{{ $article->category->slug ?? '' }}') && 
                             (searchQuery === '' || '{{ strtolower($article->title) }}'.includes(searchQuery.toLowerCase()))"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100">
                    
                    {{-- Gambar Thumbnail --}}
                    <div class="relative aspect-[4/3] overflow-hidden bg-gray-100 border-b border-gray-50">
                        <a href="{{ route('artikel.showDetail', [$article->category->slug ?? 'berita', $article->slug]) }}" class="block w-full h-full">
                            <img src="{{ asset('storage/'.$article->thumbnail) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        </a>
                        {{-- Badge Kategori --}}
                        <div class="absolute top-2 right-2 md:top-3 md:right-3 bg-white/90 backdrop-blur shadow-sm text-brand-green text-[9px] md:text-xs font-bold px-2 py-1 rounded">
                            {{ $article->category->name ?? 'Berita' }}
                        </div>
                    </div>
                    
                    {{-- Konten Text --}}
                    <div class="p-3 md:p-5 flex flex-col flex-grow">
                        <div class="flex items-center text-gray-400 text-[10px] md:text-xs mb-2 font-medium">
                            <span>📅 {{ $article->created_at->format('d M Y') }}</span>
                        </div>
                        
                        <a href="{{ route('artikel.showDetail', [$article->category->slug ?? 'berita', $article->slug]) }}">
                            <h4 class="font-medium font-bold text-gray-900 text-sm md:text-lg line-clamp-2 mb-2 group-hover:text-brand-green transition-colors leading-snug">
                                {{ $article->title }}
                            </h4>
                        </a>
                        
                        <div class="text-gray-500 text-[11px] md:text-sm line-clamp-2 md:line-clamp-3 leading-relaxed flex-grow mb-4">
                            {{ Str::limit(strip_tags($article->content), 100) }}
                        </div>
                        
                        {{-- Tombol Baca --}}
                        <a href="{{ route('artikel.showDetail', [$article->category->slug ?? 'berita', $article->slug]) }}" class="mt-auto text-[#1e462c] bg-[#1e462c]/5 hover:bg-[#1e462c] hover:text-white border border-[#1e462c]/20 text-[10px] md:text-sm font-bold flex items-center justify-center gap-2 py-2 md:py-2.5 rounded-lg transition-colors group/link">
                            Baca Berita <span class="transform group-hover/link:translate-x-1 transition-transform">→</span>
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-20 text-center">
                    <p class="text-gray-500 italic">Belum ada artikel yang tersedia.</p>
                </div>
                @endforelse
            </section>

        </div>
    </div>
</div>

<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    // Initialize Swiper (Tetap pakai logika yang sudah bagus milikmu)
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 1,      
        spaceBetween: 20,      
        loop: true,            
        autoplay: {
            delay: 4000, // Dipercepat dikit biar dinamis
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            768: {
                slidesPerView: 2,
                spaceBetween: 24, // Jarak disesuaikan
            },
        },
    });
</script>
@endsection