<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Menambahkan kolom jika belum ada
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom 'konpass' jika belum ada
            if (!Schema::hasColumn('users', 'konpass')) {
                $table->string('konpass')->nullable(); // Menambahkan kolom 'konpass' nullable
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Menghapus kolom 'konpass' saat rollback
            $table->dropColumn('konpass');
        });
    }
};
