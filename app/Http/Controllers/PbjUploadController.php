<?php

namespace App\Http\Controllers;

use App\Models\Fungsi;
use App\Models\Pengadaan;
use App\Models\Renev;
use App\Models\Unsur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PengadaanExport; // Importing the Excel export class
use Barryvdh\DomPDF\Facade\Pdf;

class PbjUploadController extends Controller
{
    // Menampilkan halaman pengadaan
    public function index()
    {
        $pengadaan = Renev::with(['unsur', 'fungsi'])->get();
        return view('pengadaan.index', compact('pengadaan'));
    }

    // Menyimpan data pengadaan
    public function store(Request $request)
    {
        // Your existing store method logic
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

        // Your existing logic for storing data...
        $noPrkData = session('form_data')['no_prk'];
        $renevData = Renev::where('no_prk', $noPrkData)->first();

        if (!$renevData) {
            return redirect()->back()->withErrors('Data PRK tidak ditemukan di tabel Renev.');
        }

        // Saving the data and document as before...
        $file = $request->file('dokumen');
        $dokumenPath = $file->store('temp_dokumen');
        $formData = session('form_data');

        $dataBaru = array_merge($validated, [
            'unsur_id'       => $formData['unsur'],
            'fungsi_id'      => $formData['fungsi'],
            'no_prk'         => $formData['no_prk'],
            'dokumen'        => $dokumenPath,
            'dokumen_name'   => $file->getClientOriginalName(),
            'jangka_waktu'   => Carbon::parse($validated['jangka_mulai'])->diffInDays(Carbon::parse($validated['jangka_akhir'])) + 1,
            'renev_id'       => $renevData->id,
        ]);

        Pengadaan::create($dataBaru);

        return redirect()->route('pengadaan.reports')->with('success', 'Data berhasil disimpan.');
    }

    // Menampilkan halaman hasil pengadaan
    public function indexs()
    {
        $dataPengadaan = Pengadaan::with(['unsur', 'fungsi', 'renev'])->get();
        return view('pengadaan.hasilpengadaan', compact('dataPengadaan'));
    }

    // Fungsi untuk mendownload data dalam format Excel
    public function downloadExcel()
    {
        $dataPengadaan = Pengadaan::with(['unsur', 'fungsi', 'renev'])->get();
        return Excel::download(new PengadaanExport($dataPengadaan), 'data_pengadaan.xlsx');
    }

    // Fungsi untuk mendownload data dalam format PDF
    public function downloadPdf()
    {
        $dataPengadaan = Pengadaan::with(['unsur', 'fungsi', 'renev'])->get();
        $pdf = Pdf::loadView('pengadaan.pdf', compact('dataPengadaan'));
        return $pdf->download('data_pengadaan.pdf');
    }
}
