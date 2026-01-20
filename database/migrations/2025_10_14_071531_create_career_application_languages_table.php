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
        Schema::create('career_application_languages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('career_application_id')->constrained()->onDelete('cascade');
            $table->string('language_name');
            $table->enum('proficiency_level', ['beginner', 'intermediate', 'advanced', 'native', 'fluent'])->default('intermediate');
            $table->enum('speaking_level', ['beginner', 'intermediate', 'advanced', 'native', 'fluent'])->nullable();
            $table->enum('writing_level', ['beginner', 'intermediate', 'advanced', 'native', 'fluent'])->nullable();
            $table->enum('reading_level', ['beginner', 'intermediate', 'advanced', 'native', 'fluent'])->nullable();
            $table->enum('listening_level', ['beginner', 'intermediate', 'advanced', 'native', 'fluent'])->nullable();
            $table->string('certificate_name')->nullable();
            $table->string('certificate_path')->nullable();
            $table->date('certificate_date')->nullable();
            $table->text('notes')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            // Indexes
            $table->index(['career_application_id', 'sort_order']);
            $table->index('language_name');
            $table->index('proficiency_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('career_application_languages');
    }
};