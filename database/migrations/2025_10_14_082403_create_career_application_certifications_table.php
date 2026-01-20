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
        Schema::create('career_application_certifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('career_application_id')->constrained('career_applications')->onDelete('cascade');
            $table->string('certification_name');
            $table->string('issuing_organization');
            $table->date('issue_date');
            $table->date('expiry_date')->nullable();
            $table->string('certification_number')->nullable();
            $table->string('credential_id')->nullable();
            $table->string('certificate_path')->nullable();
            $table->enum('certification_type', [
                'professional', 
                'technical', 
                'language', 
                'academic', 
                'industry', 
                'software', 
                'safety', 
                'management', 
                'other'
            ])->default('professional');
            $table->enum('status', ['active', 'expired', 'suspended', 'revoked'])->default('active');
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            // Indexes
            $table->index(['career_application_id', 'sort_order']);
            $table->index('certification_name');
            $table->index('issuing_organization');
            $table->index('certification_type');
            $table->index('status');
            $table->index('issue_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('career_application_certifications');
    }
};