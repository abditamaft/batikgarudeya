<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\artikel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\kategoriArtikel;
use App\Models\User;


class ArtikelController extends Controller
{
    public function index()
    {
        $articles = artikel::with('admin', 'category')->latest()->paginate(10);
        return view('admin.arrtikel.arrtikel', compact('articles'));
    }

    public function create()
    {
        $categories = kategoriArtikel::all();
        $article = new artikel();
        return view('admin.arrtikel.formArtikel', compact('categories', 'article'));
    }

    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'title' => 'required|max:200',
            'content' => 'nullable',
            'thumbnail' => 'nullable|image|max:2048',
            'published_at' => 'nullable|date',
            'category_id' => 'required|exists:article_categories,id',
        ]);

        $imagePath = null;
        if ($request->hasFile('thumbnail')) {
            $imagePath = $request->file('thumbnail')->store('articles', 'public');
        }

        $slug = Str::slug($request->title, '-');

        artikel::create([
            'admin_id' => auth()->id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => $slug,
            'thumbnail' => $imagePath,
            'content' => $request->content ?? '',
            'views' => 0,
        ]);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dibuat!');
    }

    public function edit($id)
    {
        $article = artikel::findOrFail($id);
        $categories = kategoriArtikel::all();
        return view('admin.arrtikel.formArtikel', compact('article', 'categories'));
    }
    public function update(Request $request, $id)
    {
        // Validasi data
        $validated = $request->validate([
            'title' => 'required|max:200',
            'content' => 'nullable',
            'thumbnail' => 'nullable|image|max:2048',
            'published_at' => 'nullable|date',
            'category_id' => 'required|exists:article_categories,id',
        ]);

        // Temukan artikel yang akan diupdate
        $article = artikel::findOrFail($id);
        $imagePath = null;
        if ($request->hasFile('thumbnail')) {
            if ($article->thumbnail) {
                Storage::disk('public')->delete($article->thumbnail);
            }
            $imagePath = $request->file('thumbnail')->store('articles', 'public');
        }
        $slug = Str::slug($request->title, '-');

        $article->update([
            'admin_id' => auth()->id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => $slug,
            'thumbnail' => $imagePath ?? $article->thumbnail,
            'content' => $request->content ?? $article->content,
            'views' => $article->views,
        ]);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui!');
    }
    public function destroy($id)
    {
        $article = artikel::findOrFail($id);
        if ($article->thumbnail) {
            Storage::disk('public')->delete($article->thumbnail);
        }
        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus!');
    }
}
