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
        Schema::create('career_application_achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('career_application_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('organization')->nullable();
            $table->date('achievement_date')->nullable();
            $table->string('year')->nullable();
            $table->string('category')->nullable(); // academic, professional, personal, sports, etc.
            $table->string('certificate_path')->nullable();
            $table->string('verification_url')->nullable();
            $table->text('impact')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            // Indexes
            $table->index(['career_application_id', 'sort_order']);
            $table->index('category');
            $table->index('achievement_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('career_application_achievements');
    }
};