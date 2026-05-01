@extends('layouts.main')

@section('content')

{{-- CDN Swiper CSS & Font Caveat --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<style>
    @import url('https://fonts.googleapis.com/css2?family=Caveat:wght@400;700&display=swap');
    .font-caveat { font-family: 'Caveat', cursive; }
    
    /* Styling Swiper Related Products (Disesuaikan untuk tema Terang) */
    .swiper-button-next, .swiper-button-prev {
        color: #1e462c !important; /* Warna panah hijau gelap */
        background: rgba(255, 255, 255, 0.9);
        width: 45px; height: 45px;
        border-radius: 50%;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
    }
    .swiper-button-next:hover, .swiper-button-prev:hover {
        background: #ffffff;
        transform: scale(1.05);
    }
    .swiper-button-next:after, .swiper-button-prev:after {
        font-size: 18px !important; font-weight: bold;
    }

    /* Accordion Animasi */
    .accordion-content {
        transition: max-height 0.4s ease-out, opacity 0.4s ease-out;
        max-height: 0;
        opacity: 0;
        overflow: hidden;
    }
    .accordion-content.open {
        max-height: 500px; 
        opacity: 1;
    }
    .accordion-icon {
        transition: transform 0.3s ease;
    }
    .accordion-icon.open {
        transform: rotate(180deg);
    }
</style>

{{-- BACKGROUND KREM / PUTIH TULANG KESELURUHAN (#Faf7f2) --}}
<div class="pb-24 min-h-screen bg-[#Faf7f2] relative z-10 selection:bg-brand-green selection:text-white">
    
    {{-- Kotak diset tingginya persis seukuran Header (75px) --}}
    <div class="absolute top-0 left-0 w-full h-[75px] bg-[#421b19] z-0 shadow-md border-b border-[#5c2a27]"></div>
    
    {{-- Padding top diset 100px agar ada jarak napas (sekitar 25px) antara garis header dan tulisan "Kembali ke Katalog" --}}
    <div class="max-w-7xl mx-auto px-6 md:px-12 pt-[100px] md:pt-[110px] relative z-10">
        
        {{-- Tombol Kembali --}}
        <a href="{{ route('produk.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-[#1e462c] mb-8 transition group font-medium">
            <span class="transform group-hover:-translate-x-1 transition-transform">←</span> Kembali ke Katalog
        </a>

        {{-- MAIN DETAIL WRAPPER --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 md:gap-16 items-start mb-20">
            
            {{-- KIRI: GALERI GAMBAR --}}
            <div class="w-full scroll-anim slide-right">
                {{-- Gambar Utama (Rasio 3:4) --}}
                <div class="w-full aspect-[3/4] bg-white rounded-xl overflow-hidden shadow-[0_10px_30px_rgba(0,0,0,0.08)] mb-4 border border-gray-100">
                    <img id="mainImage" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                </div>

                {{-- Thumbnail Tambahan (Max 3 + 1 Utama) --}}
                <div class="grid grid-cols-4 gap-3">
                    {{-- Thumb 1 (Cover) --}}
                    <div class="aspect-[3/4] rounded-lg overflow-hidden cursor-pointer border-2 border-brand-green opacity-100 transition-all thumb-item bg-white shadow-sm" onclick="changeImage('{{ asset('storage/' . $product->image) }}', this)">
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                    </div>
                    
                    {{-- Thumb Galeri --}}
                    @foreach($product->images as $img)
                        <div class="aspect-[3/4] rounded-lg overflow-hidden cursor-pointer border-2 border-transparent opacity-60 hover:opacity-100 transition-all thumb-item bg-white shadow-sm" onclick="changeImage('{{ asset('storage/' . $img->image) }}', this)">
                            <img src="{{ asset('storage/' . $img->image) }}" class="w-full h-full object-cover">
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- KANAN: INFORMASI PRODUK --}}
            <div class="w-full scroll-anim slide-left delay-100 pt-2 lg:pt-6">
                
                {{-- Judul & Bintang --}}
                <h1 class="text-4xl md:text-5xl font-serif font-bold text-gray-900 leading-tight mb-3">{{ $product->name }}</h1>
                
                <div class="flex items-center gap-2 mb-6">
                    <div class="flex text-yellow-500 text-xl">
                        @for($i=1; $i<=5; $i++)
                            @if($i <= $product->rating)
                                <span>★</span>
                            @elseif($i - 0.5 == $product->rating)
                                <span>⯨</span>
                            @else
                                <span class="text-gray-300">★</span>
                            @endif
                        @endfor
                    </div>
                    <span class="text-gray-500 text-sm mt-1 font-medium">({{ $product->rating }} / 5.0)</span>
                </div>

                {{-- Harga (Hijau Mateng) --}}
                <p class="text-3xl md:text-4xl font-serif text-[#1e462c] font-bold mb-8">Rp. {{ number_format($product->price, 0, ',', '.') }}</p>

                {{-- Spesifikasi Ukuran (Pill) --}}
                <div class="mb-8">
                    <span class="block text-sm text-gray-500 uppercase tracking-widest mb-3 font-semibold">Ukuran Kain</span>
                    <div class="inline-flex bg-white border border-gray-200 shadow-sm text-gray-800 px-6 py-2 rounded-full font-mono text-lg">
                        {{ $product->spec_length_width ?? '200 cm x 115 cm' }}
                    </div>
                </div>

                {{-- List Spesifikasi Lainnya --}}
                <div class="bg-white border border-gray-100 shadow-sm rounded-xl p-6 mb-8">
                    <h3 class="text-lg font-bold mb-4 font-serif italic text-brand-green">Spesifikasi Detail</h3>
                    <ul class="space-y-3 text-gray-700">
                        <li class="flex justify-between border-b border-gray-100 pb-2">
                            <span class="text-gray-500">Jenis</span>
                            <span class="font-medium text-right text-gray-900">{{ $product->spec_type ?? 'Batik Tulis' }}</span>
                        </li>
                        <li class="flex justify-between border-b border-gray-100 pb-2">
                            <span class="text-gray-500">Bahan</span>
                            <span class="font-medium text-right text-gray-900">{{ $product->spec_material ?? 'Katun Primissima' }}</span>
                        </li>
                        <li class="flex justify-between border-b border-gray-100 pb-2">
                            <span class="text-gray-500">Teknik</span>
                            <span class="font-medium text-right text-gray-900">{{ $product->spec_technique ?? 'Handmade (Canting)' }}</span>
                        </li>
                        <li class="flex justify-between pb-1">
                            <span class="text-gray-500">Asal</span>
                            <span class="font-medium text-right text-gray-900">{{ $product->spec_origin ?? 'Desa Kidal, Malang' }}</span>
                        </li>
                    </ul>
                </div>

                {{-- Tombol Pesan via WA --}}
                @php
                    $setting = \App\Models\WebSetting::first();
                    $waNumber = $setting ? preg_replace('/^0/', '62', $setting->whatsapp_number) : '628123456789';
                @endphp

                <a href="https://wa.me/{{ $waNumber }}?text=Halo%20Batik%20Garudeya,%20saya%20tertarik%20dan%20ingin%20memesan%20produk%20*{{ $product->name }}*" 
                   target="_blank" 
                   class="w-full flex justify-center items-center gap-3 bg-[#25D366] hover:bg-[#20ba5a] text-white text-xl font-bold py-4 rounded-xl transition-all duration-300 shadow-[0_10px_20px_rgba(37,211,102,0.2)] hover:shadow-[0_15px_30px_rgba(37,211,102,0.4)] hover:-translate-y-1 mb-8 border border-[#1da851] group">
                    <span>Pesan via WhatsApp</span>
                    <img src="{{ asset('images/icons/whatsapp.png') }}" class="w-7 h-7 group-hover:scale-110 transition-transform drop-shadow-sm" alt="WA">
                </a>

                {{-- Deskripsi Dropdown / Accordion --}}
                <div class="border-t border-gray-200 pt-2">
                    <button id="descToggle" class="w-full py-4 flex justify-between items-center text-left focus:outline-none group">
                        <span class="text-2xl font-serif italic text-gray-900 group-hover:text-brand-green transition-colors">Deskripsi Produk</span>
                        <svg class="w-6 h-6 text-gray-400 accordion-icon group-hover:text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="descContent" class="accordion-content">
                        <div class="pb-6 text-gray-600 leading-relaxed text-justify">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- ========================================================== --}}
        {{-- PRODUK SERUPA --}}
        {{-- ========================================================== --}}
        @if($relatedProducts->count() > 0)
        <div class="pt-16 border-t border-gray-200 scroll-anim fade-up delay-200">
            <h2 class="text-4xl md:text-5xl font-serif font-regular text-gray-900 italic leading-tight font-caveat mb-10 text-center">Produk Serupa</h2>
            
            <div class="relative px-2 md:px-10">
                <div class="swiper relatedSwiper !pb-10">
                    <div class="swiper-wrapper">
                        @foreach($relatedProducts->take(5) as $related)
                            <div class="swiper-slide">
                                <div class="group flex flex-col bg-white border border-gray-100 shadow-sm p-4 rounded-xl hover:shadow-lg transition-all duration-300 h-full">
                                    {{-- Gambar (Rasio 3:4) --}}
                                    <a href="{{ route('produk.show', $related->slug) }}" class="relative w-full aspect-[3/4] mb-4 overflow-hidden rounded-md bg-[#f8f8f8] block border border-gray-50">
                                        <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700">
                                    </a>
                                    
                                    {{-- Info Card Putih --}}
                                    <div class="flex-grow flex flex-col justify-between">
                                        <div>
                                            <a href="{{ route('produk.show', $related->slug) }}">
                                                <h3 class="text-gray-900 font-medium text-lg leading-tight mb-2 group-hover:text-brand-green transition-colors">{{ strtolower($related->name) }}</h3>
                                            </a>
                                            <p class="text-gray-600 mb-4 font-serif">Rp. {{ number_format($related->price, 0, ',', '.') }}</p>
                                        </div>
                                        
                                        <a href="{{ route('produk.show', $related->slug) }}" class="inline-flex items-center gap-2 text-sm font-medium text-[#1e462c] border border-[#1e462c]/30 bg-[#1e462c]/5 px-4 py-2 rounded-lg w-max hover:bg-[#1e462c] hover:text-white transition-colors">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                {{-- Panah Swiper --}}
                <div class="swiper-button-prev !-left-2 md:!-left-6"></div>
                <div class="swiper-button-next !-right-2 md:!-right-6"></div>
            </div>
        </div>
        @endif

    </div>
</div>

{{-- CDN Swiper JS --}}
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<script>
    // 1. Script Ganti Gambar Galeri
    function changeImage(src, element) {
        // Ganti source gambar utama
        document.getElementById('mainImage').src = src;
        
        // Reset semua style thumbnail
        document.querySelectorAll('.thumb-item').forEach(el => {
            el.classList.remove('border-brand-green', 'opacity-100');
            el.classList.add('border-transparent', 'opacity-60');
        });

        // Set style aktif untuk yang diklik
        element.classList.remove('border-transparent', 'opacity-60');
        element.classList.add('border-brand-green', 'opacity-100');
    }

    // 2. Script Accordion Deskripsi
    const descToggle = document.getElementById('descToggle');
    const descContent = document.getElementById('descContent');
    const accordionIcon = document.querySelector('.accordion-icon');

    // Buka secara default
    descContent.classList.add('open');
    accordionIcon.classList.add('open');

    descToggle.addEventListener('click', () => {
        descContent.classList.toggle('open');
        accordionIcon.classList.toggle('open');
    });

    // 3. Inisialisasi Swiper Produk Serupa
    const relatedSwiper = new Swiper('.relatedSwiper', {
        loop: true,
        loopedSlides: 4, // Cegah error mentok jika item sedikit
        spaceBetween: 20,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            // Mobile (1 card)
            320: { slidesPerView: 1.5, spaceBetween: 15 },
            // Tablet
            768: { slidesPerView: 3, spaceBetween: 20 },
            // Desktop (4 card sejajar)
            1024: { slidesPerView: 4, spaceBetween: 25 }
        }
    });
</script>

@endsection