<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'nik' => '1234567890',
                'bidang' => 'admin',
                'email' => 'admin@example.com',
                'no_hp' => '08123456789',
                'password' => Hash::make('admin123!'), // Hashed password
            ]
        );
    }
}
