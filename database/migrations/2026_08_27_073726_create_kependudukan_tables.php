<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kependudukan_penduduks', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->integer('penduduk');
            $table->integer('laki_laki');
            $table->integer('perempuan');
            $table->integer('wajib_ktp');
            $table->integer('usia_produktif');
            $table->integer('anak');
            $table->integer('lansia');
            $table->integer('kk');
            $table->string('agama');
            $table->string('status')->default('Aktif');
            $table->timestamps();
        });

        Schema::create('kependudukan_agamas', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('agama');
            $table->integer('penduduk');
            $table->string('persentase');
            $table->string('status')->default('Aktif');
            $table->timestamps();
        });

        Schema::create('kependudukan_wilayahs', function (Blueprint $table) {
            $table->id();
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('kode')->nullable();
            $table->integer('penduduk');
            $table->integer('kk');
            $table->integer('laki_laki');
            $table->integer('perempuan');
            $table->string('status')->default('Aktif');
            $table->timestamps();
        });

        Schema::create('kependudukan_kartu_keluargas', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->integer('kk');
            $table->integer('penduduk');
            $table->string('rata_rata')->nullable();
            $table->string('status')->default('Aktif');
            $table->timestamps();
        });

        Schema::create('kependudukan_mutasis', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->string('bulan');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->integer('kelahiran');
            $table->integer('kematian');
            $table->integer('pindah_datang');
            $table->integer('pindah_keluar');
            $table->string('status')->default('Aktif');
            $table->timestamps();
        });

        Schema::create('kependudukan_informasis', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('kategori');
            $table->string('file')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('status')->default('Draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kependudukan_informasis');
        Schema::dropIfExists('kependudukan_mutasis');
        Schema::dropIfExists('kependudukan_kartu_keluargas');
        Schema::dropIfExists('kependudukan_wilayahs');
        Schema::dropIfExists('kependudukan_agamas');
        Schema::dropIfExists('kependudukan_penduduks');
    }
};
