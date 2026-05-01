@extends('admin.layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Kategori Produk</h1>
        <p class="text-gray-500 text-sm mt-1">Kelola daftar kategori batik untuk slider katalog.</p>
    </div>
    <a href="{{ route('admin.kategori.create') }}" class="bg-brand-green hover:bg-green-800 text-white px-5 py-2.5 rounded-lg font-semibold transition shadow-sm flex items-center gap-2">
        <span>+</span> Tambah Kategori
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-600 border-b border-gray-200">
                    <th class="p-4 font-semibold">Gambar Slider</th>
                    <th class="p-4 font-semibold">Nama Kategori</th>
                    <th class="p-4 font-semibold">Total Produk</th>
                    <th class="p-4 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($categories as $item)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="p-4">
                        <img src="{{ asset('storage/'.$item->image) }}" class="w-32 h-12 object-cover rounded-md border shadow-sm" alt="{{ $item->name }}">
                    </td>
                    <td class="p-4">
                        <p class="font-bold text-gray-800">{{ $item->name }}</p>
                        <p class="text-xs text-gray-400 font-mono">/{{ $item->slug }}</p>
                    </td>
                    <td class="p-4 text-gray-600">
                        {{ $item->products ? $item->products->count() : 0 }} Produk
                    </td>
                    <td class="p-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.kategori.edit', $item->id) }}" class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 px-3 py-1.5 rounded text-sm font-medium transition">Edit</a>
                            
                            <form action="{{ route('admin.kategori.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini? (Produk di dalamnya mungkin akan kehilangan kategori)');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1.5 rounded text-sm font-medium transition">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-8 text-center text-gray-500 italic">Belum ada kategori yang ditambahkan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection