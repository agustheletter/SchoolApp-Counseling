<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tbl_konseling', function (Blueprint $table) {
            // Drop the existing foreign key if it exists
            $table->dropForeign(['idsiswa']);
            
            // Add new foreign key referencing tbl_users
            $table->foreign('idsiswa')
                  ->references('id')
                  ->on('tbl_users')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('tbl_konseling', function (Blueprint $table) {
            // Drop the new foreign key
            $table->dropForeign(['idsiswa']);
            
            // Re-add the original foreign key to tbl_siswa
            $table->foreign('idsiswa')
                  ->references('idsiswa')
                  ->on('tbl_siswa')
                  ->onDelete('cascade');
        });
    }
};