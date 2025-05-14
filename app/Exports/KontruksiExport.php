<?php

namespace App\Exports;

use App\Models\Kontruksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Carbon\Carbon;

class KontruksiExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
{
    /**
     * Return the collection of Kontruksi data to export
     */
    public function collection()
    {
        return Kontruksi::with('pengadaan')->get();
    }

    /**
     * Define the headings for the Excel file
     */
    public function headings(): array
    {
        return [
            'No', 'Pekerjaan', 'Nilai Kontrak', 'Tanggal Terkontrak', 'Progres %', 'Keterangan'
        ];
    }

    /**
     * Map the data for each row of the export
     */
    public function map($kontruksi): array
    {
        return [
            $kontruksi->id, // No (row number)
            $kontruksi->pekerjaan, // Pekerjaan
            $this->formatDecimal($kontruksi->pengadaan ? $kontruksi->pengadaan->nilai_kontrak : 0), // Nilai Kontrak
            $this->formatDate($kontruksi->pengadaan ? $kontruksi->pengadaan->tanggal_kontrak : null), // Tanggal Terkontrak
            $kontruksi->progres . '%', // Progres %
            $kontruksi->keterangan ?? 'N/A', // Keterangan
        ];
    }

    /**
     * Helper method to format the 'nilai' field as a decimal with 2 decimal places
     */
    private function formatDecimal($value)
    {
        return 'Rp' . number_format($value, 0, ',', '.'); // Format as currency (Rp)
    }

    /**
     * Helper method to format date or return 'N/A' if invalid
     */
    private function formatDate($date)
    {
        if ($date) {
            return Carbon::parse($date)->format('d-m-Y'); // Format the date as d-m-Y
        }
        return 'N/A'; // Return 'N/A' if not a valid date
    }

    /**
     * Return the title for the sheet
     */
    public function title(): string
    {
        return 'Laporan Data Kontruksi'; // Title of the sheet
    }

    /**
     * Apply styles to the sheet, including headers and fixed column widths
     */
    public function styles($sheet)
    {
        // Set the title cell (A1) to be centered, without bold
        $sheet->mergeCells('A1:F1'); // Merge across all columns for the title
        $sheet->getStyle('A1')->getFont()->setBold(false); // Ensure title is not bold
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Set the title text
        $sheet->setCellValue('A1', 'Laporan Data Kontruksi');

        // Make the header row bold, center them, and add borders (for A2:F2)
        $sheet->getStyle('A2:F2')->getFont()->setBold(true); // Set column headers to bold
        $sheet->getStyle('A2:F2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Center align headers

        // Apply border to the header row
        $sheet->getStyle('A2:F2')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        
        // Set the column headers for each column (Pekerjaan, Nilai Kontrak, etc.)
        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'Pekerjaan');
        $sheet->setCellValue('C2', 'Nilai Kontrak');
        $sheet->setCellValue('D2', 'Tanggal Terkontrak');
        $sheet->setCellValue('E2', 'Progres %');
        $sheet->setCellValue('F2', 'Keterangan');

        // Add borders to all cells with data (starting from row 3)
        $sheet->getStyle('A3:F' . (count($this->collection()) + 2))
            ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Set fixed column widths to prevent resizing and ensure spacing between columns
        $sheet->getColumnDimension('A')->setWidth(10); // Set wider column for No (row number)
        $sheet->getColumnDimension('B')->setWidth(25); // Set column width for Pekerjaan
        $sheet->getColumnDimension('C')->setWidth(25); // Set column width for Nilai Kontrak
        $sheet->getColumnDimension('D')->setWidth(20); // Set column width for Tanggal Terkontrak
        $sheet->getColumnDimension('E')->setWidth(15); // Set column width for Progres
        $sheet->getColumnDimension('F')->setWidth(30); // Set column width for Keterangan
    }
}
