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
        Schema::create('tbl_kelasdetail', function (Blueprint $table) {
            $table->integer('idkelasdetail')->autoIncrement()->unsigned();
            $table->integer('idkelas')->unsigned();
            $table->integer('idthnajaran');
            $table->integer('idguru');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('idkelas')->references('idkelas')->on('tbl_kelas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_kelasdetail');
    }
};
