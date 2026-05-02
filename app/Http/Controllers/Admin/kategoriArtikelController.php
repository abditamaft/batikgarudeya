<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\kategoriArtikel;
use Illuminate\Support\Str;

class kategoriArtikelController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100|unique:article_categories,name',
        ]);

        $category = kategoriArtikel::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
        ]);
        return response()->json([
        'success' => true,
        'id' => $category->id,
        'name' => $category->name
    ]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:100|unique:article_categories,name,' . $id,
        ]);

        $kategori = kategoriArtikel::findOrFail($id);
        $kategori->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui!');
    }
    public function destroy($id)
    {
        $kategori = kategoriArtikel::findOrFail($id);
        $kategori->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }
}
