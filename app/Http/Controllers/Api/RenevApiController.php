<?php
namespace App\Http\Controllers\Api;

use App\Models\Renev;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class RenevApiController extends Controller
{
    // Menampilkan semua data Renev
    public function index()
    {
        $renevs = Renev::all(); // Mengambil semua data dari tabel 'renevs'
        Log::info('Menampilkan semua data Renev', ['total' => $renevs->count()]); // Menambahkan log untuk aksi ini
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

        Log::info('Data Renev baru disimpan', ['renev_id' => $renev->id]); // Menambahkan log ketika data baru disimpan

        return response()->json($renev, 201); // Mengembalikan data yang baru dibuat dengan status 201
    }

    // Menampilkan data Renev berdasarkan ID
    public function show($id)
    {
        $renev = Renev::find($id);

        if (!$renev) {
            Log::warning('Data Renev tidak ditemukan', ['id' => $id]); // Menambahkan log jika data tidak ditemukan
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        Log::info('Menampilkan data Renev', ['id' => $id]); // Menambahkan log ketika data ditemukan
        return response()->json($renev); // Mengembalikan data dalam format JSON
    }

    // Memperbarui data Renev berdasarkan ID
    public function update(Request $request, $id)
    {
        $renev = Renev::find($id);

        if (!$renev) {
            Log::warning('Data Renev tidak ditemukan untuk update', ['id' => $id]); // Menambahkan log jika data tidak ditemukan untuk update
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

        Log::info('Data Renev berhasil diperbarui', ['renev_id' => $renev->id]); // Menambahkan log setelah data berhasil diperbarui
        return response()->json($renev); // Mengembalikan data yang sudah diperbarui dalam format JSON
    }

    // Menghapus data Renev berdasarkan ID
    public function destroy($id)
    {
        $renev = Renev::find($id);

        if (!$renev) {
            Log::warning('Data Renev tidak ditemukan untuk dihapus', ['id' => $id]); // Menambahkan log jika data tidak ditemukan untuk dihapus
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $renev->delete(); // Menghapus data Renev berdasarkan ID

        Log::info('Data Renev berhasil dihapus', ['renev_id' => $id]); // Menambahkan log setelah data dihapus
        return response()->json(['message' => 'Data berhasil dihapus'], 200); // Mengembalikan status 200 setelah penghapusan
    }
}
