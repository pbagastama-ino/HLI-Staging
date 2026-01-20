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
        Schema::table('career_application_educations', function (Blueprint $table) {
            // Rename columns and change data type from date to varchar
            $table->renameColumn('start_date', 'start_year');
            $table->renameColumn('end_date', 'end_year');
        });
        
        // Change data type to varchar after renaming
        Schema::table('career_application_educations', function (Blueprint $table) {
            $table->string('start_year')->nullable()->change();
            $table->string('end_year')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('career_application_educations', function (Blueprint $table) {
            // Change data type back to date before renaming
            $table->date('start_year')->nullable()->change();
            $table->date('end_year')->nullable()->change();
        });
        
        // Rename columns back to original names
        Schema::table('career_application_educations', function (Blueprint $table) {
            $table->renameColumn('start_year', 'start_date');
            $table->renameColumn('end_year', 'end_date');
        });
    }
};
