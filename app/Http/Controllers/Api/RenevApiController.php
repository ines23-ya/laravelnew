<?php
namespace App\Http\Controllers\Api;

use App\Models\Renev;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RenevApiController extends Controller
{
    // Menampilkan semua data Renev
    public function index()
    {
        $renevs = Renev::all(); // Mengambil semua data dari tabel 'renevs'
        return response()->json($renevs); // Mengembalikan data dalam format JSON
    }

    // Menyimpan data Renev baru
    public function store(Request $request)
    {
        $request->validate([
            'unsur' => 'required|string',
            'fungsi' => 'required|string',
            'no_prk' => 'required|string',
            'no_skko' => 'required|string',
            'pekerjaan' => 'required|string',
            'satuan' => 'required|string',
            'volume' => 'required|numeric',
            'total_material' => 'required|numeric',
            'total_jasa' => 'required|numeric',
            'jumlah_pagu' => 'required|numeric',
        ]);

        // Simpan data baru ke dalam database
        $renev = new Renev();
        $renev->unsur_id = $request->unsur;
        $renev->fungsi_id = $request->fungsi;
        $renev->no_prk = 'PRK.3216.' . $request->no_prk;
        $renev->no_skko = 'SKKO.3216.' . $request->no_skko;
        $renev->pekerjaan = $request->pekerjaan;
        $renev->satuan = $request->satuan;
        $renev->volume = $request->volume;
        $renev->total_material = $request->total_material;
        $renev->total_jasa = $request->total_jasa;
        $renev->jumlah_pagu = $request->jumlah_pagu;

        // Simpan ke dalam database
        $renev->save();

        return response()->json($renev, 201); // Mengembalikan data yang baru dibuat dengan status 201
    }

    // Menampilkan data Renev berdasarkan ID
    public function show($id)
    {
        $renev = Renev::find($id);

        if (!$renev) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($renev); // Mengembalikan data dalam format JSON
    }

    // Memperbarui data Renev berdasarkan ID
    public function update(Request $request, $id)
    {
        $renev = Renev::find($id);

        if (!$renev) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $request->validate([
            'unsur' => 'required|string',
            'fungsi' => 'required|string',
            'no_prk' => 'required|string',
            'no_skko' => 'required|string',
            'pekerjaan' => 'required|string',
            'satuan' => 'required|string',
            'volume' => 'required|numeric',
            'total_material' => 'required|numeric',
            'total_jasa' => 'required|numeric',
            'jumlah_pagu' => 'required|numeric',
        ]);

        $renev->update($request->all()); // Update data Renev berdasarkan input request

        return response()->json($renev); // Mengembalikan data yang sudah diperbarui dalam format JSON
    }

    // Menghapus data Renev berdasarkan ID
    public function destroy($id)
    {
        $renev = Renev::find($id);

        if (!$renev) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $renev->delete(); // Menghapus data Renev berdasarkan ID

        return response()->json(['message' => 'Data berhasil dihapus'], 200); // Mengembalikan status 200 setelah penghapusan
    }
}
