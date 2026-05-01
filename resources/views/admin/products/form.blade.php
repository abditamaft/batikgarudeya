@extends('admin.layouts.app')

@section('content')
<div class="mb-6 flex items-center gap-4">
    <a href="{{ route('admin.produk.index') }}" class="w-10 h-10 bg-white border border-gray-200 rounded-full flex items-center justify-center text-gray-600 hover:bg-gray-50 transition shadow-sm">
        ←
    </a>
    <div>
        <h1 class="text-2xl font-bold text-gray-800">{{ isset($product) ? 'Edit Produk' : 'Tambah Produk Baru' }}</h1>
    </div>
</div>

<form action="{{ isset($product) ? route('admin.produk.update', $product->id) : route('admin.produk.store') }}" method="POST" enctype="multipart/form-data" class="max-w-6xl">
    @csrf
    @if(isset($product)) @method('PUT') @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- KOLOM KIRI: INFO UTAMA --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Informasi Utama</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Batik</label>
                        <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-brand-green outline-none">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori</label>
                            <select name="category_id" required class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-brand-green outline-none">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ (old('category_id', $product->category_id ?? '') == $cat->id) ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Harga (Rp)</label>
                            <input type="number" name="price" value="{{ old('price', $product->price ?? '') }}" required class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-brand-green outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Lengkap</label>
                        <textarea name="description" rows="6" required class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-brand-green outline-none">{{ old('description', $product->description ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- KOLOM KIRI BAWAH: GAMBAR --}}
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Manajemen Gambar</h3>
                
                {{-- Peringatan Rasio Gambar --}}
                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-5 rounded-r-lg">
                    <p class="text-sm text-yellow-800">
                        <strong>PENTING:</strong> Agar tata letak katalog rapi, WAJIB gunakan gambar dengan rasio <strong>3:4 (Portrait/Berdiri)</strong>. Rekomendasi ukuran: <strong>600x800 px</strong> atau <strong>900x1200 px</strong>.
                    </p>
                </div>

                <div class="space-y-5">
                    {{-- Gambar Utama --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Utama (Cover) *</label>
                        <input type="file" name="image" accept="image/*" class="w-full border border-gray-300 rounded-lg p-2" {{ isset($product) ? '' : 'required' }}>
                        @if(isset($product) && $product->image)
                            <img src="{{ asset('storage/'.$product->image) }}" class="mt-2 h-32 rounded border shadow-sm">
                        @endif
                    </div>

                    <hr class="border-dashed">

                    {{-- Gambar Galeri Tambahan --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Tambahan Galeri (Max 3 Foto)</label>
                        <input type="file" name="gallery[]" multiple accept="image/*" class="w-full border border-gray-300 rounded-lg p-2">
                        <p class="text-xs text-gray-500 mt-1">Bisa pilih lebih dari 1 file sekaligus. (Mengunggah foto baru akan menimpa galeri lama).</p>
                        
                        @if(isset($product) && $product->images->count() > 0)
                            <div class="flex gap-2 mt-3">
                                @foreach($product->images as $img)
                                    <img src="{{ asset('storage/'.$img->image) }}" class="h-24 w-20 object-cover rounded border shadow-sm">
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: SPESIFIKASI --}}
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Spesifikasi Detail</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Rating Bintang (1.0 - 5.0)</label>
                        <input type="number" step="0.1" max="5" name="rating" value="{{ old('rating', $product->rating ?? '5.0') }}" class="w-full border border-gray-300 rounded-lg p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Ukuran (P x L)</label>
                        <input type="text" name="spec_length_width" value="{{ old('spec_length_width', $product->spec_length_width ?? '200 cm x 115 cm') }}" class="w-full border border-gray-300 rounded-lg p-2 placeholder-gray-400">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Jenis Batik</label>
                        <input type="text" name="spec_type" value="{{ old('spec_type', $product->spec_type ?? 'Batik Tulis') }}" class="w-full border border-gray-300 rounded-lg p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Bahan Kain</label>
                        <input type="text" name="spec_material" value="{{ old('spec_material', $product->spec_material ?? 'Katun Primissima') }}" class="w-full border border-gray-300 rounded-lg p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Teknik Pembuatan</label>
                        <input type="text" name="spec_technique" value="{{ old('spec_technique', $product->spec_technique ?? 'Handmade (Canting)') }}" class="w-full border border-gray-300 rounded-lg p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Asal Daerah</label>
                        <input type="text" name="spec_origin" value="{{ old('spec_origin', $product->spec_origin ?? 'Desa Kidal, Malang') }}" class="w-full border border-gray-300 rounded-lg p-2">
                    </div>
                </div>
            </div>

            {{-- TOMBOL SUBMIT --}}
            <button type="submit" class="w-full bg-brand-green text-white py-4 rounded-xl font-bold hover:bg-green-800 transition shadow-lg text-lg">
                {{ isset($product) ? '💾 Simpan Perubahan' : '➕ Tambah Produk' }}
            </button>
        </div>

    </div>
</form>
@endsection