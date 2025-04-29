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
        Schema::create('tbl_semester', function (Blueprint $table) {
            $table->integer('idsemester')->autoIncrement();
            $table->integer('idbulan')->unsigned();
            $table->string('semester');
            $table->enum('keterangan', ['Ganjil', 'Genap']);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('idbulan')->references('idbulan')->on('tbl_bulan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_semester');
    }
};
