<?php

namespace App\Http\Controllers;

use App\Models\Fungsi;
use App\Models\pengadaan;
use App\Models\Renev;
use App\Models\Unsur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PbjUploadController extends Controller
{

    public function index()
    {
        $pengadaan = Renev::with(['unsur', 'fungsi'])->get();
        return view('pengadaan.index', compact('pengadaan'));
    }



    public function create(Request $request)
    {
        // Ambil query string dari URL
        $noPrk = $request->query('no_prk');
        $unsurId = $request->query('unsur');
        $fungsiId = $request->query('fungsi');

        // Validasi: Pastikan semua query parameter ada
        if (!$noPrk || !$unsurId || !$fungsiId) {
            return redirect()->back()->withErrors('Data tidak lengkap.');
        }

        // Simpan form data ke session
        session([
            'form_data' => [
                'no_prk' => $noPrk,
                'unsur' => $unsurId,
                'fungsi' => $fungsiId,
            ]
        ]);

        // Cari data Renev berdasarkan no_prk yang dikirim
        $noPrkData = Renev::where('no_prk', $noPrk)->first();

        // Jika tidak ditemukan, tampilkan error
        if (!$noPrkData) {
            return redirect()->back()->withErrors('Data PRK tidak ditemukan di tabel Renev.');
        }

        session(['selected_no_prk' => $request->no_prk]);

        // Kirim data ke view
        return view('pengadaan.pilihpengadaan', compact('noPrkData'));
    }

  
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_kontrak'       => 'required',
            'judul_kontrak'    => 'required|string|max:255',
            'tanggal_kontrak'  => 'required|date',
            'jangka_mulai'     => 'required|date',
            'jangka_akhir'     => 'required|date|after_or_equal:jangka_mulai',
            'vendor_pelaksana' => 'required|string|max:255',
            'nilai_kontrak'    => 'required|numeric',
            'dokumen'          => 'required|file|mimes:pdf|max:2048',
        ]);

        // Mendapatkan data PRK dan ID terkait
        $noPrkData = session('form_data')['no_prk'];
        $renevData = Renev::where('no_prk', $noPrkData)->first();

        if (!$renevData) {
            return redirect()->back()->withErrors('Data PRK tidak ditemukan di tabel Renev.');
        }

        // Menyimpan file dokumen
        $file = $request->file('dokumen');
        $dokumenPath = $file->store('temp_dokumen');

        // Mendapatkan form data dari session
        $formData = session('form_data');

        // Pastikan 'unsur' dan 'fungsi' berisi ID yang benar (bukan array atau objek)
        $dataBaru = array_merge($validated, [
            'unsur_id'       => $formData['unsur'],   // Jika 'unsur' adalah string ID
            'fungsi_id'      => $formData['fungsi'],  // Jika 'fungsi' adalah string ID
            'no_prk'         => $formData['no_prk'],
            'dokumen'        => $dokumenPath,
            'dokumen_name'   => $file->getClientOriginalName(),
            'jangka_waktu'   => Carbon::parse($validated['jangka_mulai'])->diffInDays(Carbon::parse($validated['jangka_akhir'])),
            'renev_id'       => $renevData->id,  // Menambahkan renev_id
        ]);

        // Simpan data ke database
        Pengadaan::create($dataBaru);

        return redirect()->route('pengadaan.reports')->with('success', 'Data berhasil disimpan.');
    }

    public function indexs()
    {
        // Mengambil data pengadaan beserta relasi unsur, fungsi, dan renev
        $dataPengadaan = Pengadaan::with(['unsur', 'fungsi', 'renev'])->get();

        return view('pengadaan.hasilpengadaan', compact('dataPengadaan'));
    }

    public function download($filename)
    {
        $path = storage_path('app/temp_dokumen/' . $filename);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->download($path);
    }
}
