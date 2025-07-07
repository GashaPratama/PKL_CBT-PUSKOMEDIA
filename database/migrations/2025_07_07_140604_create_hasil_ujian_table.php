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
    Schema::create('hasil_ujian', function (Blueprint $table) {
        $table->id();
        $table->foreignId('ujian_id')->constrained('ujians')->onDelete('cascade');

        $table->unsignedBigInteger('user_id');
        $table->foreign('user_id')->references('id_user')->on('user')->onDelete('cascade');

        $table->integer('nilai');
        $table->timestamp('waktu_mulai')->nullable();
        $table->timestamp('waktu_selesai')->nullable();
        $table->timestamps();
    });
}




    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_ujian');
    }
};
