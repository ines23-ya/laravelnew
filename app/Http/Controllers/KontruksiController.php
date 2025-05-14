<?php

namespace App\Http\Controllers;

use App\Models\Pengadaan;
use App\Models\Kontruksi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\KontruksiExport;

class KontruksiController extends Controller
{
    // Menampilkan halaman untuk input data kontruksi berdasarkan no_kontrak
    public function index(Request $request)
    {
        // Ambil semua data no_kontrak yang ada di tabel Pengadaan
        $pengadaan = Pengadaan::all();
        return view('halkontruksi', compact('pengadaan'));
    }

    // Menampilkan hasil kontruksi dan data pengadaan terkait
    public function indexs(Request $request)
    {
        // Ambil semua data kontruksi dan pengadaan berdasarkan no_kontrak
        $pengadaan = Pengadaan::all();
        $kontruksi = Kontruksi::with('pengadaan')->get();  // Load related Pengadaan data
        return view('halkontruksi', compact('pengadaan', 'kontruksi'));
    }

    // Menyimpan data kontruksi baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pekerjaan' => 'required|string',
            'nomor_kontrak' => 'required|string',
            'progres' => 'required|numeric|min:0|max:100',
            'keterangan' => 'nullable|string',
            'bp_lkp' => 'required|file|mimes:pdf',
            'bp_st' => 'required|file|mimes:pdf',
            'bp_pp' => 'required|file|mimes:pdf',
        ]);

        // Membuat instance baru dari model Kontruksi
        $kontruksi = new Kontruksi([
            'pekerjaan' => $validated['pekerjaan'],
            'no_kontrak' => $validated['nomor_kontrak'],
            'progres' => $validated['progres'],
            'keterangan' => $validated['keterangan'] ?? '',
            'bp_lkp' => $request->file('bp_lkp')->store('pdf', 'public'),
            'bp_st' => $request->file('bp_st')->store('pdf', 'public'),
            'bp_pp' => $request->file('bp_pp')->store('pdf', 'public'),
        ]);

        // Menyimpan data kontruksi ke dalam database
        $kontruksi->save();

        // Mengarahkan ke halaman hasil kontruksi dengan pesan sukses
        return redirect()->route('hasilkontrak')->with('success', 'Data kontruksi berhasil disimpan!');
    }

    // Menampilkan hasil kontruksi
    public function hasil()
    {
        $kontruksi = Kontruksi::all(); // Ambil semua data kontruksi
        return view('hasilkontrak', compact('kontruksi'));
    }

    // Menampilkan halaman input kontruksi berdasarkan no_kontrak
    public function inputkontruksi(Request $request)
    {
        // Mengambil no_kontrak dari query string
        $no_kontrak = $request->query('no_kontrak');
        return view('inputkontrak', compact('no_kontrak'));
    }

    // Menampilkan form edit kontruksi
    public function edit($id)
    {
        // Fetch the kontruksi data by id
        $kontruksi = Kontruksi::findOrFail($id);

        // Return the edit view with the kontruksi data
        return view('kontruksi.edit', compact('kontruksi'));
    }

    // Menyimpan perubahan data kontruksi
    public function update(Request $request, $id)
    {
        $kontruksi = Kontruksi::findOrFail($id); // Find the kontruksi by id

        // Validate the incoming data
        $validated = $request->validate([
            'pekerjaan' => 'required|string',
            'nomor_kontrak' => 'required|string',
            'progres' => 'required|numeric|min:0|max:100',
            'keterangan' => 'nullable|string',
            'bp_lkp' => 'nullable|file|mimes:pdf',
            'bp_st' => 'nullable|file|mimes:pdf',
            'bp_pp' => 'nullable|file|mimes:pdf',
        ]);

        // Update the kontruksi fields
        $kontruksi->pekerjaan = $validated['pekerjaan'];
        $kontruksi->no_kontrak = $validated['nomor_kontrak'];
        $kontruksi->progres = $validated['progres'];
        $kontruksi->keterangan = $validated['keterangan'];

        // Update the files if new files are uploaded
        if ($request->hasFile('bp_lkp')) {
            $kontruksi->bp_lkp = $request->file('bp_lkp')->store('pdf', 'public');
        }
        if ($request->hasFile('bp_st')) {
            $kontruksi->bp_st = $request->file('bp_st')->store('pdf', 'public');
        }
        if ($request->hasFile('bp_pp')) {
            $kontruksi->bp_pp = $request->file('bp_pp')->store('pdf', 'public');
        }

        // Save the changes to the database
        $kontruksi->save();

        // Redirect to the result page with a success message
        return redirect()->route('hasilkontrak')->with('success', 'Data kontruksi berhasil diperbarui!');
    }

    // Export data ke Excel
    public function exportExcel()
    {
        return Excel::download(new KontruksiExport, 'kontruksi.xlsx');
    }

    // Export data ke PDF
    public function exportPDF()
    {
        // Fetch all Kontruksi data
        $kontruksi = Kontruksi::all(); // Adjust this to filter the data as needed

        // Generate the PDF with the correct capitalization for the PDF facade
        $pdf = PDF::loadView('kontruksi.pdf', compact('kontruksi'));  // PDF::loadView is the correct method

        // Return the generated PDF for download
        return 
        $pdf->download('kontruksi.pdf');
    }
    public function destroy($id)
{
    // Find the Kontruksi by ID
    $kontruksi = Kontruksi::findOrFail($id);

    // Delete the kontruksi
    $kontruksi->delete();

    // Redirect back to the kontruksi listing page with a success message
    return redirect()->route('hasilkontrak')->with('success', 'Data kontruksi berhasil dihapus!');
}
}
