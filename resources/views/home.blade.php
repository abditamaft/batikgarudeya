@extends('layouts.main')

@section('content')

<section class="fixed top-0 left-0 w-full h-screen -z-10 bg-cover bg-center" style="background-image: url('{{ $hero ? asset('storage/' . $hero->bg_image) : '/images/banner-bg.jpg' }}');">
    <div class="absolute inset-0 bg-black/40"></div> 
    <div class="h-full flex flex-col md:flex-row items-center justify-between px-6 md:px-20 pt-30">
        <div class="md:w-1/2 text-white scroll-anim slide-left">
            <h1 class="text-5xl md:text-7xl font-regular font-serif leading-tight italic drop-shadow-xl font-caveat">
                {!! $hero ? nl2br(e($hero->title_text)) : 'Keindahan Batik<br>Warisan Budaya<br>Indonesia' !!}
            </h1>
        </div>
        <div class="md:w-1/3 mt-10 md:mt-0 scroll-anim slide-right flex justify-center md:justify-end">
            <div class="relative w-full max-w-[400px] rounded-xl shadow-2xl border-4 border-white/20 overflow-hidden" style="aspect-ratio: 3/4;">
                <img src="{{ $hero ? asset('storage/' . $hero->card_image) : '/images/model-card.jpg' }}" 
                    alt="Model Batik" 
                    class="absolute inset-0 w-full h-full object-cover">
            </div>
        </div>
    </div>
</section>

{{-- Wrapper utama: rounded-top + menutup sampai footer --}}
<div class="relative z-10 mt-[100vh] bg-white pt-20 rounded-t-3xl shadow-[0_-10px_40px_rgba(0,0,0,0.1)]">

    {{-- ===== TENTANG KAMI ===== --}}
    <section class="about-section relative max-w-7xl mx-auto px-6 mb-32 pt-4">

        <div class="text-center mb-16 scroll-anim fade-up">
            <span class="inline-block text-xs font-bold tracking-[0.3em] uppercase text-brand-green/60 mb-3">Mengenal Lebih Dekat</span>
            <h2 class="text-5xl md:text-6xl font-serif font-regular text-brand-green italic leading-tight font-caveat">Tentang kami</h2>
            <div class="flex items-center justify-center gap-3 mt-5">
                <span class="h-px w-16 bg-brand-green/30"></span>
                <span class="text-brand-green text-xl">✦</span>
                <span class="h-px w-16 bg-brand-green/30"></span>
            </div>
        </div>

        @if($about)
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">

            {{-- Kolom Kiri --}}
            <div class="lg:col-span-5 flex flex-col gap-6 scroll-anim slide-left">

                {{-- Card Teks --}}
                <div class="relative bg-brand-green rounded-2xl p-8 md:p-10 text-white overflow-hidden shadow-2xl">
                    <div class="absolute -top-8 -right-8 w-40 h-40 rounded-full bg-white/5"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 rounded-full bg-white/5"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-white/20 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                            </div>
                            <h3 class="text-xl md:text-2xl font-bold font-serif">Batik Garudeya Kidal</h3>
                        </div>
                        <p class="text-white/85 leading-relaxed text-sm md:text-base text-justify">
                            {{ $about->text_top_left }}
                        </p>
                        <div class="grid grid-cols-3 gap-4 mt-8 pt-8 border-t border-white/20">
                            <div class="text-center">
                                <div class="text-2xl md:text-3xl font-bold font-serif">10+</div>
                                <div class="text-white/60 text-xs mt-1">Tahun Berdiri</div>
                            </div>
                            <div class="text-center border-x border-white/20">
                                <div class="text-2xl md:text-3xl font-bold font-serif">500+</div>
                                <div class="text-white/60 text-xs mt-1">Koleksi Motif</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl md:text-3xl font-bold font-serif">∞</div>
                                <div class="text-white/60 text-xs mt-1">Kecintaan Budaya</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Gambar Kiri — ratio 4:3 landscape --}}
                <div class="relative group overflow-hidden shadow-xl" style="aspect-ratio: 4/3;">
                    <img src="{{ asset('storage/' . $about->image_bottom_left) }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out"
                        alt="Proses membatik">
                    <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/60 to-transparent flex items-end p-5">
                        <span class="text-white text-sm font-medium tracking-wide opacity-90">✦ Proses pembuatan batik tulis</span>
                    </div>
                </div>
            </div>

            {{-- Divider Vertikal --}}
            <div class="hidden lg:flex lg:col-span-1 flex-col items-center justify-center gap-4 self-stretch">
                <div class="flex-1 w-px bg-gradient-to-b from-transparent via-brand-green/20 to-transparent"></div>
                <div class="w-8 h-8 border-2 border-brand-green/30 flex items-center justify-center">
                    <span class="text-brand-green text-xs">✦</span>
                </div>
                <div class="flex-1 w-px bg-gradient-to-b from-transparent via-brand-green/20 to-transparent"></div>
            </div>

            {{-- Kolom Kanan --}}
            <div class="lg:col-span-6 flex flex-col gap-6 scroll-anim slide-right">

                {{-- Gambar Kanan — ratio 1:1 --}}
                <div class="relative group overflow-hidden shadow-xl" style="aspect-ratio: 1/1;">
                    <img src="{{ asset('storage/' . $about->image_top_right) }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out"
                        alt="Logo Garudeya">
                    <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/40 to-transparent"></div>
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-4 py-2 shadow-lg flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-brand-green animate-pulse"></span>
                        <span class="text-brand-dark text-xs font-bold tracking-wide">Produk Asli Indonesia</span>
                    </div>
                </div>

                {{-- Quote Block --}}
                <div class="relative bg-amber-50 border border-amber-200/60 p-8 overflow-hidden">
                    <div class="absolute top-4 left-6 text-7xl font-serif text-amber-200 leading-none select-none">"</div>
                    <div class="relative z-10 pt-4">
                        <p class="text-gray-700 leading-relaxed text-sm md:text-base text-justify italic">
                            {{ $about->text_bottom_right }}
                        </p>
                    </div>
                    <div class="absolute bottom-2 right-6 text-7xl font-serif text-amber-200 leading-none select-none rotate-180">"</div>
                </div>

                {{-- CTA --}}
                <div class="flex justify-start">
                    <a href="{{ $about->visi_misi_button_link ?? '/profil' }}"
                        class="btn-slide group inline-flex items-center gap-3 bg-brand-green text-white px-8 py-4 rounded-lg hover:bg-brand-dark transition-all duration-300 shadow-lg hover:-translate-y-0.5">
                        <span class="font-semibold tracking-wide">Visi & Misi Kami</span>
                        <span class="w-8 h-8 bg-white/20 rounded-md flex items-center justify-center group-hover:bg-white group-hover:text-brand-green transition-all duration-300 text-sm font-bold">→</span>
                    </a>
                </div>
            </div>
        </div>
        @endif
    </section>

    {{-- ===== PRODUK UNGGULAN ===== --}}
    <section class="bg-gray-50 py-20">
        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center mb-4 scroll-anim fade-up">
                <h2 class="text-4xl md:text-5xl font-serif font-regular text-brand-green italic font-caveat">Produk unggulan</h2>
            </div>

            {{-- Grid Produk: 2 baris / 5 kolom sesuai referensi --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3 mb-12">
                @if(isset($products) && $products->count() > 0)
                    @foreach($products as $index => $product)
                        @php $delayClass = 'delay-' . (($index % 5) + 1) * 100; @endphp
                        <a href="{{ $webSettings->whatsapp_number ? 'https://wa.me/'.$webSettings->whatsapp_number.'?text=Halo,%20saya%20tertarik%20dengan%20produk%20'.$product->name : '#' }}"
                           target="_blank"
                           class="overflow-hidden shadow-md scroll-anim scale-in {{ $delayClass }} block group">
                            <div class="overflow-hidden" style="aspect-ratio: 3/4;">
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            </div>
                        </a>
                    @endforeach
                @else
                    <p class="col-span-5 text-center text-gray-400 py-10">Belum ada produk unggulan.</p>
                @endif
            </div>

            <p class="text-center text-gray-500 text-sm mb-8 scroll-anim fade-up">
                Koleksi pilihan terbaik kami yang menggabungkan keindahan motif tradisional dan gaya modern.
            </p>

            <div class="text-center scroll-anim fade-up">
                <a href="/produk"
                   class="btn-slide group inline-flex items-center gap-3 bg-brand-green text-white px-10 py-3 rounded-full hover:bg-brand-dark transition-all duration-300 shadow-md hover:-translate-y-0.5">
                    <span class="font-medium">Lihat produk</span>
                    <span class="w-7 h-7 bg-white text-brand-green rounded-full flex items-center justify-center text-sm font-bold group-hover:bg-brand-dark group-hover:text-white transition-all duration-300">→</span>
                </a>
            </div>
        </div>
    </section>

    {{-- ===== ARTIKEL ===== --}}
    <section class="max-w-7xl mx-auto px-6 py-20">
        <h2 class="text-4xl md:text-5xl font-serif font-regular mb-10 text-brand-green italic scroll-anim fade-up font-caveat">Artikel</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Artikel Terbaru --}}
            <div class="md:col-span-2 bg-gray-100 p-6 scroll-anim slide-left delay-100">
                @if(isset($latestArticles) && $latestArticles->count() > 0)
                    @foreach($latestArticles as $article)
                        <a href="/artikel/{{ $article->slug }}"
                           class="flex flex-col sm:flex-row gap-4 mb-5 pb-5 border-b border-gray-200 last:border-0 last:mb-0 last:pb-0 group hover:bg-gray-200 transition-colors p-2">
                            <div class="flex-shrink-0 overflow-hidden" style="width:120px; height:90px;">
                                <img src="{{ asset('storage/' . $article->thumbnail) }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                     alt="{{ $article->title }}">
                            </div>
                            <div class="flex flex-col justify-center">
                                <h3 class="font-bold text-sm md:text-base mb-1 group-hover:text-brand-green transition-colors leading-snug">{{ $article->title }}</h3>
                                <p class="text-xs text-gray-500 line-clamp-3 leading-relaxed">{{ Str::limit(strip_tags($article->content), 130) }}</p>
                            </div>
                        </a>
                    @endforeach
                    <div class="text-center mt-6">
                        <a href="/artikel" class="text-brand-green font-bold hover:underline text-sm">Selengkapnya ⋁</a>
                    </div>
                @else
                    <p class="text-center text-gray-400 py-10">Belum ada artikel terbaru.</p>
                @endif
            </div>

            {{-- Artikel Populer --}}
            <div class="bg-gray-100 p-6 scroll-anim slide-right delay-300">
                <h3 class="font-bold text-lg mb-5 text-center border-b border-gray-200 pb-4">Kamu pasti juga suka</h3>
                
                @if(isset($popularArticles) && $popularArticles->count() > 0)
                    @foreach($popularArticles as $index => $popular)
                        <a href="/artikel/{{ $popular->slug }}" class="relative mb-3 overflow-hidden group cursor-pointer block last:mb-0" style="height:120px;">
                            <img src="{{ asset('storage/' . $popular->thumbnail) }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                 alt="{{ $popular->title }}">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent flex flex-col justify-end p-3">
                                <span class="bg-white text-brand-dark text-xs font-bold w-5 h-5 flex items-center justify-center mb-1 shadow-lg text-center">{{ $index + 1 }}</span>
                                <h4 class="text-white text-xs font-bold line-clamp-2 leading-snug">{{ $popular->title }}</h4>
                            </div>
                        </a>
                    @endforeach
                @else
                    <p class="text-center text-gray-400">Belum ada artikel terpopuler.</p>
                @endif
            </div>
        </div>
    </section>

</div>{{-- END wrapper utama --}}

@endsection