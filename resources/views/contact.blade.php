@extends('layouts.main')

@section('content')

{{-- Font Caveat untuk tulisan tangan judul --}}
<style>
    @import url('https://fonts.googleapis.com/css2?family=Caveat:wght@700&display=swap');
    .font-handwriting { font-family: 'Caveat', cursive; }
    
    /* Memaksa iframe Google Maps agar selalu penuh mengikuti container */
    .map-container iframe {
        width: 100% !important;
        height: 100% !important;
        border: none !important;
    }
</style>

{{-- ================================================================= --}}
{{-- 1. HARDCODED FIXED BATIK BANNER (Landscape Panjang di Belakang) --}}
{{-- ================================================================= --}}
<section class="fixed top-0 left-0 w-full h-[45vh] md:h-[50vh] -z-10 bg-cover bg-center" style="background-image: url('/images/banner-kontak.png');">
    {{-- Overlay gelap agar menu header tetap terbaca --}}
    <div class="absolute inset-0 bg-black/50"></div> 
</section>

{{-- ================================================================= --}}
{{-- 2. KONTEN UTAMA (Meluncur ke atas menutupi banner) --}}
{{-- ================================================================= --}}
<div class="relative z-10 mt-[35vh] md:mt-[40vh] bg-white pt-16 md:pt-24 pb-20 md:pb-32 rounded-t-3xl shadow-[0_-20px_60px_rgba(0,0,0,0.2)] overflow-hidden">
    <div class="max-w-6xl mx-auto px-5 md:px-10">
        
        {{-- JUDUL HALAMAN (Masive size) --}}
        <div class="text-center mb-16 md:mb-24 scroll-anim fade-up">
            <span class="inline-block text-xs md:text-sm font-bold tracking-[0.3em] uppercase text-brand-green/60 mb-4">Sapa Kami</span>
            <h1 class="text-6xl md:text-8xl font-handwriting text-black leading-none">Hubungi Kami</h1>
            <div class="flex items-center justify-center gap-3 mt-6">
                <span class="h-px w-16 bg-gray-300"></span>
                <span class="text-gray-400 text-xl">✦</span>
                <span class="h-px w-16 bg-gray-300"></span>
            </div>
        </div>

        {{-- SPLIT 2 KOLOM --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-20 items-start">
            
            {{-- KOLOM KIRI (Informasi & Sosmed & Tombol CTA) --}}
            <div class="flex flex-col gap-12 scroll-anim slide-left delay-100">
                
                {{-- Teks Pengantar --}}
                <p class="text-gray-700 leading-loose text-lg md:text-xl font-medium text-justify">
                    Kami selalu terbuka untuk berdiskusi, menerima pesanan khusus, atau sekadar berbincang tentang keindahan warisan budaya Batik. Silakan hubungi kami melalui informasi di bawah ini atau kunjungi langsung galeri kami di Desa Kidal.
                </p>

                {{-- List Informasi Kontak --}}
                <div class="flex flex-col gap-8">
                    {{-- Alamat --}}
                    <div class="flex items-start gap-5 group">
                        {{-- REVISI: Awal bg-brand-green, hover bg-red-600 --}}
                        <div class="w-14 h-14 rounded-full bg-brand-green flex items-center justify-center flex-shrink-0 group-hover:bg-brand-dark transition-colors duration-300 shadow-md">
                            {{-- REVISI: Gambar diinvert dari awal (putih) --}}
                            <img src="/images/icons/location.png" alt="Lokasi" class="w-6 h-6 object-contain brightness-0 invert transition-all">
                        </div>
                        <div class="pt-1">
                            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-1">Alamat Galeri</h3>
                            <p class="text-lg md:text-xl font-semibold text-brand-dark leading-snug">
                                {{ $settings->address ?? 'Jl. Karawitan RT 10/RW 01, Desa Kidal, Kec. Tumpang, Kabupaten Malang, Jawa Timur' }}
                            </p>
                        </div>
                    </div>

                    {{-- Telepon --}}
                    <div class="flex items-center gap-5 group">
                        {{-- REVISI: Awal bg-brand-green, hover bg-red-600 --}}
                        <div class="w-14 h-14 rounded-full bg-brand-green flex items-center justify-center flex-shrink-0 group-hover:bg-brand-dark transition-colors duration-300 shadow-md">
                            <img src="/images/icons/phone.png" alt="Telepon" class="w-6 h-6 object-contain brightness-0 invert transition-all">
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-1">WhatsApp / Telepon</h3>
                            <p class="text-lg md:text-xl font-semibold text-brand-dark">
                                {{ $settings->whatsapp_number ?? '08123456789' }}
                            </p>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="flex items-center gap-5 group">
                        {{-- REVISI: Awal bg-brand-green, hover bg-red-600 --}}
                        <div class="w-14 h-14 rounded-full bg-brand-green flex items-center justify-center flex-shrink-0 group-hover:bg-brand-dark transition-colors duration-300 shadow-md">
                            <img src="/images/icons/email.png" alt="Email" class="w-6 h-6 object-contain brightness-0 invert transition-all">
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-1">Email Surel</h3>
                            <p class="text-lg md:text-xl font-semibold text-brand-dark">
                                {{ $settings->email ?? 'Garudeya@gmail.com' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Sosial Media Row --}}
                <div class="pt-6 border-t border-gray-200">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-6">Ikuti Kami</h3>
                    <div class="flex items-center gap-6">
                        <a href="{{ $settings->instagram_url ?? '#' }}" target="_blank" class="w-12 h-12 rounded-full border border-gray-300 flex items-center justify-center hover:border-brand-green hover:shadow-lg transform hover:-translate-y-1 transition-all">
                            <img src="/images/icons/instagram.png" alt="Instagram" class="w-5 h-5 object-contain">
                        </a>
                        <a href="{{ $settings->facebook_url ?? '#' }}" target="_blank" class="w-12 h-12 rounded-full border border-gray-300 flex items-center justify-center hover:border-brand-green hover:shadow-lg transform hover:-translate-y-1 transition-all">
                            <img src="/images/icons/facebook.png" alt="Facebook" class="w-5 h-5 object-contain">
                        </a>
                        <a href="{{ $settings->tiktok_url ?? '#' }}" target="_blank" class="w-12 h-12 rounded-full border border-gray-300 flex items-center justify-center hover:border-brand-green hover:shadow-lg transform hover:-translate-y-1 transition-all">
                            <img src="/images/icons/tiktok.png" alt="TikTok" class="w-5 h-5 object-contain">
                        </a>
                    </div>
                </div>

                {{-- Tombol CTA WhatsApp --}}
                <div class="pt-4">
                    <a href="https://wa.me/{{ $settings->whatsapp_number ?? '628123456789' }}?text={{ urlencode($settings->whatsapp_message ?? 'Halo Batik Garudeya, saya ingin bertanya tentang produk batik.') }}" 
                       target="_blank" 
                       class="inline-flex items-center justify-center gap-4 bg-[#25D366] hover:bg-[#20ba5a] text-white px-10 py-5 rounded-full font-bold text-lg md:text-xl shadow-[0_10px_20px_rgba(37,211,102,0.3)] hover:shadow-[0_15px_30px_rgba(37,211,102,0.4)] transform hover:-translate-y-1 transition-all duration-300 group w-full sm:w-auto">
                        <span>Mulai Obrolan di WhatsApp</span>
                        <img src="/images/icons/whatsapp.png" alt="WhatsApp" class="w-7 h-7 object-contain group-hover:scale-110 transition-transform">
                    </a>
                </div>

            </div>

            {{-- KOLOM KANAN (Google Maps Interaktif) --}}
            <div class="scroll-anim slide-right delay-200">
                <div class="bg-[#f2efe9] p-4 md:p-6 rounded-3xl shadow-xl border border-gray-100 h-full flex flex-col">
                    <div class="flex items-center justify-between mb-6 px-2">
                        <h2 class="text-2xl font-serif font-bold text-brand-dark">Peta Lokasi</h2>
                        <span class="px-3 py-1 bg-white text-brand-dark text-xs font-bold rounded-full shadow-sm">📍 Desa Kidal</span>
                    </div>
                    
                    {{-- Container Peta dengan rounded & shadow dalam --}}
                    <div class="map-container flex-grow w-full h-[400px] lg:h-[600px] rounded-2xl overflow-hidden shadow-inner border-4 border-white bg-gray-200">
                        @if(!empty($settings->maps_iframe))
                            {!! $settings->maps_iframe !!}
                        @else
                            {{-- Placeholder Peta jika iframe belum diisi --}}
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3951.050630650965!2d112.7093246!3d-7.9937172!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd62f001c238b1d%3A0xc3f1b40212f48f4!2sDesa%20Kidal%2C%20Kec.%20Tumpang%2C%20Kabupaten%20Malang%2C%20Jawa%20Timur!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        @endif
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

@endsection