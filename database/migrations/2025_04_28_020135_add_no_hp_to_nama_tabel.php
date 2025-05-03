<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nama_tabel', function (Blueprint $table) {
            // Tambahkan kolom baru di sini, JANGAN tambah no_hp lagi kalau sudah ada
        });
    }

    public function down(): void
    {
        Schema::table('nama_tabel', function (Blueprint $table) {
            // Kalau mau rollback, hapus kolom baru di sini
        });
    }
};
