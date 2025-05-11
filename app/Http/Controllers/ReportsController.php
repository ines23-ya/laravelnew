<?php
namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Models\Renev;  // Add this line to import the Renev model
use App\Exports\RenevExport; // Ensure this is imported for the export class
use Barryvdh\DomPDF\Facade\Pdf; // Import the PDF facade for exporting to PDF
use App\Models\Fungsi;
use App\Models\Unsur;

class ReportsController extends Controller
{
    // Method to display the reports page
    public function index()
    {
        // Fetch data for reports
        $renevs = Renev::with(['unsur', 'fungsi'])->get();
        $unsurs = Unsur::all();
        $fungsis = Fungsi::all();
        return view('reports.index', compact('renevs', 'unsurs', 'fungsis'));
    }

    // Export data to Excel
    public function exportExcel()
    {
        // Fetch the Renev data with relationships (Unsur, Fungsi)
        $renevs = Renev::with(['unsur', 'fungsi'])->get();

        // Export the data to Excel with the transformed data
        return Excel::download(new RenevExport($renevs), 'laporan_renev.xlsx');
    }

    // Export data to PDF
    public function exportPDF()
    {
        // Fetch all Renev data with relationships (Unsur and Fungsi)
        $renevs = Renev::with(['unsur', 'fungsi'])->get();
    
        // Pass the fetched data to the PDF view
        $pdf = Pdf::loadView('reports.pdf', ['renevData' => $renevs])
            ->setPaper('A4', 'landscape');  // Set paper orientation to landscape
    
        // Download the PDF
        return $pdf->download('laporan_renev.pdf');
    }
}
