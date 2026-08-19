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
        Schema::create('pembangunan_projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_code')->unique();
            $table->string('name');
            $table->string('category');
            $table->string('kecamatan')->nullable();
            $table->string('kelurahan')->nullable();
            $table->decimal('total_budget', 15, 2)->default(0);
            $table->decimal('realized_budget', 15, 2)->default(0);
            $table->decimal('progress_percentage', 5, 2)->default(0);
            $table->enum('status', ['Selesai', 'Berjalan', 'Tertunda'])->default('Berjalan');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembangunan_projects');
    }
};
