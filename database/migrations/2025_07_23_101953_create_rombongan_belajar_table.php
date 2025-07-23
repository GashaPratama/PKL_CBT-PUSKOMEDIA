<?php

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rombongan_belajar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->string('nama_kelompok'); // contoh: A, B, C
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rombongan_belajar');
    }
};
