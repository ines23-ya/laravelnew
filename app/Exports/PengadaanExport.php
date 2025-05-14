<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class PengadaanExport implements FromCollection, WithHeadings, WithStyles, WithColumnFormatting
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        // Format data for export
        return $this->data->map(function ($item) {
            return [
                'unsur' => $item->unsur->nama ?? '-',
                'fungsi' => $item->fungsi->nama ?? '-',
                'no_prk' => $item->renev->no_prk ?? '-',
                'no_kontrak' => $item->no_kontrak ?? '-',
                'judul_kontrak' => $item->judul_kontrak ?? '-',
                'tanggal_kontrak' => Carbon::parse($item->tanggal_kontrak)->format('d-m-Y'),
                'vendor_pelaksana' => $item->vendor_pelaksana ?? '-',
                'nilai_kontrak' => $item->nilai_kontrak,
                'jangka_waktu' => Carbon::parse($item->jangka_mulai)->diffInDays(Carbon::parse($item->jangka_akhir)) + 1,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Unsur',
            'Fungsi',
            'No PRK',
            'No Kontrak',
            'Judul Kontrak',
            'Tanggal Kontrak',
            'Vendor Pelaksana',
            'Nilai Kontrak (Rp)',
            'Jangka Waktu (hari)',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Bold heading
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);

        // Auto width columns
        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Apply border to all cells
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $sheet->getStyle('A1:' . $highestColumn . $highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        // Set autofilter
        $sheet->setAutoFilter('A1:I' . $highestRow);

        return [];
    }

    public function columnFormats(): array
    {
        return [
            'H' => '_([$Rp-421]* #,##0_);_([$Rp-421]* (#,##0);_([$Rp-421]* "-"??_)',  // Format column H (Nilai Kontrak) to Rupiah
        ];
    }
}
