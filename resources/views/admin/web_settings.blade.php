@extends('admin.layouts.app')
@section('content')
<div class="mb-6 md:mb-8">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Pengaturan Website</h1>
    <p class="text-gray-500 text-sm md:text-base">Kelola nama website, logo, nomor kontak, dan tautan sosial media di sini.</p>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl shadow-sm relative mb-6 flex items-center gap-3">
        <span class="text-xl">✅</span> <span class="font-medium">{{ session('success') }}</span>
    </div>
@endif

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
    @csrf
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 space-y-6">
            <h2 class="text-xl font-bold pb-4 border-b text-brand-dark">1. Identitas Website</h2>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Website (SEO / Title)</label>
                <input type="text" name="website_name" value="{{ $settings->website_name ?? 'Batik Garudeya Kidal' }}" class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-brand-green outline-none transition">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Logo Polinema</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-2 text-center hover:border-brand-green bg-gray-50 h-32 flex flex-col items-center justify-center">
                        <img id="preview_polinema" src="{{ isset($settings) && $settings->logo_polinema ? asset('storage/'.$settings->logo_polinema) : 'https://via.placeholder.com/150?text=Logo' }}" class="h-12 w-auto object-contain mb-2">
                        <label class="cursor-pointer bg-white border border-gray-300 text-gray-700 px-2 py-1 rounded text-[10px] font-medium shadow-sm">
                            <span id="text_polinema">Ganti Logo</span>
                            <input type="file" name="logo_polinema" class="hidden" accept="image/*" onchange="previewImage(event, 'preview_polinema', 'text_polinema')">
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Logo Batik Garudeya</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-2 text-center hover:border-brand-green bg-gray-50 h-32 flex flex-col items-center justify-center">
                        <img id="preview_umkm" src="{{ isset($settings) && $settings->logo_umkm ? asset('storage/'.$settings->logo_umkm) : 'https://via.placeholder.com/150?text=Logo' }}" class="h-12 w-auto object-contain mb-2">
                        <label class="cursor-pointer bg-white border border-gray-300 text-gray-700 px-2 py-1 rounded text-[10px] font-medium shadow-sm">
                            <span id="text_umkm">Ganti Logo</span>
                            <input type="file" name="logo_umkm" class="hidden" accept="image/*" onchange="previewImage(event, 'preview_umkm', 'text_umkm')">
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 space-y-6">
            <h2 class="text-xl font-bold pb-4 border-b text-brand-dark">2. Kontak & Alamat</h2>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">No. WhatsApp</label>
                    <input type="text" name="whatsapp_number" value="{{ $settings->whatsapp_number ?? '' }}" placeholder="62812xxx" class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-brand-green outline-none transition">
                    <p class="text-[10px] text-gray-500 mt-1">Gunakan awalan 62 tanpa spasi/plus.</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email UMKM</label>
                    <input type="email" name="email" value="{{ $settings->email ?? '' }}" placeholder="email@gmail.com" class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-brand-green outline-none transition">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Pesan Otomatis WhatsApp</label>
                <input type="text" name="whatsapp_message" value="{{ $settings->whatsapp_message ?? '' }}" placeholder="Halo, saya ingin bertanya..." class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-brand-green outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Lengkap</label>
                <textarea name="address" rows="2" class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-brand-green outline-none transition">{{ $settings->address ?? '' }}</textarea>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 space-y-4">
            <h2 class="text-xl font-bold pb-4 border-b text-brand-dark">3. Peta Interaktif (Google Maps)</h2>
            <p class="text-xs text-gray-500 mb-2">Buka Google Maps > Cari Lokasi > Bagikan > Sematkan Peta > Salin tag <code class="bg-gray-200 px-1 rounded">&lt;iframe&gt;</code>.</p>
            <textarea name="maps_iframe" rows="6" class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-brand-green outline-none transition font-mono text-sm" placeholder="<iframe src='...'></iframe>">{{ $settings->maps_iframe ?? '' }}</textarea>
        </div>

        <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 space-y-4">
            <h2 class="text-xl font-bold pb-4 border-b text-brand-dark">4. Tautan Sosial Media</h2>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Link Instagram</label>
                <input type="text" name="instagram_url" value="{{ $settings->instagram_url ?? '' }}" placeholder="https://instagram.com/..." class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-brand-green outline-none transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Link Facebook</label>
                <input type="text" name="facebook_url" value="{{ $settings->facebook_url ?? '' }}" placeholder="https://facebook.com/..." class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-brand-green outline-none transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Link TikTok</label>
                <input type="text" name="tiktok_url" value="{{ $settings->tiktok_url ?? '' }}" placeholder="https://tiktok.com/@..." class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-brand-green outline-none transition">
            </div>
        </div>

    </div>

    <button type="submit" class="w-full bg-brand-green text-white px-6 py-4 rounded-xl font-bold text-lg hover:bg-green-800 transition shadow-lg flex justify-center items-center gap-2">
        <span>💾</span> Simpan Pengaturan Website
    </button>
</form>

<script>
    function previewImage(event, previewId, textId) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(previewId).src = e.target.result;
                document.getElementById(textId).innerText = 'Ubah File';
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection