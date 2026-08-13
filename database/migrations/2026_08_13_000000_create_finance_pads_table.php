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
        Schema::create('finance_pads', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->string('sumber_pendapatan');
            $table->string('sub_bidang');
            $table->decimal('target_pad', 20, 2)->default(0);
            $table->decimal('realisasi_pad', 20, 2)->default(0);
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
        Schema::dropIfExists('finance_pads');
    }
};
