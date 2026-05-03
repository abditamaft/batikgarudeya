@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    /* Import Font Caveat untuk Judul Berita Lainnya */
    @import url('https://fonts.googleapis.com/css2?family=Caveat:wght@700&display=swap');
    .font-caveat { font-family: 'Caveat', cursive; }

    /* 1. Perbaikan Navigasi Swiper Premium */
    .swiper-button-next, .swiper-button-prev {
        color: #4a0e0e !important;
        background: #ffffff;
        width: 44px !important;
        height: 44px !important;
        border-radius: 50%;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid #f3f4f6;
        transition: all 0.3s ease;
    }
    
    .swiper-button-next:hover, .swiper-button-prev:hover {
        background: #4a0e0e;
        color: #ffffff !important;
        transform: scale(1.1);
    }
    .swiper-button-next:after, .swiper-button-prev:after {
        font-size: 16px !important;
        font-weight: 900;
    }

    /* 2. Konsistensi Tinggi Card */
    .swiper-slide { height: auto !important; display: flex; }
    .article-card { display: flex; flex-direction: column; width: 100%; height: 100%; }

    /* 3. Rich Text Typography (Gaya Majalah Digital) */
    .content-rich-text p { margin-bottom: 1.25rem; line-height: 1.8; color: #374151; font-size: 1.125rem; text-align: justify; }
    .content-rich-text h2, .content-rich-text h3 { font-family: serif; color: #111827; font-weight: bold; margin-top: 2rem; margin-bottom: 1rem; line-height: 1.3;}
    .content-rich-text img { border-radius: 1rem; margin: 2rem auto; max-width: 100%; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); }
    .content-rich-text a { color: #4a0e0e; text-decoration: underline; font-weight: 600; text-underline-offset: 4px; }
    .content-rich-text blockquote { border-left: 4px solid #4a0e0e; padding-left: 1.5rem; font-style: italic; color: #4b5563; margin: 2rem 0; background: #fdf8f6; padding: 1rem 1.5rem; border-radius: 0 0.5rem 0.5rem 0;}
</style>

<div class="pb-24 min-h-screen bg-[#Faf7f2] relative z-10 overflow-hidden">
    {{-- Background Top Gelap --}}
    <div class="absolute top-0 left-0 w-full h-[75px] bg-[#421b19] z-0 shadow-md"></div>
    
    <div class="max-w-7xl mx-auto px-5 md:px-10 pt-[100px] relative z-10">
        
        {{-- WRAPPER ARTIKEL (Diperlebar menjadi max-w-5xl atau max-w-6xl agar proporsional) --}}
        <div class="max-w-5xl mx-auto">
            
            <!-- Tombol Kembali -->
            <div class="mb-6 scroll-anim fade-up">
                <a href="javascript:history.back()" class="inline-flex items-center text-gray-500 hover:text-[#4a0e0e] font-medium transition-all group">
                    <span class="w-8 h-8 rounded-sm bg-white shadow-sm border border-gray-200 flex items-center justify-center mr-3 group-hover:bg-[#4a0e0e] group-hover:text-white group-hover:border-[#4a0e0e] transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </span>
                    Kembali ke Daftar Artikel
                </a>
            </div>

            <!-- KONTEN UTAMA ARTIKEL (Kotak Tegas, Elegan, Lebar) -->
            {{-- REVISI: Mengubah rounded-3xl menjadi kotak (rounded-sm) dengan aksen garis atas (border-t-4) dan shadow yang lebih megah (shadow-2xl) --}}
            <article class="bg-white rounded-sm shadow-2xl shadow-black/10 border border-gray-100 border-t-4 border-t-[#4a0e0e] overflow-hidden mb-20 scroll-anim fade-up delay-100">
                
                <!-- Wrapper Gambar (Ditinggikan sedikit agar proporsional dengan lebarnya) -->
                <div class="relative h-[300px] md:h-[500px] overflow-hidden group">
                    <img src="{{ asset('storage/'.$artikel->thumbnail) }}" alt="{{ $artikel->title }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    
                    <!-- Meta Data di Atas Gambar -->
                    <div class="absolute bottom-6 left-6 md:bottom-10 md:left-12 flex items-center gap-3">
                        <span class="bg-[#4a0e0e] text-white px-4 py-2 rounded-sm text-xs font-bold uppercase tracking-widest shadow-md">
                            {{ $artikel->category->name ?? 'Artikel' }}
                        </span>
                        <span class="text-white/90 text-xs md:text-sm font-medium backdrop-blur-sm bg-black/30 px-4 py-2 rounded-sm border border-white/10">
                            📅 {{ $artikel->created_at->format('d M Y') }}
                        </span>
                    </div>
                </div>
                
                <!-- Area Teks Artikel -->
                <div class="p-8 md:p-12 lg:p-16">
                    
                    <!-- Judul Utama -->
                    <h1 class="text-4xl md:text-5xl font-serif font-bold text-gray-900 leading-tight mb-8 tracking-tight">
                        {{ $artikel->title }}
                    </h1>

                    <!-- Lead Paragraph (Kutipan Awal) -->
                    <div class="text-gray-600 text-xl font-serif italic border-l-4 border-[#4a0e0e] pl-6 mb-10 bg-gray-50 py-4 pr-6 rounded-r-sm shadow-inner">
                        {!! Str::words(strip_tags($artikel->content), 35) !!}...
                    </div>

                    <!-- Isi Artikel (Rich Text) -->
                    <div class="content-rich-text">
                        {!! $artikel->content !!}
                    </div>
                    
                </div>
            </article>
        </div> <!-- End Wrapper max-w-5xl --> <!-- End Wrapper max-w-4xl -->

        <!-- ========================================================= -->
        <!-- BAGIAN BERITA LAINNYA (Kembali ke lebar penuh max-w-7xl) -->
        <!-- ========================================================= -->
        <section class="relative border-t border-gray-200 pt-12 scroll-anim fade-up delay-200">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
                <div>
                    {{-- Font Caveat diterapkan di sini --}}
                    <h2 class="text-5xl md:text-6xl font-caveat text-[#4a0e0e] leading-none mb-1">Berita Lainnya</h2>
                    <p class="text-gray-500 text-sm md:text-base font-medium">Mungkin Anda juga tertarik membaca ini</p>
                </div>
                
                <!-- Navigasi Custom (Khusus Desktop) -->
                <div class="hidden md:flex gap-3">
                    <button class="swiper-prev-btn p-3 bg-white border border-gray-200 rounded-full text-[#4a0e0e] hover:bg-[#4a0e0e] hover:text-white shadow-sm transition-all transform hover:-translate-y-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button class="swiper-next-btn p-3 bg-white border border-gray-200 rounded-full text-[#4a0e0e] hover:bg-[#4a0e0e] hover:text-white shadow-sm transition-all transform hover:-translate-y-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </div>
            
            <div class="swiper swiperLainnya !pb-12">
                <div class="swiper-wrapper">
                    @forelse($artikelKategoriSama as $article)
                    <div class="swiper-slide">
                        <!-- Card Profesional -->
                        <div class="article-card bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-xl hover:border-gray-200 transition-all duration-300 group transform hover:-translate-y-1">
                            
                            <a href="{{ route('artikel.showDetail', [$article->category->slug, $article->slug]) }}" class="relative block h-48 md:h-52 overflow-hidden bg-gray-100">
                                <img src="{{ asset('storage/'.$article->thumbnail) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                <div class="absolute top-3 right-3">
                                    <span class="bg-white/95 backdrop-blur-sm text-[#4a0e0e] text-[10px] font-bold px-3 py-1.5 rounded uppercase shadow-sm">
                                        {{ $article->category->name }}
                                    </span>
                                </div>
                            </a>
                            
                            <!-- Padding dikurangi agar tidak kopong -->
                            <div class="p-5 flex flex-col flex-grow">
                                <span class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mb-2 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $article->created_at->format('d M Y') }}
                                </span>
                                
                                <h4 class="font-serif font-bold text-gray-900 text-lg leading-snug line-clamp-2 mb-3 group-hover:text-[#4a0e0e] transition-colors">
                                    {{ $article->title }}
                                </h4>
                
                                <div class="mt-auto pt-4 border-t border-gray-100">
                                    <a href="{{ route('artikel.showDetail', [$article->category->slug, $article->slug]) }}" class="text-[#4a0e0e] font-bold text-xs inline-flex items-center group/link hover:underline underline-offset-4">
                                        Baca Artikel
                                        <svg class="w-4 h-4 ml-1 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                        <p class="text-gray-500 text-center w-full italic py-10 bg-white rounded-2xl border border-gray-100">Tidak ada berita lainnya yang terkait.</p>
                    @endforelse
                </div>
                <div class="swiper-pagination md:hidden"></div>
            </div>
        </section>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    new Swiper(".swiperLainnya", {
        slidesPerView: 1,      
        spaceBetween: 20,      
        grabCursor: true,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".swiper-next-btn",
            prevEl: ".swiper-prev-btn",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            640: { slidesPerView: 2, spaceBetween: 24 },
            1024: { slidesPerView: 3, spaceBetween: 24 },
            1280: { slidesPerView: 4, spaceBetween: 24 }, /* Makin lebar, makin banyak cardnya biar proporsional */
        },
    });
</script>
@endsection