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
        Schema::create('pegawai_mutasis', function (Blueprint $table) {
            $table->id();
            $table->string('nip');
            $table->string('nama_pegawai');
            $table->string('jenis'); // Mutasi atau Pensiun
            $table->date('tanggal_efektif');
            $table->text('keterangan')->nullable();
            $table->string('status_pengajuan')->default('Proses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai_mutasis');
    }
};
