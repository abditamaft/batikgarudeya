@extends('admin.layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Kelola Landing Page</h1>
    <p class="text-gray-500">Ubah tampilan gambar dan teks pada halaman beranda utama di sini.</p>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-sm relative mb-6 flex items-center gap-3">
        <span class="text-xl">✅</span> {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <h2 class="text-xl font-bold mb-6 pb-4 border-b text-brand-dark">1. Hero Banner (Bagian Atas)</h2>
        
        <form action="{{ route('admin.landing.hero') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Teks Banner Utama</label>
                <textarea name="title_text" rows="3" class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-brand-green focus:border-brand-green outline-none transition">{{ $hero->title_text ?? '' }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin menampilkan teks. Gunakan Enter untuk baris baru.</p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Background Banner</label>
                <span class="text-[13px] bg-gray-200 text-gray-600 px-2 py-0.5 rounded font-bold uppercase">Masukkan Gambar Rasio 16:9</span>
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hover:border-brand-green transition bg-gray-50 group">
                    <img id="preview_bg" src="{{ isset($hero) && $hero->bg_image ? asset('storage/'.$hero->bg_image) : 'https://via.placeholder.com/600x300?text=Belum+Ada+Gambar' }}" class="mx-auto h-40 w-full object-cover rounded-lg mb-4 shadow-sm">
                    
                    <label class="cursor-pointer bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-100 transition text-sm font-medium shadow-sm inline-block">
                        <span id="text_bg">📸 Pilih Gambar Baru</span>
                        <input type="file" name="bg_image" class="hidden" accept="image/*" onchange="previewImage(event, 'preview_bg', 'text_bg')">
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Model (Card Kanan)</label>
                <span class="text-[13px] bg-gray-200 text-gray-600 px-2 py-0.5 rounded font-bold uppercase">Masukkan Gambar Rasio 3:4</span>
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hover:border-brand-green transition bg-gray-50">
                    <img id="preview_card" src="{{ isset($hero) && $hero->card_image ? asset('storage/'.$hero->card_image) : 'https://via.placeholder.com/300x400?text=Belum+Ada+Gambar' }}" class="mx-auto h-40 w-auto object-cover rounded-lg mb-4 shadow-sm">
                    
                    <label class="cursor-pointer bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-100 transition text-sm font-medium shadow-sm inline-block">
                        <span id="text_card">📸 Pilih Gambar Baru</span>
                        <input type="file" name="card_image" class="hidden" accept="image/*" onchange="previewImage(event, 'preview_card', 'text_card')">
                    </label>
                </div>
            </div>

            <button type="submit" class="w-full bg-brand-green text-white px-6 py-3 rounded-xl font-bold hover:bg-green-800 transition shadow-md">💾 Simpan Banner Utama</button>
        </form>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <h2 class="text-xl font-bold mb-6 pb-4 border-b text-brand-dark">2. Tentang Kami</h2>
        
        <form action="{{ route('admin.landing.about') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Teks (Kiri Atas)</label>
                <textarea name="text_top_left" rows="3" class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-brand-green outline-none transition">{{ $about->text_top_left ?? '' }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar (Kiri Bawah) - Proses Batik</label>
                <span class="text-[13px] bg-gray-200 text-gray-600 px-2 py-0.5 rounded font-bold uppercase">Masukkan Gambar Rasio 4:3</span>
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hover:border-brand-green transition bg-gray-50">
                    <img id="preview_about_1" src="{{ isset($about) && $about->image_bottom_left ? asset('storage/'.$about->image_bottom_left) : 'https://via.placeholder.com/400x300?text=Belum+Ada+Gambar' }}" class="mx-auto h-32 w-auto object-cover rounded-lg mb-4 shadow-sm">
                    
                    <label class="cursor-pointer bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-100 transition text-sm font-medium shadow-sm inline-block">
                        <span id="text_about_1">📸 Pilih Gambar Baru</span>
                        <input type="file" name="image_bottom_left" class="hidden" accept="image/*" onchange="previewImage(event, 'preview_about_1', 'text_about_1')">
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar (Kanan Atas) - Logo</label>
                <span class="text-[13px] bg-gray-200 text-gray-600 px-2 py-0.5 rounded font-bold uppercase">Masukkan Gambar Rasio 1:1</span>
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hover:border-brand-green transition bg-gray-50">
                    <img id="preview_about_2" src="{{ isset($about) && $about->image_top_right ? asset('storage/'.$about->image_top_right) : 'https://via.placeholder.com/400x300?text=Belum+Ada+Gambar' }}" class="mx-auto h-32 w-auto object-cover rounded-lg mb-4 shadow-sm">
                    
                    <label class="cursor-pointer bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-100 transition text-sm font-medium shadow-sm inline-block">
                        <span id="text_about_2">📸 Pilih Gambar Baru</span>
                        <input type="file" name="image_top_right" class="hidden" accept="image/*" onchange="previewImage(event, 'preview_about_2', 'text_about_2')">
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Teks (Kanan Bawah)</label>
                <textarea name="text_bottom_right" rows="3" class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-brand-green outline-none transition">{{ $about->text_bottom_right ?? '' }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Link Tujuan Tombol Visi Misi</label>
                <input type="text" name="visi_misi_button_link" value="{{ $about->visi_misi_button_link ?? '' }}" class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-brand-green outline-none transition">
            </div>

            <button type="submit" class="w-full bg-brand-green text-white px-6 py-3 rounded-xl font-bold hover:bg-green-800 transition shadow-md">💾 Simpan Tentang Kami</button>
        </form>
    </div>
</div>

<script>
    function previewImage(event, previewId, textId) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Ubah src gambar ke file yang baru dipilih
                document.getElementById(previewId).src = e.target.result;
                // Ubah teks tombol
                document.getElementById(textId).innerText = 'Ubah File: ' + file.name.substring(0, 20) + '...';
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection