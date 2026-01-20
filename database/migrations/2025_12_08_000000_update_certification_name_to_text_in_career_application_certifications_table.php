<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Switch certification_name from varchar to text to allow longer values
        DB::statement('ALTER TABLE career_application_certifications ALTER COLUMN certification_name TYPE TEXT');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert certification_name back to varchar(255)
        DB::statement('ALTER TABLE career_application_certifications ALTER COLUMN certification_name TYPE VARCHAR(255)');
    }
};

