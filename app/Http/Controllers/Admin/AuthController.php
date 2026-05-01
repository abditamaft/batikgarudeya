<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // REVISI: Gunakan 'username' (sesuai kolom di tabel admins), bukan 'email'
        $credentials = [
            'username' => $data['username'],
            'password' => $data['password'],
        ];

        // REVISI: Tambahkan guard('admin') agar mengarah ke tabel admins
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors(['username' => 'Username atau password salah!']);
    }

    public function logout(Request $request)
    {
        // REVISI: Tambahkan guard('admin') saat logout
        Auth::guard('admin')->logout(); 
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }
}