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
        Schema::create('kesehatan_penyakits', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('jumlah');
            $table->integer('tahun');
            $table->string('bulan');
            $table->string('wilayah');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kesehatan_penyakits');
    }
};
