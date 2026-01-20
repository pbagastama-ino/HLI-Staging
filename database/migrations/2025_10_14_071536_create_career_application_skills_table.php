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
        Schema::create('career_application_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('career_application_id')->constrained()->onDelete('cascade');
            $table->string('skill_name');
            $table->enum('proficiency_level', ['beginner', 'intermediate', 'advanced', 'expert'])->default('intermediate');
            $table->string('category')->nullable(); // technical, soft, language, software, etc.
            $table->integer('years_experience')->nullable();
            $table->text('description')->nullable();
            $table->string('certification_name')->nullable();
            $table->string('certification_path')->nullable();
            $table->date('certification_date')->nullable();
            $table->text('notes')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            // Indexes
            $table->index(['career_application_id', 'sort_order']);
            $table->index('skill_name');
            $table->index('category');
            $table->index('proficiency_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('career_application_skills');
    }
};