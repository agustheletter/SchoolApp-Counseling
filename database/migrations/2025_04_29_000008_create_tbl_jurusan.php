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
        Schema::create('tbl_jurusan', function (Blueprint $table) {
            $table->integer('idjurusan')->autoIncrement()->unsigned();
            $table->string('kodejurusan');
            $table->string('namajurusan');
            $table->integer('idprogramkeahlian')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('idprogramkeahlian')->references('idprogramkeahlian')->on('tbl_programkeahlian')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_jurusan');
    }
};
