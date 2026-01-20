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
        Schema::table('career_application_experiences', function (Blueprint $table) {
            // Change data type to varchar for start_year and end_year columns
            $table->string('start_year')->nullable()->change();
            $table->string('end_year')->nullable()->change();
            
            // Drop start_date and end_date columns
            $table->dropColumn(['start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('career_application_experiences', function (Blueprint $table) {
            // Revert data type back to original (assuming they were integer or date)
            // Note: You may need to adjust this based on the original data type
            $table->integer('start_year')->nullable()->change();
            $table->integer('end_year')->nullable()->change();
            
            // Recreate start_date and end_date columns
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
        });
    }
};
