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
        $driver = DB::connection()->getDriverName();
        
        Schema::table('career_applications', function (Blueprint $table) {
            // Add read_status field to track if application has been viewed
            $table->boolean('read_status')->default(false);
            $table->timestamp('read_at')->nullable();
            
            // Add vacancy_id to link applications to specific vacancies
            $table->foreignId('vacancy_id')->nullable()->constrained('vacancies')->onDelete('set null');
            
            // Add campus information
            $table->string('campus')->nullable();
            
            // Index for performance
            $table->index('read_status');
            $table->index(['status', 'read_status']);
        });

        // For PostgreSQL, we need to update the check constraint
        if ($driver === 'pgsql') {
            // Drop the old constraint
            DB::statement("ALTER TABLE career_applications DROP CONSTRAINT IF EXISTS career_applications_status_check");
            
            // Add new constraint with expanded status values
            DB::statement("ALTER TABLE career_applications ADD CONSTRAINT career_applications_status_check CHECK (status IN ('pending', 'reviewing', 'accepted', 'rejected', 'unread', 'read', 'shortlisted', 'interview', 'not_suitable'))");
        }
        
        // Update existing records based on current status
        $statusToNewStatus = [
            'pending' => 'unread',
            'reviewing' => 'read',
            'rejected' => 'not_suitable'
        ];
        
        foreach ($statusToNewStatus as $oldStatus => $newStatus) {
            DB::table('career_applications')
                ->where('status', $oldStatus)
                ->update(['status' => $newStatus]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::connection()->getDriverName();
        
        // Restore old status values
        $statusToOldStatus = [
            'unread' => 'pending',
            'read' => 'reviewing',
            'not_suitable' => 'rejected'
        ];
        
        foreach ($statusToOldStatus as $newStatus => $oldStatus) {
            DB::table('career_applications')
                ->where('status', $newStatus)
                ->update(['status' => $oldStatus]);
        }
        
        Schema::table('career_applications', function (Blueprint $table) {
            $table->dropIndex(['status', 'read_status']);
            $table->dropIndex(['read_status']);
            $table->dropForeign(['vacancy_id']);
            $table->dropColumn(['read_status', 'read_at', 'campus', 'vacancy_id']);
        });

        // For PostgreSQL, restore the old constraint
        if ($driver === 'pgsql') {
            // Drop the new constraint
            DB::statement("ALTER TABLE career_applications DROP CONSTRAINT IF EXISTS career_applications_status_check");
            
            // Add back the old constraint
            DB::statement("ALTER TABLE career_applications ADD CONSTRAINT career_applications_status_check CHECK (status IN ('pending', 'reviewing', 'accepted', 'rejected'))");
        }
    }
};

