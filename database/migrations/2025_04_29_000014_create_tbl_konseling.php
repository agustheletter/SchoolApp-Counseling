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
        Schema::create('tbl_konseling', function (Blueprint $table) {
            $table->integer('idkonseling')->autoIncrement()->unsigned();
            $table->bigInteger('idsiswa')->unsigned();
            $table->bigInteger('idguru')->unsigned();
            $table->date('tanggal_konseling');
            $table->text('hasil_konseling');
            $table->enum('status', ['Pending', 'Completed', 'Canceled']);
            $table->timestamps();

            $table->foreign('idsiswa')->references('idsiswa')->on('tbl_siswa')->onDelete('cascade');
            $table->foreign('idguru')->references('id')->on('tbl_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_konseling');
    }
};
