<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeuangansTable extends Migration
{
    public function up()
    {
        Schema::create('keuangans', function (Blueprint $table) {
            $table->id();
            $table->string('no_prk')->nullable(); // Reference from Renevs
            $table->string('no_kontrak'); // Reference from Pengadaans
            $table->string('judul_kontrak')->nullable(); 
            $table->string('pekerjaan');
            $table->decimal('nilai', 15, 2); // Nilai Kontrak from Pengadaans
            $table->string('jangka_waktu')->nullable(); // From Pengadaans
            $table->decimal('progres', 5, 2)->nullable(); // From Kontruksis
            $table->string('bp_lkp')->nullable(); // From Kontruksis
            $table->string('bp_st')->nullable(); // From Kontruksis
            $table->string('bp_pp')->nullable(); // From Kontruksis
            $table->string('keterangan')->nullable(); // From Kontruksis
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('keuangans');
    }
}
