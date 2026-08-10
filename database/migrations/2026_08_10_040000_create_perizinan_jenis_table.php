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
        Schema::create('perizinan_jenis', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_izin');
            $table->string('kategori');
            $table->string('sla')->comment('Waktu penyelesaian (misal: 3 Hari Kerja)');
            $table->string('status')->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perizinan_jenis');
    }
};
