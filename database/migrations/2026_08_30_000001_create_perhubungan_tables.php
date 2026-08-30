<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('uji_kir', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_uji');
            $table->string('jenis_kendaraan');
            $table->enum('status_uji', ['Lulus Uji', 'Tidak Lulus', 'Perlu Uji Ulang']);
            $table->string('unit_layanan');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('dokumen_perhubungan', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('file_path');
            $table->string('status_tag');
            $table->date('tanggal_rilis');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_perhubungan');
        Schema::dropIfExists('uji_kir');
    }
};
