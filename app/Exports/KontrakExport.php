<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class KontrakExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data->map(function ($item) {
            return [
                $item['pekerjaan'] ?? '',
                $item['no_kontrak'] ?? '',
                $item['tanggal_kontrak'] ?? '',
                $item['nilai'] ?? '',
                $item['progres'] ?? '',
                $item['keterangan'] ?? '',
                $item['bp_lkp'] ?? '',
                $item['bp_st'] ?? '',
                $item['bp_pp'] ?? '',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Pekerjaan',
            'No Kontrak',
            'Tanggal Kontrak',
            'Nilai Kontrak',
            'Progres (%)',
            'Keterangan',
            'BP LKP',
            'BP ST',
            'BP PP',
        ];
    }
}
