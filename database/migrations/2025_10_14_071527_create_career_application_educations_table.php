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
        Schema::create('career_application_educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('career_application_id')->constrained()->onDelete('cascade');
            $table->enum('level', ['smk1', 'smk2', 'd3-1', 'd3-2', 's1', 's2', 's3'])->nullable();
            $table->string('school_name')->nullable();
            $table->string('faculty')->nullable();
            $table->string('major')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('graduate_year')->nullable();
            $table->decimal('gpa', 3, 2)->nullable();
            $table->string('certificate_path')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_current')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            // Indexes
            $table->index(['career_application_id', 'sort_order']);
            $table->index('level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('career_application_educations');
    }
};