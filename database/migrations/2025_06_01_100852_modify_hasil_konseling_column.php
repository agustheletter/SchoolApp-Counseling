<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tbl_konseling', function (Blueprint $table) {
            // Modify hasil_konseling column to allow null and set default to null
            $table->text('hasil_konseling')->nullable()->default(null)->change();
        });
    }

    public function down()
    {
        Schema::table('tbl_konseling', function (Blueprint $table) {
            // Revert back to non-nullable text column
            $table->text('hasil_konseling')->nullable(false)->change();
        });
    }
};