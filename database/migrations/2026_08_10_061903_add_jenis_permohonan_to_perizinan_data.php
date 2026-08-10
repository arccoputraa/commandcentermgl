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
        Schema::table('perizinan_data', function (Blueprint $table) {
            $table->string('jenis_permohonan')->default('Baru')->after('perizinan_jenis_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perizinan_data', function (Blueprint $table) {
            $table->dropColumn('jenis_permohonan');
        });
    }
};
