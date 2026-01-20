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
        Schema::table('career_applications', function (Blueprint $table) {
            // Add resume_path column for user upload
            $table->string('resume_path')->nullable();
        });

        // Drop columns if they exist
        Schema::table('career_applications', function (Blueprint $table) {
            // Drop LinkedIn URL column
            $table->dropColumn('linkedin_url');
            
            // Drop reference columns (these have been moved to career_application_references table)
            $table->dropColumn(['reference_name', 'reference_phone', 'reference_relationship']);
            
            // Drop campus column
            $table->dropColumn('campus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('career_applications', function (Blueprint $table) {
            // Re-add campus column
            $table->string('campus')->nullable();
            
            // Re-add reference columns
            $table->string('reference_name')->nullable();
            $table->string('reference_phone')->nullable();
            $table->string('reference_relationship')->nullable();
            
            // Re-add linkedin_url column
            $table->string('linkedin_url')->nullable();
        });

        Schema::table('career_applications', function (Blueprint $table) {
            // Drop resume_path column
            $table->dropColumn('resume_path');
        });
    }
};
