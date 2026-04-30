@extends('admin.layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Daftar Produk</h1>
        <p class="text-gray-500 text-sm mt-1">Kelola semua katalog batik Garudeya.</p>
    </div>
    <a href="{{ route('admin.produk.create') }}" class="bg-brand-green hover:bg-green-800 text-white px-5 py-2.5 rounded-lg font-semibold transition shadow-sm flex items-center gap-2">
        <span>+</span> Tambah Produk
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
                    <th class="p-4 font-semibold w-24">Gambar</th>
                    <th class="p-4 font-semibold">Nama Produk</th>
                    <th class="p-4 font-semibold">Kategori</th>
                    <th class="p-4 font-semibold">Harga</th>
                    <th class="p-4 font-semibold text-center">Unggulan (Max 5)</th> {{-- KOLOM BARU --}}
                    <th class="p-4 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($products as $item)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="p-4">
                        <img src="{{ asset('storage/'.$item->image) }}" class="w-16 h-20 object-cover rounded shadow-sm border" alt="{{ $item->name }}">
                    </td>
                    <td class="p-4">
                        <p class="font-bold text-gray-800">{{ $item->name }}</p>
                        <p class="text-xs text-yellow-500 font-bold">★ {{ $item->rating }}</p>
                    </td>
                    <td class="p-4 text-gray-600">
                        <span class="bg-gray-100 px-3 py-1 rounded-full text-xs font-semibold">{{ $item->category->name ?? 'Tanpa Kategori' }}</span>
                    </td>
                    <td class="p-4 font-semibold text-brand-green">
                        Rp {{ number_format($item->price, 0, ',', '.') }}
                    </td>
                    
                    {{-- CHECKBOX UNGGULAN --}}
                    <td class="p-4 text-center">
                        <input type="checkbox" class="feature-checkbox w-5 h-5 text-brand-green rounded focus:ring-brand-green cursor-pointer" 
                               data-id="{{ $item->id }}" 
                               {{ $item->is_featured ? 'checked' : '' }}>
                    </td>

                    <td class="p-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.produk.edit', $item->id) }}" class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 px-3 py-1.5 rounded text-sm font-medium transition">Edit</a>
                            
                            <form action="{{ route('admin.produk.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1.5 rounded text-sm font-medium transition">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-8 text-center text-gray-500 italic">Belum ada produk. Ayo tambahkan produk pertamamu!</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- SCRIPT AJAX UNTUK CHECKBOX --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.feature-checkbox');

    checkboxes.forEach(box => {
        box.addEventListener('change', function() {
            const isChecked = this.checked;
            const productId = this.getAttribute('data-id');

            // 1. Validasi Maksimal 5 di tampilan (Frontend)
            if (isChecked) {
                const currentChecked = document.querySelectorAll('.feature-checkbox:checked').length;
                if (currentChecked > 5) {
                    alert('Maksimal hanya 5 produk unggulan yang boleh dipilih!');
                    this.checked = false; // Batalkan centang otomatis
                    return; // Hentikan proses
                }
            }

            // 2. Kirim data ke server (Background process)
            fetch(`/admin/produk/${productId}/toggle-featured`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    is_featured: isChecked ? 1 : 0
                })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    // Jika ditolak oleh server (misal diakalin), muncul alert dan kembalikan centang
                    alert(data.message);
                    this.checked = !isChecked; 
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan pada sistem.');
                this.checked = !isChecked;
            });
        });
    });
});
</script>
@endsection