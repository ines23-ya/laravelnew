<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ReportPengadaanController extends Controller
{
    /**
     * Tampilkan halaman laporan pengadaan.
     */
    public function index()
    {
        $data_pbj = session('data_pbj', []);

        return view('reports.pengadaan', compact('data_pbj'));
    }

    /**
     * Export data pengadaan ke file Excel.
     */
    public function exportExcel()
    {
        $data_pbj = session('data_pbj', []);

        $exportData = collect($data_pbj)->map(function ($item) {
            return [
                'Unsur'             => $item['unsur'] ?? '-',
                'Fungsi'            => $item['fungsi'] ?? '-',
                'No PRK'            => $item['no_prk'] ?? '-',
                'No Kontrak'        => $item['no_kontrak'] ?? '-',
                'Judul Kontrak'     => $item['judul_kontrak'] ?? '-',
                'Tanggal Kontrak'   => Carbon::parse($item['tanggal_kontrak'])->format('d-m-Y') ?? '-',
                'Vendor Pelaksana'  => $item['vendor_pelaksana'] ?? '-',
                'Nilai Kontrak'     => $item['nilai_kontrak'] ?? '-',
                'Jangka Waktu (hari)' => $item['jangka_waktu'] ?? '-',
            ];
        });

        return Excel::download(new \App\Exports\PengadaanExport($exportData), 'laporan_pengadaan.xlsx');
    }

    /**
     * Export data pengadaan ke file PDF.
     */
    public function exportPDF()
{
    $data_pbj = session('data_pbj', []);

    $pdf = Pdf::loadView('reports.pengadaan_pdf', compact('data_pbj'))
        ->setPaper('A4', 'landscape'); // tambahkan ini supaya tabel tidak terpotong

    return $pdf->download('laporan_pengadaan.pdf');
}


    /**
     * Download file dokumen pengadaan.
     */
    public function download($filename)
    {
        $path = storage_path('app/temp_dokumen/' . $filename);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->download($path);
    }
}
