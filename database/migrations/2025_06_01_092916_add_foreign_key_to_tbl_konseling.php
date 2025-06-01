<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tbl_konseling', function (Blueprint $table) {
            // Add the foreign key constraint
            $table->foreign('idkonseling')
                  ->references('id')
                  ->on('tbl_konselingrequest')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('tbl_konseling', function (Blueprint $table) {
            $table->dropForeign(['tbl_konseling_idkonseling_foreign']);
        });
    }
};