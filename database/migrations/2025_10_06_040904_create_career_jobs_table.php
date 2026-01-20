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
        Schema::create('career_jobs', function (Blueprint $table) {
            $table->id();
            
            // Basic Job Information
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('requirements');
            $table->text('responsibilities');
            $table->text('benefits')->nullable();
            
            // Job Details
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->string('employment_type'); // full-time, part-time, contract, internship
            $table->string('experience_level'); // entry, mid, senior, executive
            $table->string('location');
            $table->boolean('remote_allowed')->default(false);
            $table->string('salary_range')->nullable();
            
            // Application Details
            $table->date('application_deadline')->nullable();
            $table->integer('max_applications')->nullable();
            $table->text('application_instructions')->nullable();
            
            // Status and Visibility
            $table->enum('status', ['draft', 'published', 'closed', 'archived'])->default('draft');
            $table->boolean('featured')->default(false);
            $table->integer('priority')->default(0); // Higher number = higher priority
            
            // SEO and Meta
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            
            // Admin Information
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            
            // Timestamps
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index(['status', 'published_at']);
            $table->index(['department_id', 'employment_type']);
            $table->index(['featured', 'priority']);
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('career_jobs');
    }
};
