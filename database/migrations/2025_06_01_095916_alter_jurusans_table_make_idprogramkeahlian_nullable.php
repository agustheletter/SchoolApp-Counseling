<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_jurusan', function (Blueprint $table) {
            // Pastikan tipe data INT(10) UNSIGNED sesuai dengan definisi awal Anda
            // Jika sebelumnya tidak nullable, sekarang kita buat nullable
            $table->unsignedInteger('idprogramkeahlian')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('tbl_jurusan', function (Blueprint $table) {
            // Kembalikan ke not nullable jika perlu rollback (hati-hati jika sudah ada data null)
            // Anda mungkin perlu menghapus data null dulu atau mengisi nilai default jika ingin kembali ke not nullable
            $table->unsignedInteger('idprogramkeahlian')->nullable(false)->change();
        });
    }
};