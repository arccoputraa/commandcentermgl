<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('layer_sig', function (Blueprint $table) {
            $table->id();
            $table->string('nama_layer');
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });

        Schema::create('data_spasial', function (Blueprint $table) {
            $table->id();
            $table->foreignId('layer_id')->constrained('layer_sig')->cascadeOnDelete();
            $table->string('nama_data');
            $table->string('kategori');
            $table->string('wilayah');
            $table->integer('nilai_jumlah')->default(0);
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();
        });

        Schema::create('dokumen_sig', function (Blueprint $table) {
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
        Schema::dropIfExists('dokumen_sig');
        Schema::dropIfExists('data_spasial');
        Schema::dropIfExists('layer_sig');
    }
};
