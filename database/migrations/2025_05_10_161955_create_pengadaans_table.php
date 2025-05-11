<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengadaans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unsur_id')->nullable();
            $table->unsignedBigInteger('fungsi_id')->nullable();
            $table->unsignedBigInteger('renev_id'); // relasi ke tabel renevs

            $table->string('no_kontrak');
            $table->string('judul_kontrak');
            $table->date('tanggal_kontrak');
            $table->date('jangka_mulai');
            $table->date('jangka_akhir');
            $table->string('vendor_pelaksana');
            $table->decimal('nilai_kontrak', 20, 2);
            $table->string('dokumen')->nullable();
            $table->string('dokumen_name')->nullable();
            $table->string('jangka_waktu')->nullable();

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('unsur_id')->references('id')->on('unsurs')->onDelete('set null');
            $table->foreign('fungsi_id')->references('id')->on('fungsis')->onDelete('set null');
            $table->foreign('renev_id')->references('id')->on('renevs')->onDelete('cascade');
        });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengadaans');
    }
};
