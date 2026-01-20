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
            $table->string('current_salary')->nullable()->after('applied_position');
            $table->string('reason_for_leaving')->nullable()->after('current_salary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('career_applications', function (Blueprint $table) {
            $table->dropColumn('current_salary');
            $table->dropColumn('reason_for_leaving');
        });
    }
};
