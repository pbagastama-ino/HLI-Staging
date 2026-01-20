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
        // PostgreSQL: enum created via $table->enum(...) becomes a CHECK constraint
        // We need to drop and recreate the constraint to add 'article'
        DB::statement("ALTER TABLE publications DROP CONSTRAINT IF EXISTS publications_category_check;");
        DB::statement("ALTER TABLE publications ADD CONSTRAINT publications_category_check CHECK (category IN ('press-release','company-activities','life-at-hli','article'));");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original allowed values (without 'article')
        DB::statement("ALTER TABLE publications DROP CONSTRAINT IF EXISTS publications_category_check;");
        DB::statement("ALTER TABLE publications ADD CONSTRAINT publications_category_check CHECK (category IN ('press-release','company-activities','life-at-hli'));");
    }
};


