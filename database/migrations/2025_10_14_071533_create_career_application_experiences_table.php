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
        Schema::create('career_application_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('career_application_id')->constrained()->onDelete('cascade');
            $table->string('company_name');
            $table->string('position');
            $table->text('job_description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('start_year')->nullable();
            $table->string('end_year')->nullable();
            $table->string('employment_type')->nullable(); // full-time, part-time, contract, internship
            $table->string('salary_range')->nullable();
            $table->text('reasons_for_leaving')->nullable();
            $table->string('supervisor_name')->nullable();
            $table->string('supervisor_contact')->nullable();
            $table->text('achievements')->nullable();
            $table->text('responsibilities')->nullable();
            $table->boolean('is_current')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            // Indexes
            $table->index(['career_application_id', 'sort_order']);
            $table->index('company_name');
            $table->index('position');
            $table->index('is_current');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('career_application_experiences');
    }
};