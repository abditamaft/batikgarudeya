<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LandingController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\WebSettingController;
use App\Http\Controllers\Admin\ArtikelController;
use App\Http\Controllers\Admin\KategoriArtikelController; // Tambahkan jika ada kategori artikel
use App\Models\HomeHero;
use App\Models\HomeAbout;
use App\Models\CompanyProfile;
use App\Models\WebSetting; // Tambahkan di atas
// ==========================================
// 1. RUTE HALAMAN UTAMA (PENGUNJUNG/GUEST)
// ==========================================
Route::get('/', function () {
    return view('home', [
        'hero' => HomeHero::first(), 
        'about' => HomeAbout::first(),
        'products' => collect([]), // Collection kosong agar tidak error
        'latestArticles' => collect([]),
        'popularArticles' => collect([]),
        'webSettings' => (object) ['whatsapp_number' => '628123456789']
    ]);
});
// 2. TAMBAHKAN RUTE PROFIL DI SINI
Route::get('/profil', function () {
    return view('profile', [
        'profile' => CompanyProfile::first(),
        'webSettings' => (object) ['whatsapp_number' => '628123456789']
    ]);
});
Route::get('/kontak', function () {
    return view('contact', [
        'settings' => WebSetting::first(),
        'webSettings' => WebSetting::first() ?? (object) ['whatsapp_number' => '628123456789']
    ]);
});

// ==========================================
// 2. RUTE LOGIN ADMIN
// ==========================================
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/admin/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('logout');

// ==========================================
// 3. RUTE HALAMAN ADMIN (WAJIB LOGIN)
// ==========================================
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/landing', [LandingController::class, 'index'])->name('landing');
    Route::post('/landing/hero', [LandingController::class, 'updateHero'])->name('landing.hero');
    Route::post('/landing/about', [LandingController::class, 'updateAbout'])->name('landing.about');
    Route::get('/profil-umkm', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profil-umkm', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/pengaturan-web', [WebSettingController::class, 'index'])->name('settings');
    Route::post('/pengaturan-web', [WebSettingController::class, 'update'])->name('settings.update');

    Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel.index');
    Route::get('/artikel/create', [ArtikelController::class, 'create'])->name('artikel.create');
    Route::post('/artikel', [ArtikelController::class, 'store'])->name('artikel.store');
    Route::get('/artikel/{id}/edit', [ArtikelController::class, 'edit'])->name('artikel.edit');
    Route::put('/artikel/{id}', [ArtikelController::class, 'update'])->name('artikel.update');
    Route::delete('/artikel/{id}', [ArtikelController::class, 'destroy'])->name('artikel.destroy');
});
