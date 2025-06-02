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
        $table->id();
        $table->string('nip')->unique();
        $table->string('nama_konselor');
        $table->string('gelar_depan')->nullable();
        $table->string('gelar_belakang')->nullable();
        $table->enum('jenis_kelamin', ['L', 'P']);
        $table->string('tempat_lahir');
        $table->date('tanggal_lahir');
        $table->text('alamat')->nullable();
        $table->string('email')->unique();
        $table->string('no_hp');
        $table->string('pendidikan_terakhir');
        $table->string('jurusan_pendidikan')->nullable();
        $table->text('spesialisasi');
        $table->integer('pengalaman_kerja')->nullable();
        $table->text('sertifikasi')->nullable();
        $table->enum('status', ['aktif', 'nonaktif', 'cuti'])->default('aktif');
        $table->date('tanggal_bergabung');
        $table->string('photo_konselor')->nullable();
        $table->timestamps();
        $table->softDeletes();
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
