<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        // Ambil produk beserta nama kategorinya
        $products = Product::with('category')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = ProductCategory::all();
        return view('admin.products.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'category_id' => 'required|exists:product_categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048', // Validasi multi gambar
        ]);

        // 1. Simpan Gambar Utama
        $mainImagePath = $request->file('image')->store('products', 'public');

        // 2. Simpan Data Produk
        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . time(), // Tambah time() agar slug unik
            'category_id' => $request->category_id,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $mainImagePath,
            'rating' => $request->rating ?? 5.0,
            'spec_length_width' => $request->spec_length_width,
            'spec_type' => $request->spec_type,
            'spec_material' => $request->spec_material,
            'spec_technique' => $request->spec_technique,
            'spec_origin' => $request->spec_origin,
        ]);

        // 3. Simpan Gambar Galeri (Jika ada)
        if ($request->hasFile('gallery')) {
            // Batasi maksimal 3 gambar galeri
            $galleryFiles = array_slice($request->file('gallery'), 0, 3);
            foreach ($galleryFiles as $file) {
                $galleryPath = $file->store('products/gallery', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $galleryPath
                ]);
            }
        }

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $produk)
    {
        $categories = ProductCategory::all();
        $produk->load('images'); // Load relasi galeri
        return view('admin.products.form', ['product' => $produk, 'categories' => $categories]);
    }

    public function update(Request $request, Product $produk)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'category_id' => 'required|exists:product_categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->only([
            'name', 'category_id', 'price', 'description', 
            'rating', 'spec_length_width', 'spec_type', 
            'spec_material', 'spec_technique', 'spec_origin'
        ]);
        $data['slug'] = Str::slug($request->name) . '-' . $produk->id;

        // Update Gambar Utama
        if ($request->hasFile('image')) {
            if ($produk->image) Storage::disk('public')->delete($produk->image);
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $produk->update($data);

        // Update Gambar Galeri (Timpa dengan yang baru jika diupload ulang)
        if ($request->hasFile('gallery')) {
            // Hapus file fisik galeri lama
            foreach ($produk->images as $oldImg) {
                Storage::disk('public')->delete($oldImg->image);
                $oldImg->delete();
            }

            // Upload galeri baru (Maks 3)
            $galleryFiles = array_slice($request->file('gallery'), 0, 3);
            foreach ($galleryFiles as $file) {
                $galleryPath = $file->store('products/gallery', 'public');
                ProductImage::create([
                    'product_id' => $produk->id,
                    'image' => $galleryPath
                ]);
            }
        }

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $produk)
    {
        // Hapus Gambar Utama
        if ($produk->image) Storage::disk('public')->delete($produk->image);
        
        // Hapus Gambar Galeri
        foreach ($produk->images as $img) {
            Storage::disk('public')->delete($img->image);
        }

        $produk->delete();
        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus!');
    }
    // Fungsi untuk Toggle Fitur Unggulan (AJAX)
    public function toggleFeatured(Request $request, Product $produk)
    {
        $isFeatured = $request->is_featured;

        // Validasi keamanan di sisi server agar tidak bisa diakali
        if ($isFeatured == 1) {
            $currentCount = Product::where('is_featured', 1)->count();
            if ($currentCount >= 5) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Maksimal 5 produk unggulan! Hapus centang produk lain terlebih dahulu.'
                ]);
            }
        }

        // Update status di database
        $produk->update(['is_featured' => $isFeatured]);

        return response()->json([
            'success' => true, 
            'message' => 'Status unggulan berhasil diperbarui!'
        ]);
    }
}