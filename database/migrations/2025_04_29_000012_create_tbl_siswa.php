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
        Schema::create('tbl_siswa', function (Blueprint $table) {
            $table->integer('idsiswa')->autoIncrement()->unsigned();
            $table->string('nis');
            $table->string('nisn');
            $table->string('namasiswa');
            $table->string('tempatlahir');
            $table->date('tgllahir');
            $table->enum('jenkel', ['L', 'P']);
            $table->string('alamat');
            $table->integer('idjurusan')->unsigned();
            $table->integer('idprogramkeahlian')->unsigned();
            $table->integer('idagama')->unsigned();
            $table->string('tlprumah');
            $table->string('hpsiswa');
            $table->string('photosiswa');
            $table->integer('idthnmasuk');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('idjurusan')->references('idjurusan')->on('tbl_jurusan')->onDelete('cascade');
            $table->foreign('idprogramkeahlian')->references('idprogramkeahlian')->on('tbl_programkeahlian')->onDelete('cascade');
            $table->foreign('idagama')->references('idagama')->on('tbl_agama')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_siswa');
    }
};
