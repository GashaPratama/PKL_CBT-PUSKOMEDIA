<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('soals', function (Blueprint $table) {
            $table->string('opsi_e')->nullable()->after('opsi_d');
            $table->string('opsi_f')->nullable()->after('opsi_e');
        });
    }

    public function down(): void
    {
        Schema::table('soals', function (Blueprint $table) {
            $table->dropColumn(['opsi_e', 'opsi_f']);
        });
    }
};
