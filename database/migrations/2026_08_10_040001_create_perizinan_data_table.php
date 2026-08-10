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
        Schema::create('perizinan_data', function (Blueprint $table) {
            $table->id();
            $table->string('no_dokumen')->unique();
            $table->string('nama_pemohon');
            $table->foreignId('perizinan_jenis_id')->constrained('perizinan_jenis')->onDelete('restrict');
            $table->date('tanggal');
            $table->string('status')->default('Proses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perizinan_data');
    }
};
