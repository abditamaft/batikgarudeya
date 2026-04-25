<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeHero;
use App\Models\HomeAbout;
use Illuminate\Support\Facades\Storage;

class LandingController extends Controller
{
    public function index()
    {
        $hero = HomeHero::first();
        $about = HomeAbout::first();
        return view('admin.landing', compact('hero', 'about'));
    }

    public function updateHero(Request $request)
    {
        $hero = HomeHero::first() ?? new HomeHero();
        
        // Gunakan ?? ' ' agar jika form kosong, tersimpan spasi (bukan error)
        $hero->title_text = $request->title_text ?? ' ';

        if ($request->hasFile('bg_image')) {
            if ($hero->bg_image) Storage::disk('public')->delete($hero->bg_image);
            $hero->bg_image = $request->file('bg_image')->store('landing', 'public');
        }

        if ($request->hasFile('card_image')) {
            if ($hero->card_image) Storage::disk('public')->delete($hero->card_image);
            $hero->card_image = $request->file('card_image')->store('landing', 'public');
        }

        $hero->save();
        return back()->with('success', 'Banner Utama berhasil diperbarui!');
    }

    public function updateAbout(Request $request)
    {
        $about = HomeAbout::first() ?? new HomeAbout();
        
        // Validasi aman dari error NOT NULL
        $about->text_top_left = $request->text_top_left ?? ' ';
        $about->text_bottom_right = $request->text_bottom_right ?? ' ';
        $about->visi_misi_button_link = $request->visi_misi_button_link ?? '#';

        if ($request->hasFile('image_bottom_left')) {
            if ($about->image_bottom_left) Storage::disk('public')->delete($about->image_bottom_left);
            $about->image_bottom_left = $request->file('image_bottom_left')->store('landing', 'public');
        }

        if ($request->hasFile('image_top_right')) {
            if ($about->image_top_right) Storage::disk('public')->delete($about->image_top_right);
            $about->image_top_right = $request->file('image_top_right')->store('landing', 'public');
        }

        $about->save();
        return back()->with('success', 'Konten Tentang Kami berhasil diperbarui!');
    }
}
