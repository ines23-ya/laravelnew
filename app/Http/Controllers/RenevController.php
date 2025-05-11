<?php
namespace App\Http\Controllers;

use App\Models\Renev;
use App\Models\Unsur;  // Model untuk tabel unsurs
use App\Models\Fungsi; // Model untuk tabel fungis
use Illuminate\Http\Request;

class RenevController extends Controller
{
    public function index()
    {
        // Ambil data dari tabel 'unsurs' dan 'fungis'
        $unsurs = Unsur::all();  // Mengambil semua data dari tabel 'unsurs'
        $fungis = Fungsi::all();  // Mengambil semua data dari tabel 'fungis'

        // Kirim data ke view 'halrenev'
        return view('halrenev', compact('unsurs', 'fungis'));
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'unsur_id' => 'required|exists:unsurs,id',
            'fungsi_id' => 'required|exists:fungsis,id',
            'no_prk' => 'required|string',
            'no_skko' => 'required|string',
            'pekerjaan' => 'required|string',
            'satuan' => 'required|string',
            'volume' => 'required|numeric',
            'total_material' => 'required|numeric',
            'total_jasa' => 'required|numeric',
            'jumlah_pagu' => 'required|numeric',
        ]);

        // Simpan data
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

        $renev->save();

        return redirect()->route('halrenev')->with('success', 'Data berhasil disimpan.');
    }
}
