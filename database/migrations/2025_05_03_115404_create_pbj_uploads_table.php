<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePbjUploadsTable extends Migration
{
    public function up()
    {
        Schema::create('pbj_uploads', function (Blueprint $table) {
            $table->id();
            $table->string('no_kontrak');
            $table->string('judul_kontrak');
            $table->date('tanggal_kontrak');
            $table->date('jangka_mulai');
            $table->date('jangka_akhir');
            $table->integer('jangka_waktu'); // jumlah hari
            $table->string('vendor_pelaksana');
            $table->decimal('nilai_kontrak', 20, 2);
            $table->string('dokumen'); // path dokumen
            $table->string('dokumen_name'); // nama asli file
            $table->string('unsur');
            $table->string('fungsi');
            $table->string('no_prk');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pbj_uploads');
    }
}
