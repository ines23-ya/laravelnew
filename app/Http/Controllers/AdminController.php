<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all(); // Get all users from the database
        return view('haladmin', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id); // Get user details based on ID
        return response()->json($user); // Return user data as JSON for AJAX
    }

    public function update(Request $request, $id)
    {
        // Validate incoming request data
        $request->validate([
            'username' => 'required|string|max:255',
            'nik' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_hp' => 'required|string|max:15',
            'bidang' => 'required|string|max:50',
        ]);

        // Find the user by ID and update
        $user = User::findOrFail($id);
        $user->update([
            'username' => $request->username,
            'nik' => $request->nik,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'bidang' => $request->bidang,
        ]);

        return response()->json(['success' => 'Akun berhasil diperbarui']);
    }

    public function destroy($id)
    {
        // Find the user by ID and delete
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['success' => 'Akun berhasil dihapus']);
    }
}
