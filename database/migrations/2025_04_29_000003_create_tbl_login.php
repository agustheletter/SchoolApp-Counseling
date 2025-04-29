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
        Schema::create('tbl_login', function (Blueprint $table) {
            $table->integer('idlogin')->autoIncrement()->unsigned();
            $table->string('email')->index();
            $table->integer('idthnajaran');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('email')->references('email')->on('tbl_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_login');
    }
};
