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
        Schema::create('tbl_siswakelas', function (Blueprint $table) {
            $table->integer('idsiswakelas')->autoIncrement()->unsigned();
            $table->bigInteger('idsiswa')->unsigned();
            $table->integer('idkelasdetail')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('idsiswa')->references('idsiswa')->on('tbl_siswa')->onDelete('cascade');
            $table->foreign('idkelasdetail')->references('idkelasdetail')->on('tbl_kelasdetail')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_siswakelas');
    }
};
