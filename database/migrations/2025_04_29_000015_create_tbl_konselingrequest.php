<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tbl_konselingrequest', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idsiswa');
            $table->unsignedBigInteger('idguru');
            $table->enum('kategori', ['Pribadi', 'Akademik', 'Karir', 'Lainnya']);
            $table->dateTime('tanggal_permintaan');
            $table->text('deskripsi');
            $table->enum('status', ['Pending', 'Approved', 'Rejected', 'Completed'])->default('Pending');
            $table->timestamps();

            $table->foreign('idsiswa')->references('id')->on('tbl_users')->onDelete('cascade');
            $table->foreign('idguru')->references('id')->on('tbl_users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_konselingrequest');
    }
};