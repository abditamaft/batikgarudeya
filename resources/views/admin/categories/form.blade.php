@extends('admin.layouts.app')

@section('content')
<div class="mb-6 flex items-center gap-4">
    <a href="{{ route('admin.kategori.index') }}" class="w-10 h-10 bg-white border border-gray-200 rounded-full flex items-center justify-center text-gray-600 hover:bg-gray-50 hover:text-brand-green transition shadow-sm">
        ←
    </a>
    <div>
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">{{ isset($category) ? 'Edit Kategori' : 'Tambah Kategori Baru' }}</h1>
    </div>
</div>

<form action="{{ isset($category) ? route('admin.kategori.update', $category->id) : route('admin.kategori.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 md:p-8 rounded-xl shadow-sm border border-gray-100 max-w-4xl">
    @csrf
    @if(isset($category))
        @method('PUT')
    @endif

    <div class="space-y-6">
        {{-- Nama Kategori --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kategori</label>
            <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}" placeholder="Contoh: Batik Malang, Batik Solo..." required
                   class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-brand-green outline-none transition">
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Upload Banner/Gambar Kategori --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Background Slider Kategori</label>
            
            {{-- Kotak Peringatan Rasio --}}
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-4 rounded-r-lg">
                <div class="flex items-start">
                    <div class="flex-shrink-0 text-blue-500 text-xl font-bold">ℹ️</div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-blue-800">PANDUAN RESOLUSI GAMBAR</h3>
                        <p class="text-xs text-blue-700 mt-1">
                            Agar desain slider halaman produk tidak terpotong dan terlihat profesional, <strong>WAJIB</strong> menggunakan gambar yang sangat melebar ke samping dengan rasio <strong>21:9 atau 16:5</strong>.<br>
                            Saran ukuran: <strong>1200x400 pixel</strong> atau <strong>900x300 pixel</strong>.
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-6">
                {{-- Preview Area --}}
                <div class="w-64 h-24 bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center overflow-hidden">
                    <img id="preview_image" src="{{ isset($category) && $category->image ? asset('storage/'.$category->image) : '' }}" class="{{ isset($category) && $category->image ? '' : 'hidden' }} w-full h-full object-cover">
                    <span id="preview_text" class="{{ isset($category) && $category->image ? 'hidden' : '' }} text-xs text-gray-400 font-medium">Preview Gambar</span>
                </div>

                {{-- Input File --}}
                <div class="flex-1">
                    <input type="file" name="image" id="image" accept="image/*" class="w-full border border-gray-300 rounded-lg p-2 text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-brand-green/10 file:text-brand-green hover:file:bg-brand-green/20 transition cursor-pointer" {{ isset($category) ? '' : 'required' }}>
                    <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG, WEBP. Maks 2MB.</p>
                    @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end">
        <button type="submit" class="bg-brand-green text-white px-8 py-3 rounded-lg font-bold hover:bg-green-800 transition shadow-md">
            {{ isset($category) ? '💾 Simpan Perubahan' : '➕ Tambah Kategori' }}
        </button>
    </div>
</form>

{{-- Script untuk Preview Gambar Otomatis --}}
<script>
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview_image').src = e.target.result;
                document.getElementById('preview_image').classList.remove('hidden');
                document.getElementById('preview_text').classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection