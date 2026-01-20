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
            // Remove education-related columns (now in career_application_educations table)
            $table->dropColumn([
                'last_education',
                'school_name',
                'faculty',
                'major',
                'start_from',
                'graduate_year',
                'certificate_path'
            ]);
            
            // Remove languages column (now in career_application_languages table)
            $table->dropColumn('languages');
            
            // Remove experience-related columns (now in career_application_experiences table)
            $table->dropColumn([
                'company_name',
                'position',
                'start_month',
                'start_year',
                'end_month',
                'end_year',
                'job_description',
                'salary_range',
                'reasons_for_leaving'
            ]);
            
            // Remove achievement column (now in career_application_achievements table)
            $table->dropColumn('achievement_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('career_applications', function (Blueprint $table) {
            // Re-add education columns
            $table->enum('last_education', ['smk1', 'smk2', 'd3-1', 'd3-2', 's1', 's2', 's3'])->nullable();
            $table->string('school_name')->nullable();
            $table->string('faculty')->nullable();
            $table->string('major')->nullable();
            $table->date('start_from')->nullable();
            $table->string('graduate_year')->nullable();
            $table->string('certificate_path')->nullable();
            
            // Re-add languages column
            $table->json('languages')->nullable();
            
            // Re-add experience columns
            $table->string('company_name')->nullable();
            $table->string('position')->nullable();
            $table->date('start_month')->nullable();
            $table->string('start_year')->nullable();
            $table->date('end_month')->nullable();
            $table->string('end_year')->nullable();
            $table->text('job_description')->nullable();
            $table->string('salary_range')->nullable();
            $table->text('reasons_for_leaving')->nullable();
            
            // Re-add achievement column
            $table->text('achievement_description')->nullable();
        });
    }
};