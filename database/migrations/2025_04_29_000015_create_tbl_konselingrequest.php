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
        Schema::create('tbl_konselingrequest', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->unsigned();
            $table->bigInteger('idsiswa')->unsigned();
            $table->text('deskripsi');
            $table->datetime('tanggal_permintaan');
            $table->enum('status', ['Pending', 'Approved', 'Rejected']);
            $table->timestamps();

            $table->foreign('idsiswa')->references('idsiswa')->on('tbl_siswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_konselingrequest');
    }
};
