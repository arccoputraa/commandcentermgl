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
        Schema::table('pegawai_jabatans', function (Blueprint $table) {
            $table->string('jabatan_utama')->nullable()->after('kode_unit');
            $table->text('deskripsi_unit')->nullable()->after('jabatan_utama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawai_jabatans', function (Blueprint $table) {
            //
        });
    }
};
