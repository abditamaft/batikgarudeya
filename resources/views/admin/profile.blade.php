@extends('admin.layouts.app')
@section('content')
<div class="mb-6 md:mb-8">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Kelola Profil UMKM</h1>
    <p class="text-gray-500 text-sm md:text-base">Sesuaikan deskripsi sejarah, foto, data pemilik, serta visi misi UMKM Batik Garudeya Kidal.</p>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl shadow-sm relative mb-6 flex items-center gap-3">
        <span class="text-xl">✅</span> <span class="font-medium">{{ session('success') }}</span>
    </div>
@endif

<form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
    @csrf
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 space-y-6">
            <h2 class="text-xl font-bold pb-4 border-b text-brand-dark flex items-center gap-2">
                <span>1. Konten Kiri & Pemilik</span>
            </h2>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Teks Sejarah & Lokasi</label>
                <textarea name="text_top_left" rows="5" class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-brand-green outline-none transition" placeholder="Tuliskan sejarah berdirinya UMKM di sini...">{{ $profile->text_top_left ?? '' }}</textarea>
            </div>

            <div>
                <div class="flex justify-between items-end mb-2">
                    <label class="text-sm font-semibold text-gray-700">Gambar Proses Membatik</label>
                    <span class="text-[10px] bg-brand-green/20 text-brand-green px-2 py-0.5 rounded font-bold uppercase tracking-wider">Rasio 4:3</span>
                </div>
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hover:border-brand-green transition bg-gray-50">
                    <img id="preview_left" src="{{ isset($profile) && $profile->image_bottom_left ? asset('storage/'.$profile->image_bottom_left) : 'https://via.placeholder.com/800x600?text=Rasio+4:3' }}" class="mx-auto h-32 md:h-40 w-auto object-cover rounded-lg mb-4 shadow-sm" style="aspect-ratio: 4/3;">
                    <label class="cursor-pointer bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-100 transition text-sm font-medium shadow-sm inline-block">
                        <span id="text_left">📸 Pilih Gambar Baru</span>
                        <input type="file" name="image_bottom_left" class="hidden" accept="image/*" onchange="previewImage(event, 'preview_left', 'text_left')">
                    </label>
                </div>
            </div>

            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                <h3 class="text-sm font-bold text-gray-700 mb-3 border-b pb-2">Data Box Pemilik (Kotak Biru)</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Pemilik</label>
                        <input type="text" name="owner_name" value="{{ $profile->owner_name ?? '' }}" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-brand-green outline-none transition" placeholder="Contoh: Ibu Siti...">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Quote Singkat Pemilik</label>
                        <input type="text" name="owner_quote" value="{{ $profile->owner_quote ?? '' }}" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-brand-green outline-none transition" placeholder="Contoh: Menjaga warisan budaya...">
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 space-y-6">
            <h2 class="text-xl font-bold pb-4 border-b text-brand-dark flex items-center gap-2">
                <span>2. Konten Kanan (Banner & Filosofi)</span>
            </h2>
            
            <div>
                <div class="flex justify-between items-end mb-2">
                    <label class="text-sm font-semibold text-gray-700">Gambar Banner Toko</label>
                    <span class="text-[10px] bg-brand-green/20 text-brand-green px-2 py-0.5 rounded font-bold uppercase tracking-wider">Rasio 4:3</span>
                </div>
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hover:border-brand-green transition bg-gray-50">
                    <img id="preview_right" src="{{ isset($profile) && $profile->image_top_right ? asset('storage/'.$profile->image_top_right) : 'https://via.placeholder.com/800x600?text=Rasio+4:3' }}" class="mx-auto h-32 md:h-40 w-auto object-cover rounded-lg mb-4 shadow-sm" style="aspect-ratio: 4/3;">
                    <label class="cursor-pointer bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-100 transition text-sm font-medium shadow-sm inline-block">
                        <span id="text_right">📸 Pilih Gambar Baru</span>
                        <input type="file" name="image_top_right" class="hidden" accept="image/*" onchange="previewImage(event, 'preview_right', 'text_right')">
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Teks Filosofi & Produksi</label>
                <textarea name="text_bottom_right" rows="5" class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-brand-green outline-none transition" placeholder="Tuliskan filosofi batik dan teknik produksinya...">{{ $profile->text_bottom_right ?? '' }}</textarea>
            </div>
        </div>

    </div>

    <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
            <h2 class="text-xl font-bold mb-4 text-brand-dark border-b pb-2">Pernyataan Visi</h2>
            <textarea name="visi_text" rows="5" class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-brand-green outline-none transition" placeholder="Tuliskan visi besar UMKM di sini...">{{ $profile->visi_text ?? '' }}</textarea>
        </div>
        <div>
            <h2 class="text-xl font-bold mb-4 text-brand-dark border-b pb-2">Pernyataan Misi</h2>
            <textarea name="misi_text" rows="5" class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-brand-green outline-none transition" placeholder="Gunakan tanda hubung (-) untuk list poin misi...">{{ $profile->misi_text ?? '' }}</textarea>
            <p class="text-xs text-gray-500 mt-2">Gunakan enter untuk memisahkan setiap poin.</p>
        </div>
    </div>

    <button type="submit" class="w-full bg-brand-green text-white px-6 py-4 rounded-xl font-bold text-lg hover:bg-green-800 transition shadow-lg flex justify-center items-center gap-2">
        <span>💾</span> Simpan Semua Perubahan Profil
    </button>
</form>

<script>
    function previewImage(event, previewId, textId) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(previewId).src = e.target.result;
                document.getElementById(textId).innerText = 'Ubah File: ' + file.name.substring(0, 20) + '...';
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection