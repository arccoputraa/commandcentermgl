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
        Schema::create('pembangunan_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembangunan_project_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->enum('type', ['PDF', 'Image'])->default('PDF');
            $table->string('file_path');
            $table->date('upload_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembangunan_documents');
    }
};
