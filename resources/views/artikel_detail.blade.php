@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    /* 1. Perbaikan Navigasi Swiper */
    .swiper-button-next, .swiper-button-prev {
        color: #fff !important;
        background: #4a0e0e;
        width: 48px !important;
        height: 48px !important;
        border-radius: 50%;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .swiper-button-next:hover, .swiper-button-prev:hover {
        background: #801b1b;
        transform: scale(1.1);
    }

    /* 2. Konsistensi Tinggi Card (PENTING) */
    .swiper-slide {
        height: auto !important; /* Biarkan swiper mengatur tinggi otomatis */
        display: flex;
    }
    
    .article-card {
        display: flex;
        flex-direction: column;
        width: 100%;
        height: 100%; /* Memaksa kartu memenuhi tinggi slide */
    }

    /* 3. Rich Text & Typography */
    .content-rich-text p { margin-bottom: 1.5rem; line-height: 1.8; }
    .content-rich-text img { border-radius: 1rem; margin: 2rem 0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
</style>

<div class="pb-24 min-h-screen bg-[#Faf7f2] relative z-10">
    <div class="absolute top-0 left-0 w-full h-[75px] bg-[#421b19] z-0 shadow-md"></div>
    
    <div class="max-w-7xl mx-auto px-6 md:px-12 pt-[100px] relative z-10">
        <div class="max-w-5xl mx-auto">
            
            <!-- Tombol Kembali -->
            <div class="mb-8">
                <a href="javascript:history.back()" class="inline-flex items-center bg-gray-200 text-gray-700 px-5 py-2 rounded-full text-sm font-medium hover:bg-gray-300 transition-all shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
            </div>


            <!-- Konten Utama yang Lebih "Enak Dilihat" -->
            <article class="bg-white rounded-[2rem] shadow-xl shadow-black/5 overflow-hidden mb-20">
                <!-- Wrapper Gambar dengan Overlay -->
                <div class="relative h-[300px] md:h-[550px] overflow-hidden">
                    <img src="{{ asset('storage/'.$artikel->thumbnail) }}" alt="{{ $artikel->title }}" class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    
                    <!-- Badge Kategori/Tanggal di atas gambar -->
                    <div class="absolute bottom-6 left-8 md:left-12">
                        <span class="bg-maroon text-white px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest shadow-lg">
                            {{ $artikel->category->name ?? 'Artikel' }}
                        </span>
                    </div>
                </div>
                
                <div class="p-8 md:p-16">
                    <div class="flex items-center text-gray-500 text-sm mb-6 font-medium">
                        <div class="w-8 h-[2px] bg-maroon mr-3"></div>
                        {{ $artikel->created_at->format('d F Y') }}
                    </div>

                    <h1 class="text-4xl md:text-6xl font-bold text-gray-900 leading-tight mb-10 tracking-tight">
                        {{ $artikel->title }}
                    </h1>

                    <div class="text-gray-700 text-lg md:text-xl content-rich-text italic border-l-4 border-maroon/20 pl-6 mb-10">
                        {!! Str::words(strip_tags($artikel->content), 30) !!}...
                    </div>

                    <div class="text-gray-800 leading-relaxed text-lg content-rich-text">
                        {!! $artikel->content !!}
                    </div>
                </div>
            </article>

            <!-- Bagian Berita Lainnya dengan Card Sama Besar -->
            <section class="relative">
                <div class="flex items-end justify-between mb-12">
                    <div>
                        <h2 class="text-4xl font-serif italic text-maroon leading-none">Berita Lainnya</h2>
                        <p class="text-gray-500 mt-2">Mungkin Anda juga tertarik membaca ini</p>
                    </div>
                    <!-- Navigasi Custom (Khusus Desktop) -->
                    <div class="hidden md:flex gap-3">
                        <button class="swiper-prev-btn p-3 bg-white border border-gray-100 rounded-full text-maroon hover:bg-maroon hover:text-white shadow-sm transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                        <button class="swiper-next-btn p-3 bg-white border border-gray-100 rounded-full text-maroon hover:bg-maroon hover:text-white shadow-sm transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                </div>
                
                <div class="swiper swiperLainnya !pb-16">
                    <div class="swiper-wrapper">
                        @forelse($artikelKategoriSama as $article)
                        <div class="swiper-slide">
                            <!-- Card dengan Flex-Col & H-Full untuk menyamakan tinggi -->
                            <div class="article-card bg-white rounded-3xl border border-gray-100 overflow-hidden hover:shadow-2xl hover:shadow-maroon/10 transition-all duration-500 group">
                                <a href="{{ route('artikel.showDetail', [$article->category->slug, $article->slug]) }}" class="relative block h-52 overflow-hidden">
                                    <img src="{{ asset('storage/'.$article->thumbnail) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                    <div class="absolute top-4 left-4">
                                        <span class="bg-white/90 backdrop-blur-sm text-maroon text-[10px] font-bold px-3 py-1 rounded-lg uppercase">
                                            {{ $article->category->name }}
                                        </span>
                                    </div>
                                </a>
                                
                                <div class="p-6 flex flex-col flex-grow">
                                    <span class="text-gray-400 text-[11px] font-bold uppercase tracking-widest mb-3">
                                        {{ $article->created_at->format('d M Y') }}
                                    </span>
                                    
                                    <h4 class="font-bold text-gray-900 text-lg line-clamp-2 mb-4 group-hover:text-maroon transition-colors leading-snug">
                                        {{ $article->title }}
                                    </h4>
                    
                                    <!-- mt-auto memaksa bagian bawah tetap di dasar card -->
                                    <div class="mt-auto pt-6 border-t border-gray-50 flex items-center justify-between">
                                        <a href="{{ route('artikel.showDetail', [$article->category->slug, $article->slug]) }}" class="text-maroon font-bold text-sm inline-flex items-center group/link">
                                            Baca Artikel
                                            <svg class="w-4 h-4 ml-2 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                            <p class="text-gray-500 text-center w-full">Tidak ada berita lainnya.</p>
                        @endforelse
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </section>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    new Swiper(".swiperLainnya", {
        slidesPerView: 1,      
        spaceBetween: 30,      
        grabCursor: true,
        centeredSlides: false,
        navigation: {
            nextEl: ".swiper-next-btn",
            prevEl: ".swiper-prev-btn",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            640: { slidesPerView: 2 },
            1024: { slidesPerView: 3 },
        },
    });
</script>
@endsection