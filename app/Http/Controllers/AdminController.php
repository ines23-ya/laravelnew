<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all(); // Ambil semua akun dari database
        return view('haladmin', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id); // Ambil detail akun berdasarkan ID
        return response()->json($user); // Kirim data dalam format JSON
    }

    public function haladmin()
    {
        $users = User::all(); // Ambil semua akun untuk tampilan haladmin
        return view('haladmin', compact('users')); // Pastikan view-nya tersedia
    }
}
