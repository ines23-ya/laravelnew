<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKontruksisTable extends Migration
{
    public function up()
    {
        Schema::create('kontruksis', function (Blueprint $table) {
            $table->id();
            $table->string('pekerjaan');           // Nama pekerjaan
            $table->string('no_kontrak');          // Nomor kontrak
            $table->date('tanggal_kontrak')->nullable(); // Tanggal kontrak (nullable)
            $table->decimal('nilai', 20, 2)->default(0); // Nilai kontrak, default 0
            $table->unsignedTinyInteger('progres')->default(0); // Progres (0-100)
            $table->text('keterangan')->nullable(); // Keterangan (nullable)
            $table->string('bp_lkp'); // Path file BA LKP
            $table->string('bp_st');  // Path file BA ST
            $table->string('bp_pp');  // Path file BA PP
            $table->timestamps(); // Created at & Updated at
        });
    }

    public function down()
    {
        Schema::dropIfExists('kontruksis'); // Menghapus tabel jika rollback
    }
}
