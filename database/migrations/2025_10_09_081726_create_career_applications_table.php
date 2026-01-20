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
        Schema::create('career_applications', function (Blueprint $table) {
            $table->id();
            
            // Personal Data
            $table->string('full_name');
            $table->string('nationality')->nullable();
            $table->enum('sex', ['male', 'female'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->string('marital_status')->nullable();
            $table->text('id_address')->nullable();
            $table->text('current_address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email');
            $table->string('linkedin_url')->nullable();
            $table->string('social_media')->nullable();
            
            // Education
            $table->enum('last_education', ['smk1', 'smk2', 'd3-1', 'd3-2', 's1', 's2', 's3'])->nullable();
            $table->string('school_name')->nullable();
            $table->string('faculty')->nullable();
            $table->string('major')->nullable();
            $table->date('start_from')->nullable();
            $table->string('graduate_year')->nullable();
            $table->string('certificate_path')->nullable();
            
            // Languages
            $table->json('languages')->nullable();
            
            // Experience
            $table->string('company_name')->nullable();
            $table->string('position')->nullable();
            $table->date('start_month')->nullable();
            $table->string('start_year')->nullable();
            $table->date('end_month')->nullable();
            $table->string('end_year')->nullable();
            $table->text('job_description')->nullable();
            $table->string('salary_range')->nullable();
            $table->text('reasons_for_leaving')->nullable();
            
            // Achievement
            $table->text('achievement_description')->nullable();
            
            // Reference
            $table->string('reference_name')->nullable();
            $table->string('reference_phone')->nullable();
            $table->string('reference_relationship')->nullable();
            
            // Other Certificates
            $table->string('certificate_kind')->nullable();
            $table->string('issued_by')->nullable();
            $table->date('issued_date')->nullable();
            $table->string('other_certificate_path')->nullable();
            
            // Application Status
            $table->enum('status', ['pending', 'reviewing', 'accepted', 'rejected'])->default('pending');
            $table->text('notes')->nullable();
            $table->string('applied_position')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index(['status', 'created_at']);
            $table->index('email');
            $table->index('applied_position');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('career_applications');
    }
};