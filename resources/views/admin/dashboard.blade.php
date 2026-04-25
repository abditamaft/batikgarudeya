@extends('admin.layouts.app')

@section('content')
<h1 class="text-3xl font-bold mb-8 text-gray-800">Dashboard Analytics</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-brand-green flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-500 mb-1">Total Produk</p>
            <h3 class="text-3xl font-bold">{{ $totalProducts }}</h3>
        </div>
        <div class="text-4xl">📦</div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500 flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-500 mb-1">Total Artikel</p>
            <h3 class="text-3xl font-bold">{{ $totalArticles }}</h3>
        </div>
        <div class="text-4xl">📝</div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-orange-500 flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-500 mb-1">Total Pembaca Artikel</p>
            <h3 class="text-3xl font-bold">{{ $totalViews }}</h3>
        </div>
        <div class="text-4xl">👁️</div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm p-6">
    <h2 class="text-lg font-bold mb-4">Selamat Datang di CMS Garudeya Kidal!</h2>
    <p class="text-gray-600">Gunakan menu di sebelah kiri untuk mengelola konten website. Semua perubahan yang Anda lakukan di sini akan langsung tampil secara *real-time* di halaman utama website pengunjung.</p>
</div>
@endsection