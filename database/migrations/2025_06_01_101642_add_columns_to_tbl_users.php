<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_users', function (Blueprint $table) {
            if (!Schema::hasColumn('tbl_users', 'avatar')) {
                $table->string('avatar')->nullable()->after('id');
            }
            if (!Schema::hasColumn('tbl_users', 'username')) {
                $table->string('username')->nullable()->after('avatar');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tbl_users', function (Blueprint $table) {
            if (Schema::hasColumn('tbl_users', 'avatar')) {
                $table->dropColumn('avatar');
            }
            if (Schema::hasColumn('tbl_users', 'username')) {
                $table->dropColumn('username');
            }
        });
    }
};