<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->string('nama_lengkap', 100)->unique();
            $table->string('no_telpon', 20);
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->enum('role', ['admin', 'siswa'])->default('siswa');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user');
    }
}

