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
        Schema::create('pembangunan_project_progresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('pembangunan_projects')->onDelete('cascade');
            $table->date('report_date');
            $table->integer('progress_percentage');
            $table->decimal('realized_budget', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembangunan_project_progresses');
    }
};
