<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRenevsTable extends Migration
{
    public function up()
    {
        Schema::create('renevs', function (Blueprint $table) {
            $table->id();

            // Other columns
            $table->string('no_skko');
            $table->string('pekerjaan');
            $table->string('satuan');
            $table->decimal('volume', 10, 2);
            $table->decimal('total_material', 15, 2);
            $table->decimal('total_jasa', 15, 2);
            $table->decimal('jumlah_pagu', 15, 2);

            // Timestamps
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('renevs');
    }
}
