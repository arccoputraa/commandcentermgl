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
            $table->string('lokasi_kecamatan')->nullable()->after('status');
            $table->text('keterangan')->nullable()->after('lokasi_kecamatan');
        });

        Schema::table('perizinan_jenis', function (Blueprint $table) {
            $table->string('dokumen')->nullable()->after('status');
            $table->text('keterangan')->nullable()->after('dokumen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perizinan_data', function (Blueprint $table) {
            $table->dropColumn(['lokasi_kecamatan', 'keterangan']);
        });

        Schema::table('perizinan_jenis', function (Blueprint $table) {
            $table->dropColumn(['dokumen', 'keterangan']);
        });
    }
};
