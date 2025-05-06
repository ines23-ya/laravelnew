<?php
namespace App\Http\Controllers;

use App\Models\Renev;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RenevController extends Controller
{
    // Menampilkan semua data Renev (return view, not JSON)
    public function index()
    {
        $renevs = Renev::all(); // Mengambil semua data dari tabel 'renevs'

        // Return a view with data
        return view('halrenev', compact('renevs')); // Passing the data to the view
    }

    // Menyimpan data Renev baru
    public function store(Request $request)
    {
        // Validate incoming data
        $request->validate([
            'unsur_id' => 'required|exists:unsurs,id',  // Ensure the foreign key exists in the 'unsurs' table
            'fungsi_id' => 'required|exists:fungsis,id', // Ensure the foreign key exists in the 'fungis' table
            'no_prk' => 'required|string',
            'no_skko' => 'required|string',
            'pekerjaan' => 'required|string',
            'satuan' => 'required|string',
            'volume' => 'required|numeric',
            'total_material' => 'required|numeric',
            'total_jasa' => 'required|numeric',
            'jumlah_pagu' => 'required|numeric',
        ]);

        // Create a new Renev instance and assign values
        $renev = new Renev();
        $renev->unsur_id = $request->unsur_id;
        $renev->fungsi_id = $request->fungsi_id;
        $renev->no_prk = 'PRK.3216.' . $request->no_prk;
        $renev->no_skko = 'SKKO.3216.' . $request->no_skko;
        $renev->pekerjaan = $request->pekerjaan;
        $renev->satuan = $request->satuan;
        $renev->volume = $request->volume;
        $renev->total_material = $request->total_material;
        $renev->total_jasa = $request->total_jasa;
        $renev->jumlah_pagu = $request->jumlah_pagu;

        // Save the Renev instance to the database
        $renev->save();

        // Redirect with success message
        return redirect()->route('halrenev')->with('success', 'Data berhasil disimpan.');
    }

    // Menampilkan data Renev berdasarkan ID
    public function show($id)
    {
        // Find the Renev record by ID
        $renev = Renev::find($id);

        if (!$renev) {
            return redirect()->route('halrenev')->with('error', 'Data tidak ditemukan');
        }

        // Return a view with the single Renev record
        return view('halrenev.show', compact('renev'));
    }

    // Memperbarui data Renev berdasarkan ID
    public function update(Request $request, $id)
    {
        // Find the Renev record by ID
        $renev = Renev::find($id);

        if (!$renev) {
            return redirect()->route('halrenev')->with('error', 'Data tidak ditemukan');
        }

        // Validate the updated data
        $request->validate([
            'unsur_id' => 'required|exists:unsurs,id',  // Ensure the foreign key exists in the 'unsurs' table
            'fungsi_id' => 'required|exists:fungis,id', // Ensure the foreign key exists in the 'fungis' table
            'no_prk' => 'required|string',
            'no_skko' => 'required|string',
            'pekerjaan' => 'required|string',
            'satuan' => 'required|string',
            'volume' => 'required|numeric',
            'total_material' => 'required|numeric',
            'total_jasa' => 'required|numeric',
            'jumlah_pagu' => 'required|numeric',
        ]);

        // Update the Renev instance with the validated data
        $renev->unsur_id = $request->unsur_id;
        $renev->fungsi_id = $request->fungsi_id;
        $renev->no_prk = 'PRK.3216.' . $request->no_prk;
        $renev->no_skko = 'SKKO.3216.' . $request->no_skko;
        $renev->pekerjaan = $request->pekerjaan;
        $renev->satuan = $request->satuan;
        $renev->volume = $request->volume;
        $renev->total_material = $request->total_material;
        $renev->total_jasa = $request->total_jasa;
        $renev->jumlah_pagu = $request->jumlah_pagu;

        // Save the updated data
        $renev->save();

        // Redirect with success message
        return redirect()->route('halrenev')->with('success', 'Data berhasil diperbarui.');
    }

    // Menghapus data Renev berdasarkan ID
    public function destroy($id)
    {
        // Find the Renev record by ID
        $renev = Renev::find($id);

        if (!$renev) {
            return redirect()->route('halrenev')->with('error', 'Data tidak ditemukan');
        }

        // Delete the Renev record
        $renev->delete();

        // Redirect with success message
        return redirect()->route('halrenev')->with('success', 'Data berhasil dihapus.');
    }
}
