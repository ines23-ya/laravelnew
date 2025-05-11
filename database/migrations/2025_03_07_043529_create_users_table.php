<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Pastikan tabel 'users' belum ada sebelum membuatnya
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('nik')->unique();
                $table->string('username')->unique();
                $table->string('email')->unique();
                $table->string('bidang');
                $table->string('password');
                $table->string('no_hp', 20);
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
