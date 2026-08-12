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
        Schema::create('finance_budgets', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->string('sub_bidang');
            $table->string('nama_anggaran');
            $table->decimal('total_anggaran', 20, 2)->default(0);
            $table->decimal('total_realisasi', 20, 2)->default(0);
            $table->string('periode')->nullable();
            $table->string('status')->nullable();
            $table->text('catatan_internal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finance_budgets');
    }
};
