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
        Schema::create('tbl_kelas', function (Blueprint $table) {
            $table->increments('idkelas')->autoIncrement()->unsigned();
            $table->string('namakelas');
            $table->integer('idjurusan')->unsigned();
            $table->integer('idtingkat')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('idjurusan')->references('idjurusan')->on('tbl_jurusan')->onDelete('cascade');
            $table->foreign('idtingkat')->references('idtingkat')->on('tbl_tingkat')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_kelas');
    }
};
