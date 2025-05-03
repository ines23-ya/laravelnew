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
            $table->string('pekerjaan');
            $table->string('no_kontrak');
            $table->date('tanggal_kontrak')->nullable();
            $table->decimal('nilai', 20, 2)->default(0);
            $table->unsignedTinyInteger('progres'); // 0-100
            $table->text('keterangan')->nullable();
            $table->string('bp_lkp'); // path file
            $table->string('bp_st');  // path file
            $table->string('bp_pp');  // path file
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kontruksis');
    }
}
