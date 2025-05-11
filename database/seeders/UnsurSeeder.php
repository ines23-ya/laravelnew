<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unsur;

class UnsurSeeder extends Seeder
{
    public function run()
    {
        $unsurs = [
            ['nama' => 'Non Rutin'],
            ['nama' => 'Rutin - Sewa'],
            ['nama' => 'Rutin Alih Daya'],
            ['nama' => 'Rutin Non Alih Daya'],
        ];

        foreach ($unsurs as $unsur) {
            Unsur::create($unsur);
        }
    }
}
