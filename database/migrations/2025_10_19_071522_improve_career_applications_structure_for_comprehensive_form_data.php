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
            // Add missing personal fields from form
            $table->boolean('same_as_id_address')->default(false)->after('current_address');
            $table->string('linkedin_profile')->nullable()->after('email');
            
            // Add application metadata
            $table->string('application_source')->default('website')->after('applied_position');
            $table->text('additional_comments')->nullable()->after('notes');
            $table->boolean('privacy_policy_agreed')->default(false)->after('additional_comments');
            $table->timestamp('privacy_policy_agreed_at')->nullable()->after('privacy_policy_agreed');
            
            // Add file storage fields
            $table->json('uploaded_files')->nullable()->after('privacy_policy_agreed_at');
        });

        // Create career_application_references table
        Schema::create('career_application_references', function (Blueprint $table) {
            $table->id();
            $table->foreignId('career_application_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('organization');
            $table->string('phone');
            $table->string('relationship');
            $table->string('email')->nullable();
            $table->text('notes')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index(['career_application_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('career_application_references');
        
        Schema::table('career_applications', function (Blueprint $table) {
            $table->dropColumn([
                'same_as_id_address', 'linkedin_profile', 'application_source',
                'additional_comments', 'privacy_policy_agreed', 'privacy_policy_agreed_at',
                'uploaded_files'
            ]);
        });
    }
};