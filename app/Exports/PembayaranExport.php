<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PembayaranExport implements FromArray, WithHeadings, WithMapping, WithColumnFormatting
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    // Data isi tabel
    public function array(): array
    {
        return $this->data;
    }

    // Header kolom
    public function headings(): array
    {
        return [
            'No Kontrak',
            'Jumlah Pembayaran (Rp)',
            'Progres (%)',
            'Keterangan',
            'Tanggal Upload'
        ];
    }

    // Format setiap baris data
    public function map($row): array
    {
        return [
            $row[0], // No Kontrak
            $row[1], // Jumlah Pembayaran
            $row[2], // Progres
            $row[3], // Keterangan
            $row[4], // Tanggal Upload
        ];
    }

    // Format kolom Jumlah Pembayaran jadi angka (Rp)
    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1, // Jumlah Pembayaran
        ];
    }
}
