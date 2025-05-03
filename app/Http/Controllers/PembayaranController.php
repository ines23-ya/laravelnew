<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\PembayaranExport;

class PembayaranController extends Controller
{
    // Menyimpan pembayaran ke session
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_kontrak' => 'required|string',
            'jumlah_pembayaran' => 'required|numeric|min:0',
            'progres' => 'required|numeric|min:0|max:100',
            'keterangan' => 'required|string',
            'tanggal_upload' => 'required|date',
            'ba_pembayaran' => 'required|file|mimes:pdf|max:2048',
        ]);

        $path = $request->file('ba_pembayaran')->store('uploads', 'public');

        $pembayaran = session('data_pembayaran', []);
        $pembayaran[] = [
            'no_kontrak' => $validated['no_kontrak'],
            'jumlah_pembayaran' => $validated['jumlah_pembayaran'],
            'progres' => $validated['progres'],
            'keterangan' => $validated['keterangan'],
            'tanggal_upload' => $validated['tanggal_upload'],
            'file_path' => $path,
        ];

        session(['data_pembayaran' => $pembayaran]);

        return redirect()->route('keuangan')->with('success', 'Pembayaran berhasil diinput.');
    }

    // Menampilkan laporan keuangan
    public function reports()
    {
        $pembayaran = session('data_pembayaran', []);
        return view('reportskeuangan', ['data_pembayaran' => $pembayaran]);
    }

    // Export ke Excel
    public function exportExcel()
    {
        $pembayaran = session('data_pembayaran', []);

        // TANPA HEADER MANUAL
        $rows = collect($pembayaran)->map(function ($item) {
            return [
                $item['no_kontrak'],
                $item['jumlah_pembayaran'],
                $item['progres'],
                $item['keterangan'],
                $item['tanggal_upload'],
            ];
        })->toArray();

        return Excel::download(new PembayaranExport($rows), 'laporan-pembayaran.xlsx');
    }

    // Export ke PDF
    public function exportPdf()
    {
        $pembayaran = session('data_pembayaran', []);
        $pdf = Pdf::loadView('reports.pdf1', compact('pembayaran'));
        return $pdf->download('laporan-pembayaran.pdf');
    }
}
