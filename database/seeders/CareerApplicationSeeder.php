<?php

namespace Database\Seeders;

use App\Models\CareerApplication;
use App\Models\CareerApplicationEducation;
use App\Models\CareerApplicationLanguage;
use App\Models\CareerApplicationExperience;
use App\Models\CareerApplicationAchievement;
use App\Models\CareerApplicationSkill;
use App\Models\CareerApplicationCertification;
use App\Models\Vacancy;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CareerApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        // Get available vacancies for applications
        $jobs = Vacancy::all();
        
        if ($jobs->isEmpty()) {
            $this->command->warn('No vacancies found. Please run VacancySeeder first.');
            return;
        }

        // Generate diverse applications for different positions
        $totalApplications = 1000;
        $this->command->info("Creating {$totalApplications} career applications...");
        
        // Use chunking for better memory management
        $chunkSize = 50;
        $chunks = ceil($totalApplications / $chunkSize);
        
        for ($chunk = 0; $chunk < $chunks; $chunk++) {
            $start = $chunk * $chunkSize;
            $end = min($start + $chunkSize, $totalApplications);
            
            for ($i = $start; $i < $end; $i++) {
                $job = $jobs->random();
                $isRecent = $faker->boolean(70); // 70% chance of recent application
                
                // Create main application
                $application = CareerApplication::create([
                // Personal Data
                'full_name' => $faker->name(),
                'nationality' => $faker->randomElement(['Indonesian', 'Malaysian', 'Singaporean', 'Filipino', 'Thai', 'Vietnamese']),
                'sex' => $faker->randomElement(['male', 'female']),
                'date_of_birth' => $faker->dateTimeBetween('-50 years', '-18 years'),
                'place_of_birth' => $faker->city(),
                'marital_status' => $faker->randomElement(['single', 'married', 'divorced', 'widowed']),
                'id_address' => $faker->address(),
                'current_address' => $faker->address(),
                'phone_number' => $faker->phoneNumber(),
                'email' => $faker->unique()->safeEmail(),
                'linkedin_profile' => $faker->optional(0.8)->url(),
                'social_media' => $faker->optional(0.6)->userName(),
                
                
                // Application Status
                'status' => $faker->randomElement(['unread', 'read', 'shortlisted', 'interview', 'not_suitable']),
                'read_status' => $faker->boolean(60), // 60% are read
                'read_at' => $faker->optional(0.6)->dateTimeBetween('-30 days', 'now'),
                'talent_pool' => $faker->boolean(20), // 20% in talent pool
                'notes' => $faker->optional(0.4)->paragraph(),
                'applied_position' => $job->title,
                
                // Timestamps
                'created_at' => $isRecent ? $faker->dateTimeBetween('-30 days', 'now') : $faker->dateTimeBetween('-6 months', '-30 days'),
                'updated_at' => $faker->dateTimeBetween('-30 days', 'now'),
            ]);

                // Create educations (1-3 per application)
                $educationCount = $faker->numberBetween(1, 3);
                for ($j = 0; $j < $educationCount; $j++) {
                    CareerApplicationEducation::create([
                    'career_application_id' => $application->id,
                    'level' => $faker->randomElement(['smk1', 'smk2', 'd3-1', 'd3-2', 's1', 's2', 's3']),
                    'school_name' => $faker->randomElement([
                        'Universitas Indonesia',
                        'Institut Teknologi Bandung',
                        'Universitas Gadjah Mada',
                        'Universitas Brawijaya',
                        'Institut Teknologi Sepuluh Nopember',
                        'Universitas Diponegoro',
                        'Universitas Airlangga',
                        'Universitas Hasanuddin',
                        'Universitas Padjadjaran',
                        'Universitas Sebelas Maret'
                    ]),
                    'faculty' => $faker->randomElement([
                        'Fakultas Teknik',
                        'Fakultas Ilmu Komputer',
                        'Fakultas Ekonomi',
                        'Fakultas Psikologi',
                        'Fakultas Hukum',
                        'Fakultas Kedokteran',
                        'Fakultas Sastra',
                        'Fakultas Pertanian'
                    ]),
                    'major' => $faker->randomElement([
                        'Teknik Informatika',
                        'Sistem Informasi',
                        'Teknik Elektro',
                        'Manajemen',
                        'Akuntansi',
                        'Psikologi',
                        'Hukum',
                        'Kedokteran',
                        'Sastra Inggris',
                        'Agribisnis'
                    ]),
                    'start_year' => (string) $faker->numberBetween(2010, 2020),
                    'end_year' => (string) $faker->numberBetween(2015, 2023),
                    'graduate_year' => (string) $faker->numberBetween(2015, 2023),
                    'gpa' => $faker->randomFloat(2, 2.5, 4.0),
                    'certificate_path' => $faker->optional(0.9)->filePath(),
                    'description' => $faker->optional(0.7)->paragraph(),
                    'is_current' => $j === 0 && $faker->boolean(20), // Only first education can be current
                    'sort_order' => $j,
                    ]);
                }

                // Create languages (2-5 per application)
                $languageCount = $faker->numberBetween(2, 5);
                $languages = ['Bahasa Indonesia', 'English', 'Mandarin', 'Japanese', 'Korean', 'Arabic', 'French', 'German'];
                $selectedLanguages = $faker->randomElements($languages, $languageCount);
                
                for ($j = 0; $j < $languageCount; $j++) {
                    CareerApplicationLanguage::create([
                    'career_application_id' => $application->id,
                    'language_name' => $selectedLanguages[$j],
                    'proficiency_level' => $faker->randomElement(['beginner', 'intermediate', 'advanced', 'native', 'fluent']),
                    'speaking_level' => $faker->randomElement(['beginner', 'intermediate', 'advanced', 'native', 'fluent']),
                    'writing_level' => $faker->randomElement(['beginner', 'intermediate', 'advanced', 'native', 'fluent']),
                    'reading_level' => $faker->randomElement(['beginner', 'intermediate', 'advanced', 'native', 'fluent']),
                    'listening_level' => $faker->randomElement(['beginner', 'intermediate', 'advanced', 'native', 'fluent']),
                    'certificate_name' => $faker->optional(0.3)->randomElement(['TOEFL', 'IELTS', 'HSK', 'JLPT', 'TOPIK']),
                    'certificate_path' => $faker->optional(0.3)->filePath(),
                    'certificate_date' => $faker->optional(0.3)->dateTimeBetween('-2 years', 'now'),
                    'notes' => $faker->optional(0.4)->sentence(),
                    'sort_order' => $j,
                    ]);
                }

                // Create experiences (1-4 per application)
                $experienceCount = $faker->numberBetween(1, 4);
                for ($j = 0; $j < $experienceCount; $j++) {
                    $isCurrent = $j === 0 && $faker->boolean(30); // First experience might be current
                    $startDate = $faker->dateTimeBetween('-8 years', '-1 year');
                    
                    CareerApplicationExperience::create([
                    'career_application_id' => $application->id,
                    'company_name' => $faker->randomElement([
                        'PT Telkom Indonesia',
                        'PT Bank Central Asia',
                        'PT Astra International',
                        'PT Unilever Indonesia',
                        'PT Indofood Sukses Makmur',
                        'PT Gudang Garam',
                        'PT Sampoerna',
                        'PT Kalbe Farma',
                        'PT Adaro Energy',
                        'PT Semen Indonesia',
                        'PT Gojek Indonesia',
                        'PT Tokopedia',
                        'PT Shopee Indonesia',
                        'PT Bukalapak',
                        'PT Traveloka'
                    ]),
                    'position' => $faker->jobTitle(),
                    'job_description' => $faker->paragraphs(2, true),
                    'start_year' => (string) $startDate->format('Y'),
                    'end_year' => $isCurrent ? null : (string) $faker->numberBetween((int)$startDate->format('Y'), (int)date('Y')),
                    'employment_type' => $faker->randomElement(['full-time', 'part-time', 'contract', 'internship', 'freelance']),
                    'salary_range' => $faker->randomElement([
                        'Rp 5.000.000 - Rp 8.000.000',
                        'Rp 8.000.000 - Rp 12.000.000',
                        'Rp 12.000.000 - Rp 18.000.000',
                        'Rp 18.000.000 - Rp 25.000.000',
                        'Rp 25.000.000 - Rp 35.000.000'
                    ]),
                    'reasons_for_leaving' => $isCurrent ? null : $faker->optional(0.8)->randomElement([
                        'Looking for better career opportunities',
                        'Seeking new challenges',
                        'Company restructuring',
                        'Relocation',
                        'Better work-life balance',
                        'Higher salary expectations',
                        'Career advancement'
                    ]),
                    'supervisor_name' => $faker->optional(0.7)->name(),
                    'supervisor_contact' => $faker->optional(0.7)->phoneNumber(),
                    'achievements' => $faker->optional(0.8)->paragraphs(2, true),
                    'responsibilities' => $faker->optional(0.9)->paragraphs(3, true),
                    'is_current' => $isCurrent,
                    'sort_order' => $j,
                    ]);
                }

                // Create achievements (1-6 per application)
                $achievementCount = $faker->numberBetween(1, 6);
                for ($j = 0; $j < $achievementCount; $j++) {
                    CareerApplicationAchievement::create([
                    'career_application_id' => $application->id,
                    'title' => $faker->randomElement([
                        'Best Employee of the Year',
                        'Project Excellence Award',
                        'Innovation Award',
                        'Leadership Recognition',
                        'Academic Excellence',
                        'Community Service Award',
                        'Sales Achievement',
                        'Customer Satisfaction Award',
                        'Team Player Award',
                        'Problem Solver Recognition'
                    ]),
                    'description' => $faker->paragraphs(2, true),
                    'organization' => $faker->company(),
                    'achievement_date' => $faker->dateTimeBetween('-5 years', 'now'),
                    'year' => $faker->year(),
                    'category' => $faker->randomElement(['academic', 'professional', 'personal', 'sports', 'volunteer', 'leadership', 'innovation']),
                    'certificate_path' => $faker->optional(0.6)->filePath(),
                    'verification_url' => $faker->optional(0.3)->url(),
                    'impact' => $faker->optional(0.7)->paragraph(),
                    'sort_order' => $j,
                    ]);
                }

                // Create skills (5-15 per application)
                $skillCount = $faker->numberBetween(5, 15);
                $skills = [
                    'PHP', 'JavaScript', 'Python', 'Java', 'C++', 'React', 'Vue.js', 'Angular',
                    'Laravel', 'Node.js', 'MySQL', 'PostgreSQL', 'MongoDB', 'Redis',
                    'AWS', 'Docker', 'Kubernetes', 'Git', 'Linux', 'Windows',
                    'Project Management', 'Agile', 'Scrum', 'Leadership', 'Communication',
                    'Problem Solving', 'Teamwork', 'Time Management', 'Analytical Thinking',
                    'Photoshop', 'Illustrator', 'Figma', 'Sketch', 'Adobe XD',
                    'SEO', 'Digital Marketing', 'Content Writing', 'Social Media Management'
                ];
                $selectedSkills = $faker->randomElements($skills, $skillCount);
                
                for ($j = 0; $j < $skillCount; $j++) {
                    CareerApplicationSkill::create([
                    'career_application_id' => $application->id,
                    'skill_name' => $selectedSkills[$j],
                    'proficiency_level' => $faker->randomElement(['beginner', 'intermediate', 'advanced', 'expert']),
                    'category' => $faker->randomElement(['technical', 'soft', 'language', 'software', 'hardware', 'management', 'design', 'marketing', 'sales']),
                    'years_experience' => $faker->numberBetween(1, 10),
                    'description' => $faker->optional(0.6)->sentence(),
                    'certification_name' => $faker->optional(0.2)->randomElement(['AWS Certified', 'Google Analytics', 'PMP', 'Scrum Master', 'Adobe Certified']),
                    'certification_path' => $faker->optional(0.2)->filePath(),
                    'certification_date' => $faker->optional(0.2)->dateTimeBetween('-2 years', 'now'),
                    'notes' => $faker->optional(0.3)->sentence(),
                    'sort_order' => $j,
                    ]);
                }

                // Create certifications (2-8 per application)
                $certificationCount = $faker->numberBetween(2, 8);
                $certifications = [
                    // Professional Certifications
                    ['name' => 'PMP (Project Management Professional)', 'org' => 'PMI', 'type' => 'professional'],
                ['name' => 'Certified Public Accountant (CPA)', 'org' => 'AICPA', 'type' => 'professional'],
                ['name' => 'Certified Information Systems Auditor (CISA)', 'org' => 'ISACA', 'type' => 'professional'],
                ['name' => 'Certified Information Security Manager (CISM)', 'org' => 'ISACA', 'type' => 'professional'],
                ['name' => 'Certified Scrum Master (CSM)', 'org' => 'Scrum Alliance', 'type' => 'management'],
                ['name' => 'Certified Product Owner (CSPO)', 'org' => 'Scrum Alliance', 'type' => 'management'],
                
                // Technical Certifications
                ['name' => 'AWS Certified Solutions Architect', 'org' => 'Amazon Web Services', 'type' => 'technical'],
                ['name' => 'AWS Certified Developer', 'org' => 'Amazon Web Services', 'type' => 'technical'],
                ['name' => 'Microsoft Azure Fundamentals', 'org' => 'Microsoft', 'type' => 'technical'],
                ['name' => 'Google Cloud Professional', 'org' => 'Google Cloud', 'type' => 'technical'],
                ['name' => 'Cisco Certified Network Associate (CCNA)', 'org' => 'Cisco', 'type' => 'technical'],
                ['name' => 'CompTIA Security+', 'org' => 'CompTIA', 'type' => 'technical'],
                ['name' => 'Oracle Certified Java Developer', 'org' => 'Oracle', 'type' => 'technical'],
                ['name' => 'Microsoft Certified: Azure Developer', 'org' => 'Microsoft', 'type' => 'technical'],
                
                // Software Certifications
                ['name' => 'Adobe Certified Expert (ACE)', 'org' => 'Adobe', 'type' => 'software'],
                ['name' => 'Autodesk Certified Professional', 'org' => 'Autodesk', 'type' => 'software'],
                ['name' => 'Salesforce Certified Administrator', 'org' => 'Salesforce', 'type' => 'software'],
                ['name' => 'HubSpot Content Marketing Certification', 'org' => 'HubSpot', 'type' => 'software'],
                
                // Language Certifications
                ['name' => 'TOEFL iBT', 'org' => 'ETS', 'type' => 'language'],
                ['name' => 'IELTS Academic', 'org' => 'British Council', 'type' => 'language'],
                ['name' => 'HSK (Chinese Proficiency Test)', 'org' => 'Confucius Institute', 'type' => 'language'],
                ['name' => 'JLPT N1 (Japanese Language Proficiency)', 'org' => 'Japan Foundation', 'type' => 'language'],
                ['name' => 'TOPIK Level 6 (Korean Proficiency)', 'org' => 'National Institute for Korean Language', 'type' => 'language'],
                
                // Industry Certifications
                ['name' => 'Six Sigma Green Belt', 'org' => 'ASQ', 'type' => 'industry'],
                ['name' => 'Six Sigma Black Belt', 'org' => 'ASQ', 'type' => 'industry'],
                ['name' => 'ISO 9001:2015 Lead Auditor', 'org' => 'ISO', 'type' => 'industry'],
                ['name' => 'Lean Manufacturing Certification', 'org' => 'ASQ', 'type' => 'industry'],
                
                // Safety Certifications
                ['name' => 'OSHA 30-Hour Construction Safety', 'org' => 'OSHA', 'type' => 'safety'],
                ['name' => 'First Aid & CPR Certification', 'org' => 'Red Cross', 'type' => 'safety'],
                ['name' => 'Workplace Safety Certification', 'org' => 'NEBOSH', 'type' => 'safety'],
                
                // Academic Certifications
                ['name' => 'Data Science Professional Certificate', 'org' => 'IBM', 'type' => 'academic'],
                ['name' => 'Machine Learning Engineer Certificate', 'org' => 'Google', 'type' => 'academic'],
                ['name' => 'Digital Marketing Certificate', 'org' => 'Google', 'type' => 'academic'],
            ];
            
                $selectedCertifications = $faker->randomElements($certifications, min($certificationCount, count($certifications)));
                
                for ($j = 0; $j < $certificationCount; $j++) {
                    $cert = $selectedCertifications[$j] ?? $faker->randomElement($certifications);
                    $issueDate = $faker->dateTimeBetween('-5 years', 'now');
                    $hasExpiry = $faker->boolean(60); // 60% have expiry dates
                    
                    CareerApplicationCertification::create([
                    'career_application_id' => $application->id,
                    'certification_name' => $cert['name'],
                    'issuing_organization' => $cert['org'],
                    'issue_date' => $issueDate,
                    'expiry_date' => $hasExpiry ? $faker->dateTimeBetween($issueDate, '+3 years') : null,
                    'certification_number' => $faker->optional(0.8)->bothify('CERT-####-####'),
                    'credential_id' => $faker->optional(0.7)->uuid(),
                    'certificate_path' => $faker->optional(0.9)->filePath(),
                    'certification_type' => $cert['type'],
                    'status' => $hasExpiry && $faker->boolean(10) ? 'expired' : 'active',
                    'description' => $faker->optional(0.6)->paragraph(),
                    'notes' => $faker->optional(0.4)->sentence(),
                    'is_verified' => $faker->boolean(85), // 85% are verified
                    'sort_order' => $j,
                    ]);
                }
            } // Close inner for loop ($i)
            
            // Show progress every chunk
            $this->command->info("Created " . ($end) . " / {$totalApplications} applications...");
        } // Close chunk loop

        // Create some applications with specific statuses for testing
        $this->createSpecificApplications($jobs);

        $this->command->info("Successfully created {$totalApplications} career applications with related data.");
    }

    /**
     * Create specific applications for testing different scenarios
     */
    private function createSpecificApplications($jobs): void
    {
        $faker = Faker::create();

        // High-quality application (likely to be accepted)
        $application = CareerApplication::create([
            'full_name' => 'Ahmad Wijaya',
            'nationality' => 'Indonesian',
            'sex' => 'male',
            'date_of_birth' => '1990-05-15',
            'place_of_birth' => 'Jakarta',
            'marital_status' => 'married',
            'id_address' => 'Jl. Sudirman No. 123, Jakarta Selatan',
            'current_address' => 'Jl. Gatot Subroto No. 456, Jakarta Selatan',
            'phone_number' => '+6281234567890',
            'email' => 'ahmad.wijaya@email.com',
            'linkedin_profile' => 'https://linkedin.com/in/ahmad-wijaya',
            'social_media' => '@ahmadwijaya',
            'status' => 'accepted',
            'notes' => 'Excellent candidate with strong technical skills and leadership experience.',
            'applied_position' => $jobs->where('title', 'Senior Full Stack Developer')->first()?->title ?? $jobs->first()->title,
            'created_at' => now()->subDays(5),
            'updated_at' => now()->subDays(1),
        ]);

        // Add education
        CareerApplicationEducation::create([
            'career_application_id' => $application->id,
            'level' => 's1',
            'school_name' => 'Institut Teknologi Bandung',
            'faculty' => 'Fakultas Teknik',
            'major' => 'Teknik Informatika',
            'start_year' => '2008',
            'end_year' => '2012',
            'graduate_year' => '2012',
            'gpa' => 3.75,
            'certificate_path' => '/certificates/ahmad_wijaya_s1.pdf',
            'is_current' => false,
            'sort_order' => 0,
        ]);

        // Add languages
        CareerApplicationLanguage::create([
            'career_application_id' => $application->id,
            'language_name' => 'Bahasa Indonesia',
            'proficiency_level' => 'native',
            'speaking_level' => 'native',
            'writing_level' => 'native',
            'reading_level' => 'native',
            'listening_level' => 'native',
            'sort_order' => 0,
        ]);

        CareerApplicationLanguage::create([
            'career_application_id' => $application->id,
            'language_name' => 'English',
            'proficiency_level' => 'fluent',
            'speaking_level' => 'advanced',
            'writing_level' => 'advanced',
            'reading_level' => 'fluent',
            'listening_level' => 'fluent',
            'certificate_name' => 'TOEFL',
            'certificate_date' => '2020-03-15',
            'sort_order' => 1,
        ]);

        // Add experience
        CareerApplicationExperience::create([
            'career_application_id' => $application->id,
            'company_name' => 'PT Gojek Indonesia',
            'position' => 'Senior Software Engineer',
            'job_description' => 'Led development of microservices architecture for payment systems. Implemented CI/CD pipelines and automated testing. Mentored junior developers and conducted code reviews.',
            'start_year' => '2018',
            'end_year' => null,
            'employment_type' => 'full-time',
            'salary_range' => 'Rp 25.000.000 - Rp 35.000.000',
            'reasons_for_leaving' => null,
            'supervisor_name' => 'Budi Santoso',
            'supervisor_contact' => '+6281234567891',
            'achievements' => 'Successfully led a team of 5 developers to deliver a critical payment system that processed over 1 million transactions daily.',
            'responsibilities' => 'Lead technical architecture decisions, mentor junior developers, conduct code reviews, implement best practices.',
            'is_current' => true,
            'sort_order' => 0,
        ]);

        // Add achievements
        CareerApplicationAchievement::create([
            'career_application_id' => $application->id,
            'title' => 'Best Employee of the Year',
            'description' => 'Recognized for outstanding performance and leadership in developing critical payment systems.',
            'organization' => 'PT Gojek Indonesia',
            'achievement_date' => '2023-12-15',
            'year' => '2023',
            'category' => 'professional',
            'sort_order' => 0,
        ]);

        // Add skills
        $skills = ['PHP', 'Laravel', 'JavaScript', 'React', 'Node.js', 'MySQL', 'AWS', 'Docker', 'Git', 'Leadership'];
        foreach ($skills as $index => $skill) {
            CareerApplicationSkill::create([
                'career_application_id' => $application->id,
                'skill_name' => $skill,
                'proficiency_level' => $index < 5 ? 'expert' : 'advanced',
                'category' => in_array($skill, ['Leadership']) ? 'soft' : 'technical',
                'years_experience' => $faker->numberBetween(3, 8),
                'sort_order' => $index,
            ]);
        }
    }
}