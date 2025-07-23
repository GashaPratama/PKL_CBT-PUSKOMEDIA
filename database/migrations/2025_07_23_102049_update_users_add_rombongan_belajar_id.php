<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $table->dropColumn(['kelas', 'kelompok']);
            $table->foreignId('rombongan_belajar_id')->nullable()->constrained('rombongan_belajar')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $table->string('kelas')->nullable();
            $table->string('kelompok')->nullable();
            $table->dropForeign(['rombongan_belajar_id']);
            $table->dropColumn('rombongan_belajar_id');
        });
    }
};
