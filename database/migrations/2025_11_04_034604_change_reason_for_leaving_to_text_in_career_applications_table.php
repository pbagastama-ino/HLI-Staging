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
        DB::statement('ALTER TABLE career_applications ALTER COLUMN reason_for_leaving TYPE TEXT');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE career_applications ALTER COLUMN reason_for_leaving TYPE VARCHAR(255)');
    }
};
