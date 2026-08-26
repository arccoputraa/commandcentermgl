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
        Schema::table('pembangunan_documents', function (Blueprint $table) {
            $table->string('status_tag')->nullable()->after('file_path');
            $table->text('description')->nullable()->after('status_tag');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembangunan_documents', function (Blueprint $table) {
            $table->dropColumn(['status_tag', 'description']);
        });
    }
};
