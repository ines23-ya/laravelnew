<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class RenevExport implements FromArray, WithTitle, WithEvents
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        // Heading kolom sebagai baris pertama data
        $header = [
            'Unsur',
            'Fungsi',
            'Pekerjaan',
            'Satuan',
            'Volume',
            'Total Material (Rp)',
            'Total Jasa (Rp)',
            'Jumlah Pagu (Rp)',
            'SKKO',
            'No PRK'
        ];

        // Format data baris
        $rows = array_map(function ($item) {
            return [
                $item['unsur'] ?? '',
                $item['fungsi'] ?? '',
                $item['pekerjaan'] ?? '',
                $item['satuan'] ?? '',
                $item['volume'] ?? '',
                $item['total_material'] ?? '',
                $item['total_jasa'] ?? '',
                $item['jumlah_pagu'] ?? '',
                $item['no_skko'] ?? '',
                $item['no_prk'] ?? '',
            ];
        }, $this->data);

        return array_merge([$header], $rows);
    }

    public function title(): string
    {
        return 'Laporan Renev';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Tambahkan baris untuk judul besar
                $event->sheet->insertNewRowBefore(1, 1);
                $event->sheet->mergeCells('A1:J1');
                $event->sheet->setCellValue('A1', 'LAPORAN DATA RENEV');

                // Style untuk judul besar
                $event->sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 16,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // Border seluruh tabel (termasuk heading)
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

                // Bold untuk baris heading kolom (baris ke-2)
                $event->sheet->getStyle('A2:J2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                ]);

                // Auto-size kolom agar menyesuaikan isi
                foreach (range('A', 'J') as $col) {
                    $event->sheet->getDelegate()->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }
}
