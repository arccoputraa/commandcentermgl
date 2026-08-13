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
        Schema::create('pegawai_jabatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jabatan');
            $table->string('kode_unit')->nullable();
            $table->string('eselon')->nullable();
            $table->integer('jumlah_pegawai')->default(0);
            $table->string('status')->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai_jabatans');
    }
};
