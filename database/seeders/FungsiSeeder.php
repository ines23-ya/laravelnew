<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fungsi;

class FungsiSeeder extends Seeder
{
    public function run()
    {
        Fungsi::create(['nama' => 'K2LH']);
        Fungsi::create(['nama' => 'Tata Usaha']);
        Fungsi::create(['nama' => 'Transmisi']);
    }
}
