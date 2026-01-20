<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For PostgreSQL, we need to drop and recreate the enum constraint
        if (DB::getDriverName() === 'pgsql') {
            // Drop the existing check constraint
            DB::statement('ALTER TABLE career_application_languages DROP CONSTRAINT IF EXISTS career_application_languages_proficiency_level_check');
            DB::statement('ALTER TABLE career_application_languages DROP CONSTRAINT IF EXISTS career_application_languages_speaking_level_check');
            DB::statement('ALTER TABLE career_application_languages DROP CONSTRAINT IF EXISTS career_application_languages_writing_level_check');
            DB::statement('ALTER TABLE career_application_languages DROP CONSTRAINT IF EXISTS career_application_languages_reading_level_check');
            DB::statement('ALTER TABLE career_application_languages DROP CONSTRAINT IF EXISTS career_application_languages_listening_level_check');
            
            // Add new check constraints with updated values
            DB::statement("ALTER TABLE career_application_languages ADD CONSTRAINT career_application_languages_proficiency_level_check CHECK (proficiency_level::text = ANY (ARRAY['beginner'::character varying, 'intermediate'::character varying, 'advanced'::character varying, 'native'::character varying, 'fluent'::character varying, 'proficient'::character varying]::text[]))");
            DB::statement("ALTER TABLE career_application_languages ADD CONSTRAINT career_application_languages_speaking_level_check CHECK (speaking_level::text = ANY (ARRAY['beginner'::character varying, 'intermediate'::character varying, 'advanced'::character varying, 'native'::character varying, 'fluent'::character varying, 'proficient'::character varying]::text[]))");
            DB::statement("ALTER TABLE career_application_languages ADD CONSTRAINT career_application_languages_writing_level_check CHECK (writing_level::text = ANY (ARRAY['beginner'::character varying, 'intermediate'::character varying, 'advanced'::character varying, 'native'::character varying, 'fluent'::character varying, 'proficient'::character varying]::text[]))");
            DB::statement("ALTER TABLE career_application_languages ADD CONSTRAINT career_application_languages_reading_level_check CHECK (reading_level::text = ANY (ARRAY['beginner'::character varying, 'intermediate'::character varying, 'advanced'::character varying, 'native'::character varying, 'fluent'::character varying, 'proficient'::character varying]::text[]))");
            DB::statement("ALTER TABLE career_application_languages ADD CONSTRAINT career_application_languages_listening_level_check CHECK (listening_level::text = ANY (ARRAY['beginner'::character varying, 'intermediate'::character varying, 'advanced'::character varying, 'native'::character varying, 'fluent'::character varying, 'proficient'::character varying]::text[]))");
        } else {
            // For other databases (MySQL), modify the enum columns
            Schema::table('career_application_languages', function (Blueprint $table) {
                $table->enum('proficiency_level', ['beginner', 'intermediate', 'advanced', 'native', 'fluent', 'proficient'])->default('intermediate')->change();
                $table->enum('speaking_level', ['beginner', 'intermediate', 'advanced', 'native', 'fluent', 'proficient'])->nullable()->change();
                $table->enum('writing_level', ['beginner', 'intermediate', 'advanced', 'native', 'fluent', 'proficient'])->nullable()->change();
                $table->enum('reading_level', ['beginner', 'intermediate', 'advanced', 'native', 'fluent', 'proficient'])->nullable()->change();
                $table->enum('listening_level', ['beginner', 'intermediate', 'advanced', 'native', 'fluent', 'proficient'])->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            // Drop the new check constraints
            DB::statement('ALTER TABLE career_application_languages DROP CONSTRAINT IF EXISTS career_application_languages_proficiency_level_check');
            DB::statement('ALTER TABLE career_application_languages DROP CONSTRAINT IF EXISTS career_application_languages_speaking_level_check');
            DB::statement('ALTER TABLE career_application_languages DROP CONSTRAINT IF EXISTS career_application_languages_writing_level_check');
            DB::statement('ALTER TABLE career_application_languages DROP CONSTRAINT IF EXISTS career_application_languages_reading_level_check');
            DB::statement('ALTER TABLE career_application_languages DROP CONSTRAINT IF EXISTS career_application_languages_listening_level_check');
            
            // Restore original check constraints
            DB::statement("ALTER TABLE career_application_languages ADD CONSTRAINT career_application_languages_proficiency_level_check CHECK (proficiency_level::text = ANY (ARRAY['beginner'::character varying, 'intermediate'::character varying, 'advanced'::character varying, 'native'::character varying, 'fluent'::character varying]::text[]))");
            DB::statement("ALTER TABLE career_application_languages ADD CONSTRAINT career_application_languages_speaking_level_check CHECK (speaking_level::text = ANY (ARRAY['beginner'::character varying, 'intermediate'::character varying, 'advanced'::character varying, 'native'::character varying, 'fluent'::character varying]::text[]))");
            DB::statement("ALTER TABLE career_application_languages ADD CONSTRAINT career_application_languages_writing_level_check CHECK (writing_level::text = ANY (ARRAY['beginner'::character varying, 'intermediate'::character varying, 'advanced'::character varying, 'native'::character varying, 'fluent'::character varying]::text[]))");
            DB::statement("ALTER TABLE career_application_languages ADD CONSTRAINT career_application_languages_reading_level_check CHECK (reading_level::text = ANY (ARRAY['beginner'::character varying, 'intermediate'::character varying, 'advanced'::character varying, 'native'::character varying, 'fluent'::character varying]::text[]))");
            DB::statement("ALTER TABLE career_application_languages ADD CONSTRAINT career_application_languages_listening_level_check CHECK (listening_level::text = ANY (ARRAY['beginner'::character varying, 'intermediate'::character varying, 'advanced'::character varying, 'native'::character varying, 'fluent'::character varying]::text[]))");
        } else {
            // For other databases, restore original enum values
            Schema::table('career_application_languages', function (Blueprint $table) {
                $table->enum('proficiency_level', ['beginner', 'intermediate', 'advanced', 'native', 'fluent'])->default('intermediate')->change();
                $table->enum('speaking_level', ['beginner', 'intermediate', 'advanced', 'native', 'fluent'])->nullable()->change();
                $table->enum('writing_level', ['beginner', 'intermediate', 'advanced', 'native', 'fluent'])->nullable()->change();
                $table->enum('reading_level', ['beginner', 'intermediate', 'advanced', 'native', 'fluent'])->nullable()->change();
                $table->enum('listening_level', ['beginner', 'intermediate', 'advanced', 'native', 'fluent'])->nullable()->change();
            });
        }
    }
};