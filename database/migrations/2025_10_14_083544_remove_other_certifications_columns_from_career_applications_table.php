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
        Schema::table('career_applications', function (Blueprint $table) {
            // Remove other certifications columns (now handled by career_application_certifications table)
            $table->dropColumn([
                'certificate_kind',
                'issued_by',
                'issued_date',
                'other_certificate_path'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('career_applications', function (Blueprint $table) {
            // Re-add the columns if rollback is needed
            $table->string('certificate_kind')->nullable();
            $table->string('issued_by')->nullable();
            $table->date('issued_date')->nullable();
            $table->string('other_certificate_path')->nullable();
        });
    }
};