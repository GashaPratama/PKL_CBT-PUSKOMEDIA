<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('ujians', function (Blueprint $table) {
        $table->dateTime('waktu_mulai')->nullable();
        $table->dateTime('waktu_selesai')->nullable();
    });
}

public function down()
{
    Schema::table('ujians', function (Blueprint $table) {
        $table->dropColumn(['waktu_mulai', 'waktu_selesai']);
    });
}

};
