<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;


class AuthController extends Controller
{
    // Register (Buat Akun)
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'nik' => 'required|string|max:20|unique:users,nik',
            'bidang' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'no_hp' => 'required|string|min:12',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'username' => $request->username,
            'nik' => $request->nik,
            'bidang' => $request->bidang,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('success')->with('success', 'Akun berhasil dibuat!');
    }

    // Login umum
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();
            $user_detail = User::where('username', $request->username)->first();
            return redirect()->route('dashboard')->with('success', 'Login berhasil!')->with('user_detail', $user_detail);
        }

        return back()->withErrors(['username' => 'Username atau password salah']);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }

    // Login khusus RENEV
    public function loginRenev(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'bidang'   => 'required| string',
        ]);

        if (Auth::attempt(['username' => $request->username,'bidang' => $request->bidang, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->route('halrenev')->with('success', 'Login berhasil!');
        }

        return back()->withErrors(['username' => 'Username atau password salah']);
    }

    // Login khusus KEUANGAN
    public function loginKeuangan(Request $request)
    {
        if (Auth::attempt(['username' => $request->username,'bidang' => $request->bidang, 'password' => $request->password])) {
            return redirect()->route('keuangan');
        }

        return back()->withErrors(['login' => 'Username atau password salah.']);
    }

    // Login khusus PENGADAAN
    public function loginPengadaan(Request $request)
    {
        if (Auth::attempt(['username' => $request->username, 'bidang' => $request->bidang,'password' => $request->password])) {
            return redirect()->route('pengadaan');
        }

        return back()->withErrors(['login' => 'Username atau password salah.']);
    }

    // 🔧 FIXED: Login khusus KONSTRUKSI
    
    public function loginKontruksi(Request $request)
    {
        if (Auth::attempt(['username' => $request->username,'bidang' => $request->bidang, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->route('halkontruksi')->with('success', 'Login berhasil!');
        }

        return back()->withErrors(['login' => 'Username atau password salah.']);
    }
    public function create()
{
    return view('pilihpengadaan');
}
 // Login khusus Admin
 public function loginAdmin(Request $request)
 {
     $request->validate([
         'username' => 'required|string',
         'password' => 'required|string',
         'bidang'   => 'required| string',
     ]);

     if (Auth::attempt(['username' => $request->username,'bidang' => $request->bidang, 'password' => $request->password])) {
         $request->session()->regenerate();
         return redirect()->route('haladmin')->with('success', 'Login berhasil!');
     }

     return back()->withErrors(['username' => 'Username atau password salah']);
 }

}
