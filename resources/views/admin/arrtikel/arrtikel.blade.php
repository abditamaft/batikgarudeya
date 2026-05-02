@extends('admin.layouts.app')

@section('content')

<div class="bg-gray-100 font-sans" x-data="{ searchQuery: '' }">
    <div class="flex-grow overflow-y-auto">
        <div class="bg-white shadow-sm p-4 flex justify-between items-center">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Daftar Artikel</h1>
            <div class="flex items-center space-x-4">
                <span class="text-gray-600 hidden md:inline">Halo, Admin</span>
                <img src="https://ui-avatars.com/api/?name=Admin" class="w-8 h-8 rounded-full border">
            </div>
        </div>

        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <!-- Input Search dengan x-model -->
                <div class="relative w-64">
                    <input type="text" 
                        x-model="searchQuery" 
                        placeholder="Cari artikel..." 
                        class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>

                <a href="{{ route('admin.artikel.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition flex items-center shadow">
                    <i class="fas fa-plus mr-2"></i> Tulis Artikel Baru
                </a>
            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-sm border-b">
                        <tr>
                            <th class="p-4 font-semibold">Judul</th>
                            <th class="p-4 font-semibold">Kategori</th>
                            <th class="p-4 font-semibold">Tanggal</th>
                            <th class="p-4 font-semibold">Dilihat</th>
                            <th class="p-4 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y text-gray-700">
                        @forelse($articles as $article)
                        <!-- Logika Show/Hide DOM diletakkan di tag <tr> -->
                        <tr class="hover:bg-gray-50 transition-colors"
                            x-show="searchQuery === '' || 
                                    '{{ strtolower($article->title) }}'.includes(searchQuery.toLowerCase()) || 
                                    '{{ strtolower($article->category->name) }}'.includes(searchQuery.toLowerCase())"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100">
                            
                            <td class="p-4 font-medium">{{ $article->title }}</td>
                            <td class="p-4">
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded">
                                    {{ $article->category->name }}
                                </span>
                            </td>
                            <td class="p-4">
                                <span class="text-green-600">
                                    <i class="fas fa-check-circle mr-1"></i> {{ $article->created_at->format('d M Y') }}
                                </span>
                            </td>
                            <td class="p-4 text-sm">{{ $article->views }}</td>
                            <td class="p-4 text-center space-x-2 flex justify-end">
                                <a href="{{ route('admin.artikel.edit', $article->id) }}" class="text-blue-500 hover:text-blue-700">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.artikel.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-500">Belum ada artikel yang dibuat.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection