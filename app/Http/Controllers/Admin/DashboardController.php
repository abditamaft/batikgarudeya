<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Analytics sederhana sesuai database yang ada
        $totalProducts = DB::table('products')->count();
        $totalArticles = DB::table('articles')->count();
        $totalViews = DB::table('articles')->sum('views');
        
        return view('admin.dashboard', compact('totalProducts', 'totalArticles', 'totalViews'));
    }
}
