
@extends('admin.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4">
    <div class="mb-4">
        <a href="{{ route('admin.artikel.index') }}" onclick="return confirm('Apakah Anda yakin ingin kembali? Perubahan yang belum disimpan akan hilang.');"
        class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors duration-200">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar Artikel
        </a>
    </div>
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="bg-slate-800 p-4">
            <h2 class="text-white text-lg font-semibold italic">Tulis Artikel Baru</h2>
        </div>
        

        <form action="{{ isset($article->id) ? route('admin.artikel.update', $article->id) : route('admin.artikel.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Artikel</label>
                <input type="text" name="title" value="{{ old('title', $article->title ?? '') }}" placeholder="Masukkan judul yang menarik..." required 
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2.5 border">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="category_id" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2.5 border">
                        <option value="" disabled selected>Pilih Kategori</option>
                        @forelse($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $article->category_id ?? '') == $category->id ? 'selected' : '' }}> {{ $category->name }}</option>
                        @empty
                            <option value="" disabled>Belum ada kategori tersedia</option>
                        @endforelse
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Utama (Thumbnail)</label>
                    <input type="file" name="thumbnail" id="thumbnailInput" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" accept="image/*">
                    <img id="preview_gambarArtikel" src="{{ isset($article) && $article->thumbnail ? asset('storage/'.$article->thumbnail) : '' }}" class="mx-auto h-32 md:h-40 w-auto object-cover rounded-lg mb-4 shadow-sm">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Isi Konten</label>
                <textarea name="content" id="editor" required>{!! old('content', $article->content ?? '') !!}</textarea>
            </div>

            <div class="flex items-center justify-end pt-4 border-t">

                <div class="space-x-3">
                    <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 shadow-lg transition cursor-pointer">Simpan Artikel</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

