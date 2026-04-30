<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LandingController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\WebSettingController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\ProductController;
use App\Models\HomeHero;
use App\Models\HomeAbout;
use App\Models\CompanyProfile;
use App\Models\WebSetting; // Tambahkan di atas
use App\Models\Product;
// ==========================================
// 1. RUTE HALAMAN UTAMA (PENGUNJUNG/GUEST)
// ==========================================
Route::get('/', function () {
    return view('home', [
        'hero' => HomeHero::first(), 
        'about' => HomeAbout::first(),
        // REVISI DI SINI: Ambil 5 produk yang is_featured-nya 1 (true)
        'products' => Product::where('is_featured', 1)->limit(5)->get(), 
        
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

//route produk 
Route::get('/produk', [ProductController::class, 'index'])->name('produk.index');
Route::get('/api/produk/search', [ProductController::class, 'search'])->name('produk.search');
Route::get('/produk/{slug}', [ProductController::class, 'show'])->name('produk.show');

// ==========================================
// 2. RUTE LOGIN ADMIN
// ==========================================
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/admin/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('logout');

// ==========================================
// 3. RUTE HALAMAN ADMIN (WAJIB LOGIN)
// ==========================================
Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/landing', [LandingController::class, 'index'])->name('landing');
    Route::post('/landing/hero', [LandingController::class, 'updateHero'])->name('landing.hero');
    Route::post('/landing/about', [LandingController::class, 'updateAbout'])->name('landing.about');
    Route::get('/profil-umkm', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profil-umkm', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/pengaturan-web', [WebSettingController::class, 'index'])->name('settings');
    Route::post('/pengaturan-web', [WebSettingController::class, 'update'])->name('settings.update');
    // Rute CRUD Kategori
    Route::resource('kategori', ProductCategoryController::class)->parameters([
        'kategori' => 'kategori'
    ]);
    Route::post('produk/{produk}/toggle-featured', [AdminProductController::class, 'toggleFeatured'])->name('produk.toggle-featured');
    Route::resource('produk', AdminProductController::class)->parameters(['produk' => 'produk']);
    // Nanti route post untuk simpan data di sini
});
