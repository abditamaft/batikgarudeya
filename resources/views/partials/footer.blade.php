<footer class="bg-brand-dark text-white py-12 px-6 md:px-12 relative z-20">
    <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
        <div class="flex flex-col gap-4">
            <h3 class="text-xl font-bold">Hubungi Kami</h3>
            <div class="flex items-center gap-3">
                <img src="{{ !empty($webSettings->logo_umkm) ? asset('storage/'.$webSettings->logo_umkm) : '/images/logo-garudeya.jpeg' }}" alt="Logo" class="h-12 w-12 bg-white rounded-full p-1 object-cover">
                <h4 class="font-semibold text-lg">{{ $webSettings->website_name ?? 'Batik Garudeya Kidal' }}</h4>
            </div>
            <p class="text-sm text-gray-300">Kami siap membantu Anda. Silakan hubungi kami melalui informasi di bawah.</p>
        </div>

        <div class="flex flex-col gap-3">
            <h3 class="text-lg font-semibold mb-2">Menu</h3>
            <a href="/" class="text-gray-300 hover:text-white transition">Dashboard</a>
            <a href="/profil" class="text-gray-300 hover:text-white transition">Profil</a>
            <a href="/produk" class="text-gray-300 hover:text-white transition">Produk</a>
            <a href="/artikel" class="text-gray-300 hover:text-white transition">Artikel</a>
        </div>

        <div class="flex flex-col gap-4"> {{-- Gap 4 agar jarak antar baris konsisten --}}
            <h3 class="text-lg font-semibold mb-2 text-white">Informasi</h3>
            
            {{-- Lokasi --}}
            <div class="flex items-start gap-3 text-gray-300">
                <img src="/images/icons/location.png" alt="Location" class="w-5 h-5 object-contain mt-0.5">
                <span class="text-sm md:text-base leading-snug">{{ $webSettings->address ?? 'Jl. Karawitan RT 10/RW 01, Desa Kidal, Tumpang, Malang' }}</span>
            </div>

            {{-- Telepon/WA --}}
            <div class="flex items-center gap-3 text-gray-300">
                <img src="/images/icons/phone.png" alt="Phone" class="w-5 h-5 object-contain">
                <span class="text-sm md:text-base leading-none">{{ $webSettings->whatsapp_number ?? '08123456789' }}</span>
            </div>

            {{-- Email --}}
            <div class="flex items-center gap-3 text-gray-300">
                <img src="/images/icons/email.png" alt="Email" class="w-5 h-5 object-contain">
                <span class="text-sm md:text-base leading-none">{{ $webSettings->email ?? 'Garudeya@gmail.com' }}</span>
            </div>
        </div>

        <div class="flex flex-col gap-4"> {{-- Gap antar baris ditingkatkan jadi 4 agar tidak berdempetan --}}
            <h3 class="text-lg font-semibold mb-2">Sosial Media</h3>
            
            {{-- Instagram --}}
            <a href="{{ $webSettings->instagram_url ?? '#' }}" target="_blank" class="flex items-center gap-3 text-gray-300 hover:text-white transition group">
                <img src="/images/icons/instagram.png" alt="Instagram" class="w-7 h-7 object-contain transition-transform group-hover:scale-110">
                <span class="leading-none">Instagram</span>
            </a>

            {{-- Facebook --}}
            <a href="{{ $webSettings->facebook_url ?? '#' }}" target="_blank" class="flex items-center gap-3 text-gray-300 hover:text-white transition group">
                <img src="/images/icons/facebook.png" alt="Facebook" class="w-7 h-7 object-contain transition-transform group-hover:scale-110">
                <span class="leading-none">Facebook</span>
            </a>

            {{-- TikTok --}}
            <a href="{{ $webSettings->tiktok_url ?? '#' }}" target="_blank" class="flex items-center gap-3 text-gray-300 hover:text-white transition group">
                <img src="/images/icons/tiktok.png" alt="TikTok" class="w-7 h-7 object-contain transition-transform group-hover:scale-110">
                <span class="leading-none">TikTok</span>
            </a>
        </div>
    </div>
</footer>