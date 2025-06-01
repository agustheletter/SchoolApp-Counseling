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
        // First modify tbl_konselingrequest id column
        Schema::table('tbl_konselingrequest', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned()->change();
        });

        // Then modify tbl_konseling idkonseling column
        Schema::table('tbl_konseling', function (Blueprint $table) {
            $table->bigInteger('idkonseling')->unsigned()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_konselingrequest', function (Blueprint $table) {
            $table->bigInteger('id')->change();
        });

        Schema::table('tbl_konseling', function (Blueprint $table) {
            $table->bigInteger('idkonseling')->change();
        });
    }
};
