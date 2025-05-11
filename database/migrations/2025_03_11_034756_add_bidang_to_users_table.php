<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom 'bidang' hanya jika kolom tersebut belum ada
            if (!Schema::hasColumn('users', 'bidang')) {
                $table->string('bidang')->after('email')->nullable(); // Menambahkan kolom 'bidang' setelah email
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Menghapus kolom 'bidang' jika rollback
            $table->dropColumn('bidang');
        });
    }
};
