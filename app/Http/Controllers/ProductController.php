<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductController extends Controller
{
    // Menampilkan halaman katalog
    public function index(Request $request)
    {
        // Ambil semua kategori untuk slider
        $categories = ProductCategory::all();

        // Cek apakah ada filter kategori dari URL (saat gambar slider diklik)
        $categorySlug = $request->query('kategori');

        // Disarankan untuk anda (Random 4 produk)
        $recommendedProducts = Product::inRandomOrder()->limit(4)->get();

        // Batik lainnya (Produk terbaru)
        $query = Product::latest();
        
        // Jika sedang memfilter kategori, saring produknya
        if ($categorySlug) {
            $category = ProductCategory::where('slug', $categorySlug)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // Ambil 8 produk terbaru (bisa diatur pakai paginate nanti jika banyak)
        $latestProducts = $query->limit(8)->get();

        return view('products', compact('categories', 'recommendedProducts', 'latestProducts', 'categorySlug'));
    }
    public function show($slug)
    {
        // Ambil data produk beserta kategori dan galeri gambarnya
        $product = Product::with(['category', 'images'])->where('slug', $slug)->firstOrFail();
        
        // Ambil produk serupa (kategori sama, kecuali produk ini sendiri)
        $relatedProducts = Product::where('category_id', $product->category_id)
                                  ->where('id', '!=', $product->id)
                                  ->latest()
                                  ->get();

        return view('product_detail', compact('product', 'relatedProducts'));
    }

    // API untuk Search Autocomplete
    public function search(Request $request)
    {
        $search = $request->query('q');
        
        if (empty($search)) {
            return response()->json([]);
        }

        // Cari produk berdasarkan nama
        $products = Product::where('name', 'LIKE', "%{$search}%")
            ->limit(5)
            ->get(['name', 'slug', 'image']);

        return response()->json($products);
    }
}