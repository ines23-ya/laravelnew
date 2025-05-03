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
        Schema::create('renev_inputs', function (Blueprint $table) {
            $table->id();
            $table->string('unsur')->nullable();
            $table->string('fungsi')->nullable();
            $table->string('satuan')->nullable();
            $table->integer('volume')->nullable();
            $table->string('no_prk')->nullable();
            $table->string('skko')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->double('total_material')->nullable();
            $table->double('total_jasa')->nullable();
            $table->double('jumlah_pagu')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('renev_inputs');
    }
};
