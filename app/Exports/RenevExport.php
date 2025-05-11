<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class RenevExport implements FromCollection, WithTitle, WithEvents
{
    protected $renevs;

    public function __construct($renevs)
    {
        $this->renevs = $renevs;
    }

    public function collection()
    {
        // Map through the data to match the format we want in Excel (with relations)
        return $this->renevs->map(function ($renev) {
            return [
                'unsur' => $renev->unsur->name ?? 'N/A',  // Get the name from the related "unsur"
                'fungsi' => $renev->fungsi->name ?? 'N/A',  // Get the name from the related "fungsi"
                'no_skko' => $renev->no_skko,
                'no_prk' => $renev->no_prk,
                'pekerjaan' => $renev->pekerjaan,
                'satuan' => $renev->satuan,
                'volume' => $renev->volume,
                'total_material' => $renev->total_material,
                'total_jasa' => $renev->total_jasa,
                'jumlah_pagu' => $renev->jumlah_pagu,
            ];
        });
    }

    public function title(): string
    {
        return 'Renevs Report';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Add title row for the report (row 1)
                $event->sheet->insertNewRowBefore(1, 1);
                $event->sheet->mergeCells('A1:J1');
                $event->sheet->setCellValue('A1', 'LAPORAN DATA RENEV');

                // Styling the title row
                $event->sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 16,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // Column headers (row 2)
                $event->sheet->getStyle('A2:J2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                // Set column headers (ensure correct column order)
                $event->sheet->setCellValue('A2', 'Unsur');
                $event->sheet->setCellValue('B2', 'Fungsi');
                $event->sheet->setCellValue('I2', 'SKKO');
                $event->sheet->setCellValue('J2', 'No PRK');
                $event->sheet->setCellValue('C2', 'Pekerjaan');
                $event->sheet->setCellValue('D2', 'Satuan');
                $event->sheet->setCellValue('E2', 'Volume');
                $event->sheet->setCellValue('F2', 'Total Material (Rp)');
                $event->sheet->setCellValue('G2', 'Total Jasa (Rp)');
                $event->sheet->setCellValue('H2', 'Jumlah Pagu (Rp)');
          

                // Apply borders to the entire table (including header)
                $highestRow = $event->sheet->getHighestRow();
                $highestColumn = $event->sheet->getHighestColumn();
                $event->sheet->getStyle("A2:{$highestColumn}{$highestRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                // Set the number format for the currency fields (Total Material, Total Jasa, and Jumlah Pagu)
                $event->sheet->getStyle('F2:F' . $highestRow)->getNumberFormat()->setFormatCode('#,##0');
                $event->sheet->getStyle('G2:G' . $highestRow)->getNumberFormat()->setFormatCode('#,##0');
                $event->sheet->getStyle('H2:H' . $highestRow)->getNumberFormat()->setFormatCode('#,##0');

                // Auto-size columns
                foreach (range('A', 'J') as $col) {
                    $event->sheet->getDelegate()->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }
}
