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
        // Create cache table
        if (!Schema::hasTable('cache')) {
            Schema::create('cache', function (Blueprint $table) {
                $table->string('key', 255)->primary();
                $table->text('value');
                $table->integer('expiration');
            });
        }

        // Create cache_locks table
        if (!Schema::hasTable('cache_locks')) {
            Schema::create('cache_locks', function (Blueprint $table) {
                $table->string('key', 255)->primary();
                $table->string('owner', 255);
                $table->integer('expiration');
            });
        }

        // Create career_application_achievements table
        if (!Schema::hasTable('career_application_achievements')) {
            Schema::create('career_application_achievements', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('career_application_id');
                $table->string('title', 255);
                $table->text('description');
                $table->string('organization', 255)->nullable();
                $table->date('achievement_date')->nullable();
                $table->string('year', 255)->nullable();
                $table->string('category', 255)->nullable();
                $table->string('certificate_path', 255)->nullable();
                $table->string('verification_url', 255)->nullable();
                $table->text('impact')->nullable();
                $table->integer('sort_order')->default(0);
                $table->timestamp('created_at', 0)->nullable();
                $table->timestamp('updated_at', 0)->nullable();
            });
        }

        // Create career_application_certifications table
        if (!Schema::hasTable('career_application_certifications')) {
            Schema::create('career_application_certifications', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('career_application_id');
                $table->string('certification_name', 255);
                $table->string('issuing_organization', 255);
                $table->date('issue_date');
                $table->date('expiry_date')->nullable();
                $table->string('certification_number', 255)->nullable();
                $table->string('credential_id', 255)->nullable();
                $table->string('certificate_path', 255)->nullable();
                $table->string('certification_type', 255)->default('professional');
                $table->string('status', 255)->default('active');
                $table->text('description')->nullable();
                $table->text('notes')->nullable();
                $table->boolean('is_verified')->default(false);
                $table->integer('sort_order')->default(0);
                $table->timestamp('created_at', 0)->nullable();
                $table->timestamp('updated_at', 0)->nullable();
            });

            // Add check constraints via raw SQL (only if they don't exist)
            $this->addConstraintIfNotExists('career_application_certifications', 'career_application_certifications_certification_type_check',
                "ALTER TABLE career_application_certifications ADD CONSTRAINT career_application_certifications_certification_type_check CHECK (certification_type::text = ANY (ARRAY['professional'::character varying, 'technical'::character varying, 'language'::character varying, 'academic'::character varying, 'industry'::character varying, 'software'::character varying, 'safety'::character varying, 'management'::character varying, 'other'::character varying]::text[]))");
            $this->addConstraintIfNotExists('career_application_certifications', 'career_application_certifications_status_check',
                "ALTER TABLE career_application_certifications ADD CONSTRAINT career_application_certifications_status_check CHECK (status::text = ANY (ARRAY['active'::character varying, 'expired'::character varying, 'suspended'::character varying, 'revoked'::character varying]::text[]))");
        } else {
            // Table exists, but check if constraints exist
            $this->addConstraintIfNotExists('career_application_certifications', 'career_application_certifications_certification_type_check',
                "ALTER TABLE career_application_certifications ADD CONSTRAINT career_application_certifications_certification_type_check CHECK (certification_type::text = ANY (ARRAY['professional'::character varying, 'technical'::character varying, 'language'::character varying, 'academic'::character varying, 'industry'::character varying, 'software'::character varying, 'safety'::character varying, 'management'::character varying, 'other'::character varying]::text[]))");
            $this->addConstraintIfNotExists('career_application_certifications', 'career_application_certifications_status_check',
                "ALTER TABLE career_application_certifications ADD CONSTRAINT career_application_certifications_status_check CHECK (status::text = ANY (ARRAY['active'::character varying, 'expired'::character varying, 'suspended'::character varying, 'revoked'::character varying]::text[]))");
        }

        // Create career_application_educations table
        if (!Schema::hasTable('career_application_educations')) {
            Schema::create('career_application_educations', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('career_application_id');
                $table->string('level', 255)->nullable();
                $table->string('school_name', 255)->nullable();
                $table->string('faculty', 255)->nullable();
                $table->string('major', 255)->nullable();
                $table->string('start_year', 255)->nullable();
                $table->string('end_year', 255)->nullable();
                $table->string('graduate_year', 255)->nullable();
                $table->decimal('gpa', 3, 2)->nullable();
                $table->string('certificate_path', 255)->nullable();
                $table->text('description')->nullable();
                $table->boolean('is_current')->default(false);
                $table->integer('sort_order')->default(0);
                $table->timestamp('created_at', 0)->nullable();
                $table->timestamp('updated_at', 0)->nullable();
            });

            $this->addConstraintIfNotExists('career_application_educations', 'career_application_educations_level_check',
                "ALTER TABLE career_application_educations ADD CONSTRAINT career_application_educations_level_check CHECK (level::text = ANY (ARRAY['smk1'::character varying, 'smk2'::character varying, 'd3-1'::character varying, 'd3-2'::character varying, 's1'::character varying, 's2'::character varying, 's3'::character varying]::text[]))");
        } else {
            $this->addConstraintIfNotExists('career_application_educations', 'career_application_educations_level_check',
                "ALTER TABLE career_application_educations ADD CONSTRAINT career_application_educations_level_check CHECK (level::text = ANY (ARRAY['smk1'::character varying, 'smk2'::character varying, 'd3-1'::character varying, 'd3-2'::character varying, 's1'::character varying, 's2'::character varying, 's3'::character varying]::text[]))");
        }

        // Create career_application_experiences table
        if (!Schema::hasTable('career_application_experiences')) {
            Schema::create('career_application_experiences', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('career_application_id');
                $table->string('company_name', 255);
                $table->string('position', 255);
                $table->text('job_description')->nullable();
                $table->string('start_year', 255)->nullable();
                $table->string('end_year', 255)->nullable();
                $table->string('employment_type', 255)->nullable();
                $table->string('salary_range', 255)->nullable();
                $table->text('reasons_for_leaving')->nullable();
                $table->string('supervisor_name', 255)->nullable();
                $table->string('supervisor_contact', 255)->nullable();
                $table->text('achievements')->nullable();
                $table->text('responsibilities')->nullable();
                $table->boolean('is_current')->default(false);
                $table->integer('sort_order')->default(0);
                $table->timestamp('created_at', 0)->nullable();
                $table->timestamp('updated_at', 0)->nullable();
            });
        }

        // Create career_application_languages table
        if (!Schema::hasTable('career_application_languages')) {
            Schema::create('career_application_languages', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('career_application_id');
                $table->string('language_name', 255);
                $table->string('proficiency_level', 255)->default('intermediate');
                $table->string('speaking_level', 255)->nullable();
                $table->string('writing_level', 255)->nullable();
                $table->string('reading_level', 255)->nullable();
                $table->string('listening_level', 255)->nullable();
                $table->string('certificate_name', 255)->nullable();
                $table->string('certificate_path', 255)->nullable();
                $table->date('certificate_date')->nullable();
                $table->text('notes')->nullable();
                $table->integer('sort_order')->default(0);
                $table->timestamp('created_at', 0)->nullable();
                $table->timestamp('updated_at', 0)->nullable();
            });

            $this->addConstraintIfNotExists('career_application_languages', 'career_application_languages_listening_level_check',
                "ALTER TABLE career_application_languages ADD CONSTRAINT career_application_languages_listening_level_check CHECK (listening_level::text = ANY (ARRAY[('beginner'::character varying)::text, ('intermediate'::character varying)::text, ('advanced'::character varying)::text, ('native'::character varying)::text, ('fluent'::character varying)::text, ('proficient'::character varying)::text]))");
            $this->addConstraintIfNotExists('career_application_languages', 'career_application_languages_proficiency_level_check',
                "ALTER TABLE career_application_languages ADD CONSTRAINT career_application_languages_proficiency_level_check CHECK (proficiency_level::text = ANY (ARRAY[('beginner'::character varying)::text, ('intermediate'::character varying)::text, ('advanced'::character varying)::text, ('native'::character varying)::text, ('fluent'::character varying)::text, ('proficient'::character varying)::text]))");
            $this->addConstraintIfNotExists('career_application_languages', 'career_application_languages_reading_level_check',
                "ALTER TABLE career_application_languages ADD CONSTRAINT career_application_languages_reading_level_check CHECK (reading_level::text = ANY (ARRAY[('beginner'::character varying)::text, ('intermediate'::character varying)::text, ('advanced'::character varying)::text, ('native'::character varying)::text, ('fluent'::character varying)::text, ('proficient'::character varying)::text]))");
            $this->addConstraintIfNotExists('career_application_languages', 'career_application_languages_speaking_level_check',
                "ALTER TABLE career_application_languages ADD CONSTRAINT career_application_languages_speaking_level_check CHECK (speaking_level::text = ANY (ARRAY[('beginner'::character varying)::text, ('intermediate'::character varying)::text, ('advanced'::character varying)::text, ('native'::character varying)::text, ('fluent'::character varying)::text, ('proficient'::character varying)::text]))");
            $this->addConstraintIfNotExists('career_application_languages', 'career_application_languages_writing_level_check',
                "ALTER TABLE career_application_languages ADD CONSTRAINT career_application_languages_writing_level_check CHECK (writing_level::text = ANY (ARRAY[('beginner'::character varying)::text, ('intermediate'::character varying)::text, ('advanced'::character varying)::text, ('native'::character varying)::text, ('fluent'::character varying)::text, ('proficient'::character varying)::text]))");
        } else {
            $this->addConstraintIfNotExists('career_application_languages', 'career_application_languages_listening_level_check',
                "ALTER TABLE career_application_languages ADD CONSTRAINT career_application_languages_listening_level_check CHECK (listening_level::text = ANY (ARRAY[('beginner'::character varying)::text, ('intermediate'::character varying)::text, ('advanced'::character varying)::text, ('native'::character varying)::text, ('fluent'::character varying)::text, ('proficient'::character varying)::text]))");
            $this->addConstraintIfNotExists('career_application_languages', 'career_application_languages_proficiency_level_check',
                "ALTER TABLE career_application_languages ADD CONSTRAINT career_application_languages_proficiency_level_check CHECK (proficiency_level::text = ANY (ARRAY[('beginner'::character varying)::text, ('intermediate'::character varying)::text, ('advanced'::character varying)::text, ('native'::character varying)::text, ('fluent'::character varying)::text, ('proficient'::character varying)::text]))");
            $this->addConstraintIfNotExists('career_application_languages', 'career_application_languages_reading_level_check',
                "ALTER TABLE career_application_languages ADD CONSTRAINT career_application_languages_reading_level_check CHECK (reading_level::text = ANY (ARRAY[('beginner'::character varying)::text, ('intermediate'::character varying)::text, ('advanced'::character varying)::text, ('native'::character varying)::text, ('fluent'::character varying)::text, ('proficient'::character varying)::text]))");
            $this->addConstraintIfNotExists('career_application_languages', 'career_application_languages_speaking_level_check',
                "ALTER TABLE career_application_languages ADD CONSTRAINT career_application_languages_speaking_level_check CHECK (speaking_level::text = ANY (ARRAY[('beginner'::character varying)::text, ('intermediate'::character varying)::text, ('advanced'::character varying)::text, ('native'::character varying)::text, ('fluent'::character varying)::text, ('proficient'::character varying)::text]))");
            $this->addConstraintIfNotExists('career_application_languages', 'career_application_languages_writing_level_check',
                "ALTER TABLE career_application_languages ADD CONSTRAINT career_application_languages_writing_level_check CHECK (writing_level::text = ANY (ARRAY[('beginner'::character varying)::text, ('intermediate'::character varying)::text, ('advanced'::character varying)::text, ('native'::character varying)::text, ('fluent'::character varying)::text, ('proficient'::character varying)::text]))");
        }

        // Create career_application_references table
        if (!Schema::hasTable('career_application_references')) {
            Schema::create('career_application_references', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('career_application_id');
                $table->string('name', 255);
                $table->string('organization', 255);
                $table->string('phone', 255);
                $table->string('relationship', 255);
                $table->string('email', 255)->nullable();
                $table->text('notes')->nullable();
                $table->integer('sort_order')->default(0);
                $table->timestamp('created_at', 0)->nullable();
                $table->timestamp('updated_at', 0)->nullable();
            });
        }

        // Create career_application_skills table
        if (!Schema::hasTable('career_application_skills')) {
            Schema::create('career_application_skills', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('career_application_id');
                $table->string('skill_name', 255);
                $table->string('proficiency_level', 255)->default('intermediate');
                $table->string('category', 255)->nullable();
                $table->integer('years_experience')->nullable();
                $table->text('description')->nullable();
                $table->string('certification_name', 255)->nullable();
                $table->string('certification_path', 255)->nullable();
                $table->date('certification_date')->nullable();
                $table->text('notes')->nullable();
                $table->integer('sort_order')->default(0);
                $table->timestamp('created_at', 0)->nullable();
                $table->timestamp('updated_at', 0)->nullable();
            });

            $this->addConstraintIfNotExists('career_application_skills', 'career_application_skills_proficiency_level_check',
                "ALTER TABLE career_application_skills ADD CONSTRAINT career_application_skills_proficiency_level_check CHECK (proficiency_level::text = ANY (ARRAY['beginner'::character varying, 'intermediate'::character varying, 'advanced'::character varying, 'expert'::character varying]::text[]))");
        } else {
            $this->addConstraintIfNotExists('career_application_skills', 'career_application_skills_proficiency_level_check',
                "ALTER TABLE career_application_skills ADD CONSTRAINT career_application_skills_proficiency_level_check CHECK (proficiency_level::text = ANY (ARRAY['beginner'::character varying, 'intermediate'::character varying, 'advanced'::character varying, 'expert'::character varying]::text[]))");
        }

        // Create career_applications table
        if (!Schema::hasTable('career_applications')) {
            Schema::create('career_applications', function (Blueprint $table) {
                $table->id();
                $table->string('full_name', 255);
                $table->string('nationality', 255)->nullable();
                $table->string('sex', 255)->nullable();
                $table->date('date_of_birth')->nullable();
                $table->string('place_of_birth', 255)->nullable();
                $table->string('marital_status', 255)->nullable();
                $table->text('id_address')->nullable();
                $table->text('current_address')->nullable();
                $table->string('phone_number', 255)->nullable();
                $table->string('email', 255);
                $table->string('social_media', 255)->nullable();
                $table->string('status', 255)->nullable();
                $table->text('notes')->nullable();
                $table->string('applied_position', 255)->nullable();
                $table->timestamp('created_at', 0)->nullable();
                $table->timestamp('updated_at', 0)->nullable();
                $table->boolean('same_as_id_address')->default(false);
                $table->string('linkedin_profile', 255)->nullable();
                $table->string('application_source', 255)->default('website');
                $table->text('additional_comments')->nullable();
                $table->boolean('privacy_policy_agreed')->default(false);
                $table->timestamp('privacy_policy_agreed_at', 0)->nullable();
                $table->json('uploaded_files')->nullable();
                $table->string('current_salary', 255)->nullable();
                $table->string('reason_for_leaving', 255)->nullable();
                $table->bigInteger('updated_by')->nullable();
                $table->boolean('talent_pool')->default(false);
                $table->boolean('read_status')->default(false);
                $table->timestamp('read_at', 0)->nullable();
                $table->bigInteger('vacancy_id')->nullable();
                $table->string('resume_path', 255)->nullable();
            });

            $this->addConstraintIfNotExists('career_applications', 'career_applications_sex_check',
                "ALTER TABLE career_applications ADD CONSTRAINT career_applications_sex_check CHECK (sex::text = ANY (ARRAY['male'::character varying, 'female'::character varying]::text[]))");
            $this->addConstraintIfNotExists('career_applications', 'career_applications_status_check',
                "ALTER TABLE career_applications ADD CONSTRAINT career_applications_status_check CHECK (status::text = ANY (ARRAY['pending'::character varying, 'reviewing'::character varying, 'accepted'::character varying, 'rejected'::character varying, 'unread'::character varying, 'read'::character varying, 'shortlisted'::character varying, 'interview'::character varying, 'not_suitable'::character varying]::text[]))");
        } else {
            $this->addConstraintIfNotExists('career_applications', 'career_applications_sex_check',
                "ALTER TABLE career_applications ADD CONSTRAINT career_applications_sex_check CHECK (sex::text = ANY (ARRAY['male'::character varying, 'female'::character varying]::text[]))");
            $this->addConstraintIfNotExists('career_applications', 'career_applications_status_check',
                "ALTER TABLE career_applications ADD CONSTRAINT career_applications_status_check CHECK (status::text = ANY (ARRAY['pending'::character varying, 'reviewing'::character varying, 'accepted'::character varying, 'rejected'::character varying, 'unread'::character varying, 'read'::character varying, 'shortlisted'::character varying, 'interview'::character varying, 'not_suitable'::character varying]::text[]))");
        }

        // Create vacancies table
        if (!Schema::hasTable('vacancies')) {
            Schema::create('vacancies', function (Blueprint $table) {
                $table->id();
                $table->string('title', 255);
                $table->text('description');
                $table->text('requirements');
                $table->bigInteger('created_by');
                $table->bigInteger('updated_by')->nullable();
                $table->timestamp('created_at', 0)->nullable();
                $table->timestamp('updated_at', 0)->nullable();
                $table->string('department_name', 255);
                $table->text('employee_benefit')->nullable();
            });
        }

        // Create contact_submissions table
        if (!Schema::hasTable('contact_submissions')) {
            Schema::create('contact_submissions', function (Blueprint $table) {
                $table->id();
                $table->string('fullname', 255);
                $table->string('email', 255);
                $table->string('phone', 255)->nullable();
                $table->string('subject', 255)->nullable();
                $table->text('message');
                $table->timestamp('created_at', 0)->nullable();
                $table->timestamp('updated_at', 0)->nullable();
            });
        }

        // Create departments table
        if (!Schema::hasTable('departments')) {
            Schema::create('departments', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255);
                $table->string('code', 255)->unique();
                $table->text('description')->nullable();
                $table->boolean('is_active')->default(true);
                $table->integer('sort_order')->default(0);
                $table->timestamp('created_at', 0)->nullable();
                $table->timestamp('updated_at', 0)->nullable();
            });
        }

        // Create failed_jobs table
        if (!Schema::hasTable('failed_jobs')) {
            Schema::create('failed_jobs', function (Blueprint $table) {
                $table->id();
                $table->string('uuid', 255)->unique();
                $table->text('connection');
                $table->text('queue');
                $table->text('payload');
                $table->text('exception');
                $table->timestamp('failed_at', 0)->useCurrent();
            });
        }

        // Create job_batches table
        if (!Schema::hasTable('job_batches')) {
            Schema::create('job_batches', function (Blueprint $table) {
                $table->string('id', 255)->primary();
                $table->string('name', 255);
                $table->integer('total_jobs');
                $table->integer('pending_jobs');
                $table->integer('failed_jobs');
                $table->text('failed_job_ids');
                $table->text('options')->nullable();
                $table->integer('cancelled_at')->nullable();
                $table->integer('created_at');
                $table->integer('finished_at')->nullable();
            });
        }

        // Create jobs table
        if (!Schema::hasTable('jobs')) {
            Schema::create('jobs', function (Blueprint $table) {
                $table->id();
                $table->string('queue', 255);
                $table->text('payload');
                $table->unsignedSmallInteger('attempts');
                $table->integer('reserved_at')->nullable();
                $table->integer('available_at');
                $table->integer('created_at');
            });
        }

        // Create migrations table
        if (!Schema::hasTable('migrations')) {
            Schema::create('migrations', function (Blueprint $table) {
                $table->id();
                $table->string('migration', 255);
                $table->integer('batch');
            });
        }

        // Create password_reset_tokens table
        if (!Schema::hasTable('password_reset_tokens')) {
            Schema::create('password_reset_tokens', function (Blueprint $table) {
                $table->string('email', 255)->primary();
                $table->string('token', 255);
                $table->timestamp('created_at', 0)->nullable();
            });
        }

        // Create publications table
        if (!Schema::hasTable('publications')) {
            Schema::create('publications', function (Blueprint $table) {
                $table->id();
                $table->string('title', 255);
                $table->string('slug', 255)->unique();
                $table->text('text');
                $table->string('image', 255)->nullable();
                $table->string('category', 255);
                $table->date('published_date')->nullable();
                $table->string('status', 255)->default('draft');
                $table->boolean('featured')->default(false);
                $table->string('meta_title', 255)->nullable();
                $table->text('meta_description')->nullable();
                $table->text('meta_keywords')->nullable();
                $table->bigInteger('created_by')->nullable();
                $table->bigInteger('updated_by')->nullable();
                $table->timestamp('created_at', 0)->nullable();
                $table->timestamp('updated_at', 0)->nullable();
                $table->string('image_url', 255)->nullable();
            });

            $this->addConstraintIfNotExists('publications', 'publications_category_check',
                "ALTER TABLE publications ADD CONSTRAINT publications_category_check CHECK (category::text = ANY (ARRAY['press-release'::character varying, 'company-activities'::character varying, 'life-at-hli'::character varying, 'article'::character varying]::text[]))");
            $this->addConstraintIfNotExists('publications', 'publications_status_check',
                "ALTER TABLE publications ADD CONSTRAINT publications_status_check CHECK (status::text = ANY (ARRAY['draft'::character varying, 'published'::character varying, 'archived'::character varying]::text[]))");
        } else {
            $this->addConstraintIfNotExists('publications', 'publications_category_check',
                "ALTER TABLE publications ADD CONSTRAINT publications_category_check CHECK (category::text = ANY (ARRAY['press-release'::character varying, 'company-activities'::character varying, 'life-at-hli'::character varying, 'article'::character varying]::text[]))");
            $this->addConstraintIfNotExists('publications', 'publications_status_check',
                "ALTER TABLE publications ADD CONSTRAINT publications_status_check CHECK (status::text = ANY (ARRAY['draft'::character varying, 'published'::character varying, 'archived'::character varying]::text[]))");
        }

        // Create sessions table
        if (!Schema::hasTable('sessions')) {
            Schema::create('sessions', function (Blueprint $table) {
                $table->string('id', 255)->primary();
                $table->bigInteger('user_id')->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->text('payload');
                $table->integer('last_activity');
            });
        }

        // Create users table
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
            $table->id();
                $table->string('name', 255);
                $table->string('email', 255)->unique();
                $table->timestamp('email_verified_at', 0)->nullable();
                $table->string('password', 255);
                $table->string('remember_token', 100)->nullable();
                $table->timestamp('created_at', 0)->nullable();
                $table->timestamp('updated_at', 0)->nullable();
                $table->string('phone', 255)->nullable();
                $table->string('position', 255)->nullable();
                $table->text('bio')->nullable();
            });
        }

        // Add indexes
        $this->addIndexes();

        // Add foreign key constraints
        $this->addForeignKeys();
    }

    /**
     * Helper method to add constraint if it doesn't exist
     */
    private function addConstraintIfNotExists(string $table, string $constraintName, string $sql): void
    {
        $exists = DB::selectOne("
            SELECT 1 FROM pg_constraint 
            WHERE conname = ? AND connamespace = (
                SELECT oid FROM pg_namespace WHERE nspname = 'public'
            )
        ", [$constraintName]);

        if (!$exists) {
            DB::statement($sql);
        }
    }

    /**
     * Add indexes from SQL dump
     */
    private function addIndexes(): void
    {
        // Career application achievements indexes
        DB::statement('CREATE INDEX IF NOT EXISTS career_application_achievements_achievement_date_index ON career_application_achievements (achievement_date)');
        DB::statement('CREATE INDEX IF NOT EXISTS career_application_achievements_career_application_id_sort_orde ON career_application_achievements (career_application_id, sort_order)');
        DB::statement('CREATE INDEX IF NOT EXISTS career_application_achievements_category_index ON career_application_achievements (category)');

        // Career application certifications indexes
        DB::statement('CREATE INDEX IF NOT EXISTS career_application_certifications_career_application_id_sort_or ON career_application_certifications (career_application_id, sort_order)');
        DB::statement('CREATE INDEX IF NOT EXISTS career_application_certifications_certification_name_index ON career_application_certifications (certification_name)');
        DB::statement('CREATE INDEX IF NOT EXISTS career_application_certifications_certification_type_index ON career_application_certifications (certification_type)');
        DB::statement('CREATE INDEX IF NOT EXISTS career_application_certifications_issue_date_index ON career_application_certifications (issue_date)');
        DB::statement('CREATE INDEX IF NOT EXISTS career_application_certifications_issuing_organization_index ON career_application_certifications (issuing_organization)');
        DB::statement('CREATE INDEX IF NOT EXISTS career_application_certifications_status_index ON career_application_certifications (status)');

        // Career application educations indexes
        DB::statement('CREATE INDEX IF NOT EXISTS career_application_educations_career_application_id_sort_order_ ON career_application_educations (career_application_id, sort_order)');
        DB::statement('CREATE INDEX IF NOT EXISTS career_application_educations_level_index ON career_application_educations (level)');

        // Career application experiences indexes
        DB::statement('CREATE INDEX IF NOT EXISTS career_application_experiences_career_application_id_sort_order ON career_application_experiences (career_application_id, sort_order)');
        DB::statement('CREATE INDEX IF NOT EXISTS career_application_experiences_company_name_index ON career_application_experiences (company_name)');
        DB::statement('CREATE INDEX IF NOT EXISTS career_application_experiences_is_current_index ON career_application_experiences (is_current)');
        DB::statement('CREATE INDEX IF NOT EXISTS career_application_experiences_position_index ON career_application_experiences (position)');

        // Career application languages indexes
        DB::statement('CREATE INDEX IF NOT EXISTS career_application_languages_career_application_id_sort_order_i ON career_application_languages (career_application_id, sort_order)');
        DB::statement('CREATE INDEX IF NOT EXISTS career_application_languages_language_name_index ON career_application_languages (language_name)');
        DB::statement('CREATE INDEX IF NOT EXISTS career_application_languages_proficiency_level_index ON career_application_languages (proficiency_level)');

        // Career application references indexes
        DB::statement('CREATE INDEX IF NOT EXISTS career_application_references_career_application_id_sort_order_ ON career_application_references (career_application_id, sort_order)');

        // Career application skills indexes
        DB::statement('CREATE INDEX IF NOT EXISTS career_application_skills_career_application_id_sort_order_inde ON career_application_skills (career_application_id, sort_order)');

        // Career applications indexes
        DB::statement('CREATE INDEX IF NOT EXISTS career_applications_email_index ON career_applications (email)');
        DB::statement('CREATE INDEX IF NOT EXISTS career_applications_status_index ON career_applications (status)');
        // Note: vacancy_id foreign key will create an index automatically, but we'll create it explicitly if needed

        // Departments indexes
        DB::statement('CREATE INDEX IF NOT EXISTS departments_is_active_sort_order_index ON departments (is_active, sort_order)');

        // Jobs indexes
        DB::statement('CREATE INDEX IF NOT EXISTS jobs_queue_index ON jobs (queue)');

        // Publications indexes
        DB::statement('CREATE INDEX IF NOT EXISTS publications_status_published_date_index ON publications (status, published_date)');
        DB::statement('CREATE INDEX IF NOT EXISTS publications_category_status_index ON publications (category, status)');
        DB::statement('CREATE INDEX IF NOT EXISTS publications_featured_published_date_index ON publications (featured, published_date)');

        // Sessions indexes
        DB::statement('CREATE INDEX IF NOT EXISTS sessions_user_id_index ON sessions (user_id)');
        DB::statement('CREATE INDEX IF NOT EXISTS sessions_last_activity_index ON sessions (last_activity)');

        // Vacancies indexes (note: table was renamed from career_jobs to vacancies, but index name still references career_jobs)
        DB::statement('CREATE INDEX IF NOT EXISTS career_jobs_created_by_index ON vacancies (created_by)');
        DB::statement('CREATE INDEX IF NOT EXISTS vacancies_updated_by_index ON vacancies (updated_by)');

        // Additional indexes from SQL dump
        DB::statement('CREATE INDEX IF NOT EXISTS career_application_skills_category_index ON career_application_skills (category)');
        DB::statement('CREATE INDEX IF NOT EXISTS career_application_skills_proficiency_level_index ON career_application_skills (proficiency_level)');
        DB::statement('CREATE INDEX IF NOT EXISTS career_application_skills_skill_name_index ON career_application_skills (skill_name)');
        DB::statement('CREATE INDEX IF NOT EXISTS career_applications_applied_position_index ON career_applications (applied_position)');
        DB::statement('CREATE INDEX IF NOT EXISTS career_applications_read_status_index ON career_applications (read_status)');
        DB::statement('CREATE INDEX IF NOT EXISTS career_applications_status_created_at_index ON career_applications (status, created_at)');
        DB::statement('CREATE INDEX IF NOT EXISTS career_applications_status_read_status_index ON career_applications (status, read_status)');
        DB::statement('CREATE INDEX IF NOT EXISTS career_applications_updated_by_index ON career_applications (updated_by)');
        DB::statement('CREATE INDEX IF NOT EXISTS departments_code_index ON departments (code)');
    }

    /**
     * Add foreign key constraints from SQL dump
     */
    private function addForeignKeys(): void
    {
        // Career application related foreign keys
        $this->addConstraintIfNotExists('career_application_achievements', 'career_application_achievements_career_application_id_foreign',
            'ALTER TABLE career_application_achievements ADD CONSTRAINT career_application_achievements_career_application_id_foreign FOREIGN KEY (career_application_id) REFERENCES career_applications(id) ON DELETE CASCADE');
        
        $this->addConstraintIfNotExists('career_application_certifications', 'career_application_certifications_career_application_id_foreign',
            'ALTER TABLE career_application_certifications ADD CONSTRAINT career_application_certifications_career_application_id_foreign FOREIGN KEY (career_application_id) REFERENCES career_applications(id) ON DELETE CASCADE');
        
        $this->addConstraintIfNotExists('career_application_educations', 'career_application_educations_career_application_id_foreign',
            'ALTER TABLE career_application_educations ADD CONSTRAINT career_application_educations_career_application_id_foreign FOREIGN KEY (career_application_id) REFERENCES career_applications(id) ON DELETE CASCADE');
        
        $this->addConstraintIfNotExists('career_application_experiences', 'career_application_experiences_career_application_id_foreign',
            'ALTER TABLE career_application_experiences ADD CONSTRAINT career_application_experiences_career_application_id_foreign FOREIGN KEY (career_application_id) REFERENCES career_applications(id) ON DELETE CASCADE');
        
        $this->addConstraintIfNotExists('career_application_languages', 'career_application_languages_career_application_id_foreign',
            'ALTER TABLE career_application_languages ADD CONSTRAINT career_application_languages_career_application_id_foreign FOREIGN KEY (career_application_id) REFERENCES career_applications(id) ON DELETE CASCADE');
        
        $this->addConstraintIfNotExists('career_application_references', 'career_application_references_career_application_id_foreign',
            'ALTER TABLE career_application_references ADD CONSTRAINT career_application_references_career_application_id_foreign FOREIGN KEY (career_application_id) REFERENCES career_applications(id) ON DELETE CASCADE');
        
        $this->addConstraintIfNotExists('career_application_skills', 'career_application_skills_career_application_id_foreign',
            'ALTER TABLE career_application_skills ADD CONSTRAINT career_application_skills_career_application_id_foreign FOREIGN KEY (career_application_id) REFERENCES career_applications(id) ON DELETE CASCADE');

        // Career applications foreign keys
        $this->addConstraintIfNotExists('career_applications', 'career_applications_updated_by_foreign',
            'ALTER TABLE career_applications ADD CONSTRAINT career_applications_updated_by_foreign FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL');
        
        $this->addConstraintIfNotExists('career_applications', 'career_applications_vacancy_id_foreign',
            'ALTER TABLE career_applications ADD CONSTRAINT career_applications_vacancy_id_foreign FOREIGN KEY (vacancy_id) REFERENCES vacancies(id) ON DELETE SET NULL');

        // Publications foreign keys
        $this->addConstraintIfNotExists('publications', 'publications_created_by_foreign',
            'ALTER TABLE publications ADD CONSTRAINT publications_created_by_foreign FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL');
        
        $this->addConstraintIfNotExists('publications', 'publications_updated_by_foreign',
            'ALTER TABLE publications ADD CONSTRAINT publications_updated_by_foreign FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL');

        // Vacancies foreign keys
        $this->addConstraintIfNotExists('vacancies', 'vacancies_created_by_foreign',
            'ALTER TABLE vacancies ADD CONSTRAINT vacancies_created_by_foreign FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE');
        
        $this->addConstraintIfNotExists('vacancies', 'vacancies_updated_by_foreign',
            'ALTER TABLE vacancies ADD CONSTRAINT vacancies_updated_by_foreign FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('career_application_achievements');
        Schema::dropIfExists('career_application_certifications');
        Schema::dropIfExists('career_application_educations');
        Schema::dropIfExists('career_application_experiences');
        Schema::dropIfExists('career_application_languages');
        Schema::dropIfExists('career_application_references');
        Schema::dropIfExists('career_application_skills');
        Schema::dropIfExists('career_applications');
        Schema::dropIfExists('vacancies');
        Schema::dropIfExists('contact_submissions');
        Schema::dropIfExists('departments');
        Schema::dropIfExists('publications');
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('migrations');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('cache_locks');
        Schema::dropIfExists('cache');
    }
};
