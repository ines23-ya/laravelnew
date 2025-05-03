<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\RenevExport;

class ReportsController extends Controller
{
    public function index()
    {
        $rawData = session('form_data');

        // Pastikan $renevData selalu berupa array of data
        $renevData = [];

        if (is_array($rawData)) {
            // Kalau array multi, langsung assign
            if (array_is_list($rawData) && isset($rawData[0]) && is_array($rawData[0])) {
                $renevData = $rawData;
            } else {
                // Kalau hanya satu data asosiatif, bungkus ke dalam array
                $renevData = [$rawData];
            }
        }

        return view('reports.index', compact('renevData'));
    }

    public function exportExcel()
    {
        $data = session('form_data', []);

        if (!is_array($data) || (isset($data['unsur']) && is_string($data['unsur']))) {
            $data = [$data]; // wrap jika satu data saja
        }

        return Excel::download(new RenevExport($data), 'laporan_renev.xlsx');
    }

    public function exportPDF()
    {
        $data = session('form_data', []);
    
        if (!is_array($data) || (isset($data['unsur']) && is_string($data['unsur']))) {
            $data = [$data]; // wrap kalau cuma satu item
        }
    
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.pdf', ['renevData' => $data])
            ->setPaper('A4', 'landscape');
    
        return $pdf->download('laporan_renev.pdf');
    }
    
}
