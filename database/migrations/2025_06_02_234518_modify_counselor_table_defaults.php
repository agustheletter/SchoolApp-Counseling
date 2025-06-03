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
        Schema::table('tbl_counselor', function (Blueprint $table) {
            $table->string('pendidikan_terakhir')->default('-')->change();
            $table->string('jurusan_pendidikan')->default('-')->change();
            $table->text('spesialisasi')->nullable()->change();
            $table->integer('pengalaman_kerja')->default(0)->change();
            $table->text('sertifikasi')->nullable()->change();
            $table->enum('status', ['aktif', 'nonaktif', 'cuti', 'pending'])->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
