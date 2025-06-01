<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_jurusan', function (Blueprint $table) {
            // Tipe data (unsignedInteger) dan nama kolom harus sesuai dengan definisi awal Anda.
            // Jika kolomnya belum ada, gunakan ->unsignedInteger('idprogramkeahlian')->nullable()->after('kolom_sebelumnya');
            // Jika kolomnya sudah ada dan ingin diubah, gunakan ->change()
            if (Schema::hasColumn('tbl_jurusan', 'idprogramkeahlian')) {
                $table->unsignedInteger('idprogramkeahlian')->nullable()->change();
            } else {
                // Jika kolom belum ada sama sekali (misalnya jika Anda rollback migrasi sebelumnya)
                // $table->unsignedInteger('idprogramkeahlian')->nullable()->after('kodejurusan'); // Sesuaikan 'after'
            }
        });
    }

    public function down(): void
    {
        Schema::table('tbl_jurusan', function (Blueprint $table) {
            if (Schema::hasColumn('tbl_jurusan', 'idprogramkeahlian')) {
                // Untuk rollback, pastikan tidak ada data NULL sebelum mengubahnya kembali ke NOT NULL
                // atau berikan nilai default.
                $table->unsignedInteger('idprogramkeahlian')->nullable(false)->change();
            }
        });
    }
};