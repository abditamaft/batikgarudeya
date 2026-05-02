@extends('admin.layouts.app')

@section('content')
<style>
    .content-rich-text ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 1rem; }
    .content-rich-text ol { list-style-type: decimal; padding-left: 1.5rem; margin-bottom: 1rem; }
    .content-rich-text blockquote { border-left: 4px solid #3b82f6; padding-left: 1rem; margin: 1rem 0; color: #374151; font-style: italic; background-color: #f9fafb; }
    .content-rich-text table { width: 100%; border-collapse: collapse; margin: 1rem 0; }
    .content-rich-text table th, .content-rich-text table td { border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; text-align: left; }
    .content-rich-text table th { background-color: #f3f4f6; font-weight: 600; }
    .content-rich-text h1 { font-size: 2.25rem; font-weight: 700; margin-bottom: 1rem; color: #111827; }
    .content-rich-text h2 { font-size: 1.5rem; font-weight: 600; margin-bottom: 0.75rem; color: #1f2937; }
    .content-rich-text h3 { font-size: 1.25rem; font-weight: 500; margin-bottom: 0.5rem; color: #374151; }
    [x-cloak] { display: none !important; }
</style>


<div class="max-w-4xl mx-auto py-10 px-4" 
    x-data="{ 
        openModalKategori: false, 
        openKategori: false, 
        selectedName: '{{ $categories->firstWhere('id', old('category_id', $article->category_id ?? ''))?->name ?? 'Pilih Kategori...' }}' 
    }" x-cloak>
    
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

        <form action="{{ isset($article->id) ? route('admin.artikel.update', $article->id) : route('admin.artikel.store') }}" 
            method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @if(isset($article->id)) @method('PUT') @endif
            
            <!-- Judul -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Artikel</label>
                <input type="text" name="title" value="{{ old('title', $article->title ?? '') }}" placeholder="Masukkan judul..." required 
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2.5 border">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Dropdown Kategori -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-sm font-semibold text-gray-700">Kategori Artikel</label>
                        <button type="button" @click="openModalKategori = true"
                            class="bg-blue-500 text-white px-3 py-1.5 rounded-md hover:bg-blue-600 transition flex items-center gap-1.5 text-xs shadow-sm cursor-pointer">
                            <i class="fas fa-plus"></i> Tambah Kategori
                        </button>
                    </div>
                    
                    <div class="relative">
                        <button type="button" @click="openKategori = !openKategori"
                                class="w-full flex items-center justify-between border-gray-300 rounded-lg shadow-sm bg-white p-2.5 border transition cursor-pointer">
                            <span x-text="selectedName" class="text-sm"></span>
                            <svg class="w-4 h-4 text-gray-400 transition-transform" :class="openKategori ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div id="categoryListContainer" x-show="openKategori" @click.away="openKategori = false" 
                            class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-xl max-h-60 overflow-y-auto">
                            @forelse($categories as $category)
                            <div class="group flex items-center justify-between px-4 py-2 hover:bg-gray-50 border-b border-gray-50 last:border-0">
                                <div class="flex-1 text-sm text-gray-700 cursor-pointer" 
                                    @click="selectedName = '{{ $category->name }}'; document.getElementById('category_id_hidden').value = '{{ $category->id }}'; openKategori = false">
                                    {{ $category->name }}
                                </div>
                                <button type="button" onclick="confirmDeleteCategory('{{ $category->id }}', '{{ $category->name }}')"
                                        class="p-1 text-red-400 hover:text-red-600 transition-all cursor-pointer">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                            @empty
                            <div class="px-4 py-3 text-sm text-gray-500 italic text-center">Belum ada kategori</div>
                            @endforelse
                        </div>
                    </div>
                    <input type="hidden" name="category_id" id="category_id_hidden" value="{{ old('category_id', $article->category_id ?? '') }}" required>
                </div>

                <!-- Gambar Utama -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Gambar Utama (Thumbnail)</label>
                    <div class="relative group">
                        <div class="w-full h-44 rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 overflow-hidden flex items-center justify-center transition group-hover:border-blue-400">
                            @if(isset($article) && $article->thumbnail)
                                <img id="preview_gambarArtikel" src="{{ asset('storage/'.$article->thumbnail) }}" class="w-full h-full object-cover">
                            @else
                                <div id="placeholder_icon" class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <p class="text-xs text-gray-400 mt-2">Belum ada gambar</p>
                                </div>
                                <img id="preview_gambarArtikel" src="" class="hidden w-full h-full object-cover">
                            @endif
                        </div>
                        <input type="file" name="thumbnail" id="thumbnailInput" class="mt-3 block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-blue-50 file:text-blue-700 cursor-pointer" accept="image/*">
                    </div>
                </div>
            </div>

            <!-- Konten -->
            <div class="content-rich-text">
                <label class="block text-sm font-medium text-gray-700 mb-2">Isi Konten</label>
                <textarea name="content" id="editor" required>{!! old('content', $article->content ?? '') !!}</textarea>
            </div>

            <div class="flex items-center justify-end pt-4 border-t">
                <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 shadow-lg transition cursor-pointer">Simpan Artikel</button>
            </div>
        </form>
    </div>

    <!-- Modal Tambah Kategori -->
    <div x-show="openModalKategori" 
        class="fixed inset-0 z-[999] overflow-y-auto" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-cloak>
        
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="openModalKategori = false"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white rounded-2xl shadow-2xl sm:max-w-lg sm:w-full overflow-hidden transform transition-all z-[1000]"
                @click.away="openModalKategori = false">
                
                <div class="bg-white px-6 pt-6 pb-4">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-slate-800">Tambah Kategori Baru</h3>
                        <button type="button" @click="openModalKategori = false" class="text-gray-400 hover:text-gray-600 transition cursor-pointer">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                            <input type="text" id="categoryNameAjax" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" 
                                placeholder="Contoh: Berita Batik"
                                @keyup.enter="simpanKategoriAjax()">
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-3">
                    <button type="button" onclick="simpanKategoriAjax()" 
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 transition shadow-md cursor-pointer">
                        Simpan Kategori
                    </button>
                    <button type="button" @click="openModalKategori = false" 
                            class="bg-white border border-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<form id="deleteCategoryForm" method="POST" style="display:none;">
    @csrf @method('DELETE')
</form>

<!-- Scripts -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
    // Preview Gambar
    document.getElementById('thumbnailInput').onchange = evt => {
        const [file] = document.getElementById('thumbnailInput').files;
        const preview = document.getElementById('preview_gambarArtikel');
        const placeholder = document.getElementById('placeholder_icon');
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
            if(placeholder) placeholder.classList.add('hidden');
        }
    };

    // Hapus Kategori
    function confirmDeleteCategory(id, name) {
        if (confirm(`Apakah Anda yakin ingin menghapus kategori "${name}"? Semua artikel terkait akan terpengaruh.`)) {
            const form = document.getElementById('deleteCategoryForm');
            form.action = "{{ route('admin.kategoriArtikel.destroy', ':id') }}".replace(':id', id);
            form.submit();
        }
    }

    // SIMPAN KATEGORI AJAX (TANPA RELOAD)
    function simpanKategoriAjax() {
        const nameInput = document.getElementById('categoryNameAjax');
        const name = nameInput.value;
        
        if (!name) return alert('Nama kategori harus diisi');

        fetch("{{ route('admin.kategoriArtikel.store') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ name: name })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const container = document.getElementById('categoryListContainer');
                const newItemHtml = `
                    <div class="group flex items-center justify-between px-4 py-2 hover:bg-gray-50 border-b border-gray-50 last:border-0">
                        <div class="flex-1 text-sm text-gray-700 cursor-pointer" 
                             onclick="updateCategorySelection('${data.id}', '${data.name}')">
                            ${data.name}
                        </div>
                    </div>`;
                
                if(container) {
                    container.insertAdjacentHTML('afterbegin', newItemHtml);
                }
                const rootEl = document.querySelector('[x-data]');
                if (rootEl && rootEl._x_dataStack) {
                    const state = rootEl._x_dataStack[0];
                    state.selectedName = data.name; // Langsung pilih
                    state.openModalKategori = false; // Tutup modal
                    document.getElementById('category_id_hidden').value = data.id; // Set ID
                }
                nameInput.value = '';
                alert('Kategori berhasil ditambahkan!');
            } else {
                alert('Gagal: ' + (data.message || 'Coba lagi'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan server.');
        });
    }

    window.updateCategorySelection = function(id, name) {
        const rootEl = document.querySelector('[x-data]');
        const state = rootEl._x_dataStack[0];
        state.selectedName = name;
        state.openKategori = false;
        document.getElementById('category_id_hidden').value = id;
    };
</script>
@endsection