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
       Schema::create('tbl_counselor', function (Blueprint $table) {
        $table->bigInteger('idkonselor')->unsigned();
        $table->string('pendidikan_terakhir');
        $table->string('jurusan_pendidikan')->nullable();
        $table->text('spesialisasi');
        $table->integer('pengalaman_kerja')->nullable();
        $table->text('sertifikasi')->nullable();
        $table->enum('status', ['aktif', 'nonaktif', 'cuti'])->default('aktif');
        $table->date('tanggal_bergabung');
        $table->timestamps();
        $table->softDeletes();

        $table->foreign('idkonselor')
              ->references('id')
              ->on('tbl_users')
              ->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_counselor');
    }
};
