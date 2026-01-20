<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, rename the table from career_jobs to vacancies
        Schema::rename('career_jobs', 'vacancies');
        
        // Now modify the table structure to simplify it
        Schema::table('vacancies', function (Blueprint $table) {
            // Drop foreign key constraints by name (they still have the old table name)
            $table->dropForeign('career_jobs_department_id_foreign');
            $table->dropForeign('career_jobs_created_by_foreign');
            $table->dropForeign('career_jobs_updated_by_foreign');
            
            // Add new simplified columns first
            $table->string('department_name')->nullable()->after('requirements');
        });
        
        // Update existing records with department names from the department relationship
        DB::statement('UPDATE vacancies SET department_name = (SELECT name FROM departments WHERE departments.id = vacancies.department_id)');
        
        // Now make department_name non-nullable
        Schema::table('vacancies', function (Blueprint $table) {
            $table->string('department_name')->nullable(false)->change();
        });
        
        // Recreate foreign key constraints
        Schema::table('vacancies', function (Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
        
        // Now drop the columns we don't need
        Schema::table('vacancies', function (Blueprint $table) {
            $table->dropColumn([
                'slug',
                'responsibilities',
                'benefits',
                'department_id',
                'employment_type',
                'experience_level',
                'location',
                'remote_allowed',
                'salary_range',
                'application_deadline',
                'max_applications',
                'application_instructions',
                'status',
                'featured',
                'priority',
                'meta_title',
                'meta_description',
                'meta_keywords',
                'published_at'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore the original table structure
        Schema::table('vacancies', function (Blueprint $table) {
            // Drop the new columns
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
            $table->dropColumn(['department_name', 'created_by', 'updated_by']);
            
            // Restore original columns
            $table->string('slug')->unique();
            $table->text('responsibilities');
            $table->text('benefits')->nullable();
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->string('employment_type');
            $table->string('experience_level');
            $table->string('location');
            $table->boolean('remote_allowed')->default(false);
            $table->string('salary_range')->nullable();
            $table->date('application_deadline')->nullable();
            $table->integer('max_applications')->nullable();
            $table->text('application_instructions')->nullable();
            $table->enum('status', ['draft', 'published', 'closed', 'archived'])->default('draft');
            $table->boolean('featured')->default(false);
            $table->integer('priority')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
        });
        
        // Rename table back to career_jobs
        Schema::rename('vacancies', 'career_jobs');
    }
};