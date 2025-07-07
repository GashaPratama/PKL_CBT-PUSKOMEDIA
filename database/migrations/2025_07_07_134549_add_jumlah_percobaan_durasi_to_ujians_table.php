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
        $table->integer('jumlah_percobaan')->default(1);
        $table->integer('durasi')->default(60); // dalam menit
    });
}

    public function down()
    {
    Schema::table('ujians', function (Blueprint $table) {
        $table->dropColumn(['jumlah_percobaan', 'durasi']);
    });
}

};
