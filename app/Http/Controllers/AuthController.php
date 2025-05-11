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
//login umum

public function login(Request $request)
{
    // Validate the input fields
    $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    // Check if the user exists by the provided username
    $user = User::where('username', $request->username)->first();

    if (!$user) {
        // If the user is not found, display an error message for account not found
        return back()->withErrors(['username' => 'Akun Anda tidak ditemukan.']);
    }

    // Attempt to authenticate the user with the given username and password
    if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
        // Regenerate the session to prevent session fixation
        $request->session()->regenerate();

        // Redirect the user to the dashboard if login is successful
        return redirect()->route('dashboard')->with('success', 'Login berhasil!');
    }

    // If authentication fails (incorrect password), show an error message
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
        'bidang'   => 'required|string',
    ]);

    // Check if the user exists for the specified bidang
    $user = User::where('username', $request->username)->where('bidang', $request->bidang)->first();

    if (!$user) {
        // User not found or bidang mismatch
        return back()->with('error', 'Akun Anda tidak ditemukan atau bidang yang Anda pilih salah. Disini buka bidang Anda.');
    }

    // Attempt login if user exists
    if (Auth::attempt(['username' => $request->username, 'bidang' => $request->bidang, 'password' => $request->password])) {
        $request->session()->regenerate();
        return redirect()->route('halrenev')->with('success', 'Login berhasil!');
    }

    // Invalid credentials
    return back()->withErrors(['username' => 'Username atau password salah']);
}

// Login khusus KEUANGAN
public function loginKeuangan(Request $request)
{
    // Check if the user exists for the specified bidang
    $user = User::where('username', $request->username)->where('bidang', $request->bidang)->first();

    if (!$user) {
        // User not found or bidang mismatch
        return back()->with('error', 'Akun Anda tidak ditemukan atau bidang yang Anda pilih salah. Disini buka bidang Anda.');
    }

    // Attempt login if user exists
    if (Auth::attempt(['username' => $request->username, 'bidang' => $request->bidang, 'password' => $request->password])) {
        return redirect()->route('keuangan');
    }

    // Invalid credentials
    return back()->withErrors(['login' => 'Username atau password salah.']);
}

// Login khusus PENGADAAN
public function loginPengadaan(Request $request)
{
    // Check if the user exists for the specified bidang
    $user = User::where('username', $request->username)->where('bidang', $request->bidang)->first();

    if (!$user) {
        // User not found or bidang mismatch
        return back()->with('error', 'Akun Anda tidak ditemukan atau bidang yang Anda pilih salah. Disini buka bidang Anda.');
    }

    // Attempt login if user exists
    if (Auth::attempt(['username' => $request->username, 'bidang' => $request->bidang, 'password' => $request->password])) {
        return redirect()->route('pengadaan');
    }

    // Invalid credentials
    return back()->withErrors(['login' => 'Username atau password salah.']);
}

// Login khusus KONSTRUKSI
public function loginKontruksi(Request $request)
{
    // Check if the user exists for the specified bidang
    $user = User::where('username', $request->username)->where('bidang', $request->bidang)->first();

    if (!$user) {
        // User not found or bidang mismatch
        return back()->with('error', 'Akun Anda tidak ditemukan atau bidang yang Anda pilih salah. Disini buka bidang Anda.');
    }

    // Attempt login if user exists
    if (Auth::attempt(['username' => $request->username, 'bidang' => $request->bidang, 'password' => $request->password])) {
        $request->session()->regenerate();
        return redirect()->route('halkontruksi')->with('success', 'Login berhasil!');
    }

    // Invalid credentials
    return back()->withErrors(['login' => 'Username atau password salah.']);
}

// Login khusus Admin
public function loginAdmin(Request $request)
{
    $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
        'bidang'   => 'required|string',
    ]);

    // Check if the user exists for the specified bidang
    $user = User::where('username', $request->username)->where('bidang', $request->bidang)->first();

    if (!$user) {
        // User not found or bidang mismatch
        return back()->with('error', 'Akun Anda tidak ditemukan atau bidang yang Anda pilih salah. Disini buka bidang Anda.');
    }

    // Attempt login if user exists
    if (Auth::attempt(['username' => $request->username, 'bidang' => $request->bidang, 'password' => $request->password])) {
        $request->session()->regenerate();
        return redirect()->route('haladmin')->with('success', 'Login berhasil!');
    }

    // Invalid credentials
    return back()->withErrors(['username' => 'Username atau password salah']);
}

}
