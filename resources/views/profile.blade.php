@extends('layouts.main')

@section('content')

{{-- Font Caveat untuk tulisan tangan judul Profil --}}
<style>
    @import url('https://fonts.googleapis.com/css2?family=Caveat:wght@700&display=swap');
    .font-handwriting { font-family: 'Caveat', cursive; }
</style>

{{-- ================================================================= --}}
{{-- 1. HARDCODED FIXED BATIK BANNER (Landscape Panjang di Belakang) --}}
{{-- Menggunakan banner-bg.jpg (atau ganti dengan gambar batikmu) --}}
{{-- ================================================================= --}}
<section class="fixed top-0 left-0 w-full h-[45vh] md:h-[50vh] -z-10 bg-cover bg-center" style="background-image: url('/images/banner-bg.png');">
    {{-- Overlay gelap agar menu header transparan warna putih tetap terbaca jelas --}}
    <div class="absolute inset-0 bg-black/40"></div> 
</section>

{{-- ================================================================= --}}
{{-- 2. KONTEN UTAMA (Meluncur ke atas menutupi banner) --}}
{{-- mt-[35vh] membuat konten ini mulai dari bawah banner --}}
{{-- ================================================================= --}}
<div class="relative z-10 mt-[35vh] md:mt-[40vh] bg-white pt-16 md:pt-24 pb-16 md:pb-24 rounded-t-3xl shadow-[0_-20px_60px_rgba(0,0,0,0.2)] overflow-hidden">
    <div class="max-w-6xl mx-auto px-5 md:px-10">
        
        {{-- JUDUL HALAMAN (Masive size) --}}
        <div class="text-center mb-12 md:mb-24 scroll-anim fade-up">
            <h1 class="text-6xl md:text-8xl font-handwriting text-black">Profil</h1>
        </div>

        @if($profile)
        {{-- ZIG-ZAG LAYOUT --}}
        {{-- parent grid: items-start agar kolom kiri kanan nggak panjangnya sama --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 lg:gap-x-16 gap-y-16 md:gap-y-32 mb-20 md:mb-32 items-start">
            
            {{-- KOLOM KIRI (Sejarah & Proses) --}}
            <div class="flex flex-col gap-10 md:gap-16 items-start">
                
                {{-- Teks Kiri Atas (Sejarah) --}}
                <div class="relative pt-8 scroll-anim slide-left delay-100">
                    <div class="absolute top-0 left-0 w-full h-[2px] bg-gradient-to-r from-brand-dark via-brand-dark/40 to-transparent"></div>
                    <div class="absolute -top-[9px] left-0 flex items-center gap-1.5">
                        <span class="text-brand-dark text-base leading-none">✦</span>
                        <span class="text-brand-dark/40 text-[8px] leading-none">✦</span>
                    </div>
                    
                    {{-- FONT MASIVE DI SINI: text-lg md:text-xl font-medium --}}
                    <p class="text-gray-700 leading-loose text-justify text-lg md:text-xl font-medium">
                        {!! nl2br(e($profile->text_top_left)) !!}
                    </p>
                </div>
                
                {{-- Container Alignment Gambar Kiri Bawah (Proses Membatik) --}}
                <div class="w-full flex justify-center md:justify-start scroll-anim slide-left delay-200">
                    {{-- ABSOLUT 4:3 fixed width on desktop [480px], responsive w-full on mobile --}}
                    <div class="relative w-full md:w-[480px] shadow-lg ..." style="aspect-ratio: 4/3;">
                        <img src="{{ asset('storage/' . $profile->image_bottom_left) }}" alt="Proses Produksi" class="w-full h-full object-cover">
                        
                        {{-- Overlay Box Biru Gelap (Info Pemilik) di-masive-kan juga textnya --}}
                        <div class="absolute bottom-0 right-0 w-4/5 md:w-[65%] bg-[#0a192f] text-white p-5 md:p-6 shadow-2xl group-hover:scale-105 transition-transform duration-300">
                            <p class="text-[10px] md:text-xs text-gray-400 tracking-widest uppercase mb-1 md:mb-2">PEMILIK</p>
                            <p class="font-bold text-lg md:text-xl mb-2 font-serif leading-tight">{{ $profile->owner_name ?? 'Ibuuuuuuuuu' }}</p>
                            <p class="text-sm md:text-base text-gray-300 italic font-serif prose line-clamp-2 md:line-clamp-none">"{{ $profile->owner_quote ?? 'Batik batik batik....' }}"</p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- KOLOM KANAN (Banner & Filosofi) --}}
            <div class="flex flex-col gap-10 md:gap-16 items-start">
                
                {{-- Container Alignment Gambar Kanan Atas (Banner Toko) --}}
                <div class="w-full flex justify-center md:justify-end scroll-anim slide-right delay-200 md:delay-100">
                    {{-- ABSOLUT 4:3 fixed width on desktop [480px], responsive w-full on mobile (Polaroid Style) --}}
                    <div class="p-2 md:p-3 bg-white border border-gray-200 shadow-xl transform hover:-translate-y-1 transition-transform duration-300 w-full md:w-[480px] h-auto">
                        <div class="relative w-full" style="aspect-ratio: 4/3;">
                            <img src="{{ asset('storage/' . $profile->image_top_right) }}" alt="Spanduk UMKM" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>

                {{-- Teks Kanan Bawah (Filosofi) --}}
                <div class="relative pb-6 scroll-anim slide-right delay-300 md:delay-200">
                    {{-- FONT MASIVE DI SINI: text-lg md:text-xl font-medium --}}
                    <p class="text-gray-700 leading-loose text-justify text-lg md:text-xl font-medium">
                        {!! nl2br(e($profile->text_bottom_right)) !!}
                    </p>
                    
                    <div class="absolute bottom-0 left-0 w-full h-[2px] bg-gradient-to-l from-brand-dark via-brand-dark/40 to-transparent"></div>
                    <div class="absolute bottom-0 right-0 translate-y-1/2 flex items-center gap-1.5">
                        <span class="text-brand-dark/40 text-[8px] leading-none">✦</span>
                        <span class="text-brand-dark text-base leading-none">✦</span>
                    </div>
                </div>

            </div>

        </div>

        {{-- SESUDAH: --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-0 items-stretch border border-gray-200 shadow-xl overflow-hidden">
            
            {{-- Card Visi --}}
            <div class="bg-[#f2efe9] p-8 md:p-14 flex flex-col scroll-anim fade-up delay-100 hover:bg-[#ebe7de] transition-colors duration-300 border-r border-gray-200 relative">
                {{-- Label kecil atas --}}
                <span class="text-[10px] tracking-[0.3em] uppercase text-brand-dark/50 font-bold mb-4">01</span>
                
                <h2 class="text-3xl md:text-4xl font-serif font-bold text-brand-dark mb-2 leading-none">Visi</h2>
                
                {{-- Garis aksen bawah judul --}}
                <div class="flex items-center gap-2 mb-8">
                    <div class="h-[3px] w-10 bg-brand-dark"></div>
                    <div class="h-[3px] w-2 bg-brand-dark/30"></div>
                </div>

                <p class="text-gray-800 text-lg md:text-xl leading-loose text-justify flex-grow font-medium">
                    {{ $profile->visi_text }}
                </p>

                {{-- Ornamen pojok kanan bawah --}}
                <div class="absolute bottom-6 right-8 text-brand-dark/10 text-6xl font-serif select-none leading-none">V</div>
            </div>

            {{-- Card Misi --}}
            <div class="bg-[#f2efe9] p-8 md:p-14 flex flex-col scroll-anim fade-up delay-200 hover:bg-[#ebe7de] transition-colors duration-300 relative">
                <span class="text-[10px] tracking-[0.3em] uppercase text-brand-dark/50 font-bold mb-4">02</span>

                <h2 class="text-3xl md:text-4xl font-serif font-bold text-brand-dark mb-2 leading-none">Misi</h2>

                <div class="flex items-center gap-2 mb-8">
                    <div class="h-[3px] w-10 bg-brand-dark"></div>
                    <div class="h-[3px] w-2 bg-brand-dark/30"></div>
                </div>

                <div class="text-gray-800 text-lg md:text-xl leading-loose space-y-4 flex-grow font-medium">
                    {!! nl2br(e($profile->misi_text)) !!}
                </div>

                <div class="absolute bottom-6 right-8 text-brand-dark/10 text-6xl font-serif select-none leading-none">M</div>
            </div>

        </div>

        </div>
        @else
            <p class="text-center text-gray-500 py-20 scroll-anim scale-in text-lg">Data profil belum diatur oleh Admin.</p>
        @endif

    </div>
</div>

@endsection