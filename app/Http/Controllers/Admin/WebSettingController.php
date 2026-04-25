<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WebSetting;
use Illuminate\Support\Facades\Storage;

class WebSettingController extends Controller
{
    public function index()
    {
        $settings = WebSetting::first();
        return view('admin.web_settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = WebSetting::first() ?? new WebSetting();
        
        // Simpan Teks
        $settings->website_name = $request->website_name ?? 'Batik Garudeya Kidal';
        $settings->whatsapp_number = $request->whatsapp_number ?? '';
        $settings->whatsapp_message = $request->whatsapp_message ?? '';
        $settings->email = $request->email ?? '';
        $settings->address = $request->address ?? '';
        $settings->maps_iframe = $request->maps_iframe ?? '';
        $settings->instagram_url = $request->instagram_url ?? '';
        $settings->facebook_url = $request->facebook_url ?? '';
        $settings->tiktok_url = $request->tiktok_url ?? '';

        // Otomatisasi tanggal update
        $settings->updated_at = now();

        // Upload Logo UMKM
        if ($request->hasFile('logo_umkm')) {
            if ($settings->logo_umkm) Storage::disk('public')->delete($settings->logo_umkm);
            $settings->logo_umkm = $request->file('logo_umkm')->store('logos', 'public');
        }

        // Upload Logo Polinema
        if ($request->hasFile('logo_polinema')) {
            if ($settings->logo_polinema) Storage::disk('public')->delete($settings->logo_polinema);
            $settings->logo_polinema = $request->file('logo_polinema')->store('logos', 'public');
        }

        $settings->save();
        return back()->with('success', 'Pengaturan Website berhasil diperbarui!');
    }
}
