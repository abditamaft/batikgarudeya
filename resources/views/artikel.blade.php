@extends('layouts.main')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    .swiper-button-next, .swiper-button-prev {
        color: #4a0e0e !important;
        background: rgba(255, 255, 255, 0.8);
        width: 40px !important;
        height: 40px !important;
        border-radius: 50%;
    }
    .swiper-button-next:after, .swiper-button-prev:after {
        font-size: 18px !important;
        font-weight: bold;
    }
    .swiper-pagination-bullet-active {
        background: #4a0e0e !important;
    }
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
</style>

{{-- Inisialisasi Alpine.js State --}}
<div x-data="{ 
    searchQuery: '', 
    categoryFilter: 'semua' }">

    <section class="fixed top-0 left-0 w-full h-[45vh] md:h-[50vh] -z-10 bg-cover bg-center" style="background-image: url('/images/banner-katalog.png');">
        <div class="absolute inset-0 bg-black/40"></div> 
        <div class="absolute inset-0 flex items-center justify-center">
            <h1 class="text-6xl md:text-8xl font-caveat text-white drop-shadow-xl mt-12 scroll-anim fade-up">Garudeya Kidal</h1>
        </div>
    </section>

    <div class="relative z-10 mt-[35vh] md:mt-[40vh] bg-white pt-16 md:pt-24 pb-16 md:pb-24 rounded-t-3xl shadow-[0_-20px_60px_rgba(0,0,0,0.2)] overflow-hidden">
        <div class="max-w-6xl mx-auto px-5 md:px-10">
            <div class="text-center mb-12 md:mb-24 scroll-anim fade-up">
                <h1 class="text-6xl md:text-8xl font-handwriting text-black">Artikel</h1>
            </div>

            <div class="max-w-7xl mx-auto px-8 py-10">
                <!-- Artikel Terpopuler (Tetap menggunakan Swiper) -->
                <section class="mb-12">
                    <h2 class="text-3xl font-handwriting text-black italic mb-6">Artikel Terpopuler</h2>
                    <div class="swiper mySwiper rounded-xl overflow-hidden shadow-lg">
                        <div class="swiper-wrapper">
                            @forelse($viewTerbanyak as $populer)
                            <div class="swiper-slide px-1">
                                <div class="relative group overflow-hidden h-[350px]">
                                    <a href="{{ route('artikel.showDetail', [$populer->category->slug, $populer->slug]) }}">
                                        <img src="{{ asset('storage/'.$populer->thumbnail) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    </a>
                                    <div class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-black/90 via-black/40 to-transparent text-white">
                                        <a href="{{ route('artikel.showDetail', [$populer->category->slug, $populer->slug]) }}">
                                            <h3 class="text-lg md:text-xl font-medium leading-snug line-clamp-2">{{ $populer->title }}</h3>
                                        </a>
                                        <a href="{{ route('artikel.showDetail', [$populer->category->slug, $populer->slug]) }}" class="text-blue-400 text-sm mt-3 inline-block hover:underline font-semibold">
                                            Baca Selengkapnya...
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="swiper-slide py-20 text-center bg-gray-100 rounded-xl">
                                <p class="text-gray-500 italic">Tidak ada artikel terpopuler saat ini.</p>
                            </div>
                            @endforelse
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination !-bottom-1"></div>
                    </div>
                </section>

                <!-- Search & Filter Section (Show/Hide DOM) -->
                <section class="mb-10">
                    <h2 class="text-3xl font-handwriting text-black italic mb-6">Terbaru</h2>
                    <div class="flex flex-col md:flex-row justify-between gap-4">
                        
                        <!-- Client-side Category Filter -->
                        <div class="relative w-full md:w-64">
                            <select x-model="categoryFilter" 
                                    class="w-full bg-gray-200 border-none rounded-lg px-4 py-3 appearance-none focus:ring-2 focus:ring-maroon cursor-pointer">
                                <option value="semua">Semua Kategori</option>
                                @foreach($daftarKategori as $category)
                                    <option value="{{ $category->slug }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Client-side Search Input -->
                        <div class="relative flex-1 md:max-w-2xl">
                            <input type="text" 
                                   x-model="searchQuery" 
                                   placeholder="Cari judul artikel..." 
                                   class="w-full bg-gray-100 border border-gray-300 rounded-full px-6 py-3 focus:outline-none focus:ring-2 focus:ring-maroon transition-all">
                            <div class="absolute inset-y-0 right-4 flex items-center">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Article Grid with DOM Filtering -->
                <section class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                    @forelse($artikelWithSearchFilter as $article)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-all duration-300 transform hover:-translate-y-1 flex flex-col h-full"
                         x-show="(categoryFilter === 'semua' || categoryFilter === '{{ $article->category->slug }}') && 
                                 (searchQuery === '' || '{{ strtolower($article->title) }}'.includes(searchQuery.toLowerCase()))"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-90"
                         x-transition:enter-end="opacity-100 scale-100">
                        
                        <a href="{{ route('artikel.showDetail', [$article->category->slug, $article->slug]) }}">
                            <img src="{{ asset('storage/'.$article->thumbnail) }}" alt="{{ $article->title }}" class="w-full h-44 object-cover">
                        </a>
                        <div class="p-4 flex flex-col flex-grow">
                            <div class="flex items-center text-gray-400 text-xs mb-2">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $article->created_at->format('d M Y') }}
                            </div>
                            <h4 class="font-bold text-gray-800 text-sm line-clamp-2 mb-2">
                                {{ $article->title }}
                            </h4>
                            <div class="text-gray-500 text-xs line-clamp-3 leading-relaxed flex-grow">
                                {{ Str::limit(strip_tags($article->content), 130) }}
                            </div>
                            <a href="{{ route('artikel.showDetail', [$article->category->slug, $article->slug]) }}" class="text-blue-500 text-xs inline-block hover:underline font-medium italic mt-2">
                                ...Selengkapnya
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
</div>

<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    // Initialize Swiper
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 1,      
        spaceBetween: 20,      
        loop: true,            
        autoplay: {
            delay: 5000,         
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
                spaceBetween: 30,
            },
        },
    });
</script>
@endsection