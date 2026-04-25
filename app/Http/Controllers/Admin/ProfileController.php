<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompanyProfile;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Menampilkan form admin
    public function index()
    {
        $profile = CompanyProfile::first();
        return view('admin.profile', compact('profile'));
    }

    // Menyimpan data dari form
    public function update(Request $request)
    {
        // Ambil baris pertama, atau buat objek baru jika kosong
        $profile = CompanyProfile::first() ?? new CompanyProfile();

        // Simpan teks (menggunakan ' ' sebagai fallback agar tidak error NOT NULL)
        $profile->text_top_left = $request->text_top_left ?? ' ';
        $profile->text_bottom_right = $request->text_bottom_right ?? ' ';
        $profile->visi_text = $request->visi_text ?? ' ';
        $profile->misi_text = $request->misi_text ?? ' ';
        $profile->owner_name = $request->owner_name ?? ' ';
        $profile->owner_quote = $request->owner_quote ?? ' ';

        // Logic upload gambar (Kiri)
        if ($request->hasFile('image_bottom_left')) {
            // Hapus file lama jika ada
            if ($profile->image_bottom_left) Storage::disk('public')->delete($profile->image_bottom_left);
            // Simpan file baru ke folder 'profile'
            $profile->image_bottom_left = $request->file('image_bottom_left')->store('profile', 'public');
        }

        // Logic upload gambar (Kanan)
        if ($request->hasFile('image_top_right')) {
            // Hapus file lama jika ada
            if ($profile->image_top_right) Storage::disk('public')->delete($profile->image_top_right);
            // Simpan file baru ke folder 'profile'
            $profile->image_top_right = $request->file('image_top_right')->store('profile', 'public');
        }

        $profile->save();

        // Redirect kembali dengan pesan sukses
        return back()->with('success', 'Halaman Profil UMKM berhasil diperbarui!');
    }
}
