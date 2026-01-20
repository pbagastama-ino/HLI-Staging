<?php

namespace Database\Seeders;

use App\Models\CareerJob;
use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Seeder;

class CareerJobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get departments and users for foreign keys
        $departments = Department::all();
        $users = User::all();
        
        if ($departments->isEmpty() || $users->isEmpty()) {
            $this->command->warn('No departments or users found. Please run DepartmentSeeder and create users first.');
            return;
        }

        $jobs = [
            // Engineering Jobs
            [
                'title' => 'Senior Full Stack Developer',
                'description' => 'We are looking for an experienced Full Stack Developer to join our engineering team. You will be responsible for developing and maintaining web applications using modern technologies.',
                'requirements' => 'Bachelor\'s degree in Computer Science or related field. 5+ years of experience with React, Node.js, and PostgreSQL. Strong understanding of RESTful APIs and microservices architecture.',
                'responsibilities' => 'Develop and maintain web applications, collaborate with cross-functional teams, write clean and maintainable code, participate in code reviews, mentor junior developers.',
                'benefits' => 'Competitive salary, health insurance, flexible working hours, remote work options, professional development budget, stock options.',
                'department_id' => $departments->where('code', 'ENG')->first()->id,
                'employment_type' => 'full-time',
                'experience_level' => 'senior',
                'location' => 'San Francisco, CA',
                'remote_allowed' => true,
                'salary_range' => '$120,000 - $160,000',
                'application_deadline' => now()->addDays(30),
                'max_applications' => 50,
                'application_instructions' => 'Please submit your resume, cover letter, and GitHub profile. Include links to your best projects.',
                'status' => 'published',
                'featured' => true,
                'priority' => 10,
                'meta_title' => 'Senior Full Stack Developer - Join Our Engineering Team',
                'meta_description' => 'Exciting opportunity for a Senior Full Stack Developer to join our growing engineering team.',
                'meta_keywords' => 'full stack developer, react, node.js, javascript, software engineer',
                'created_by' => $users->first()->id,
                'published_at' => now(),
            ],
            [
                'title' => 'Frontend Developer',
                'description' => 'Join our frontend team to build beautiful and responsive user interfaces. You will work with modern frameworks and collaborate with designers to create exceptional user experiences.',
                'requirements' => '3+ years of experience with React, Vue.js, or Angular. Strong CSS and JavaScript skills. Experience with responsive design and accessibility.',
                'responsibilities' => 'Build responsive web interfaces, implement design systems, optimize for performance, ensure cross-browser compatibility, collaborate with UX/UI designers.',
                'benefits' => 'Competitive salary, health insurance, flexible schedule, learning opportunities, team events.',
                'department_id' => $departments->where('code', 'ENG')->first()->id,
                'employment_type' => 'full-time',
                'experience_level' => 'mid',
                'location' => 'New York, NY',
                'remote_allowed' => true,
                'salary_range' => '$90,000 - $120,000',
                'application_deadline' => now()->addDays(45),
                'max_applications' => 30,
                'application_instructions' => 'Submit your portfolio showcasing your best frontend work.',
                'status' => 'published',
                'featured' => false,
                'priority' => 5,
                'meta_title' => 'Frontend Developer - React/Vue.js',
                'meta_description' => 'Frontend developer position with React/Vue.js experience required.',
                'meta_keywords' => 'frontend developer, react, vue.js, javascript, css',
                'created_by' => $users->first()->id,
                'published_at' => now(),
            ],
            [
                'title' => 'DevOps Engineer',
                'description' => 'We need a DevOps Engineer to help us scale our infrastructure and improve our deployment processes. You will work with cloud technologies and automation tools.',
                'requirements' => 'Experience with AWS, Docker, Kubernetes, CI/CD pipelines. Knowledge of infrastructure as code (Terraform, CloudFormation). Linux system administration skills.',
                'responsibilities' => 'Manage cloud infrastructure, automate deployment processes, monitor system performance, ensure security best practices, collaborate with development teams.',
                'benefits' => 'Competitive salary, health insurance, remote work, professional development, conference attendance.',
                'department_id' => $departments->where('code', 'ENG')->first()->id,
                'employment_type' => 'full-time',
                'experience_level' => 'senior',
                'location' => 'Austin, TX',
                'remote_allowed' => true,
                'salary_range' => '$110,000 - $150,000',
                'application_deadline' => now()->addDays(60),
                'max_applications' => 25,
                'application_instructions' => 'Include examples of infrastructure automation and monitoring setups.',
                'status' => 'published',
                'featured' => true,
                'priority' => 8,
                'meta_title' => 'DevOps Engineer - AWS/Kubernetes',
                'meta_description' => 'DevOps Engineer position with AWS and Kubernetes experience.',
                'meta_keywords' => 'devops, aws, kubernetes, docker, infrastructure',
                'created_by' => $users->first()->id,
                'published_at' => now(),
            ],

            // Marketing Jobs
            [
                'title' => 'Digital Marketing Manager',
                'description' => 'Lead our digital marketing efforts across multiple channels. You will develop and execute marketing campaigns to drive growth and brand awareness.',
                'requirements' => 'Bachelor\'s degree in Marketing or related field. 4+ years of digital marketing experience. Proficiency in Google Analytics, Facebook Ads, and SEO tools.',
                'responsibilities' => 'Develop marketing strategies, manage digital campaigns, analyze performance metrics, coordinate with creative teams, optimize conversion rates.',
                'benefits' => 'Competitive salary, health insurance, flexible hours, marketing budget, team outings.',
                'department_id' => $departments->where('code', 'MKT')->first()->id,
                'employment_type' => 'full-time',
                'experience_level' => 'mid',
                'location' => 'Los Angeles, CA',
                'remote_allowed' => true,
                'salary_range' => '$80,000 - $110,000',
                'application_deadline' => now()->addDays(20),
                'max_applications' => 40,
                'application_instructions' => 'Include examples of successful marketing campaigns you\'ve managed.',
                'status' => 'published',
                'featured' => false,
                'priority' => 6,
                'meta_title' => 'Digital Marketing Manager - Growth Marketing',
                'meta_description' => 'Digital Marketing Manager position focusing on growth and brand awareness.',
                'meta_keywords' => 'digital marketing, growth marketing, seo, social media, analytics',
                'created_by' => $users->first()->id,
                'published_at' => now(),
            ],
            [
                'title' => 'Content Marketing Specialist',
                'description' => 'Create compelling content that engages our audience and drives conversions. You will work on blog posts, social media content, and marketing materials.',
                'requirements' => '2+ years of content marketing experience. Excellent writing skills. Experience with content management systems and social media platforms.',
                'responsibilities' => 'Create blog posts and articles, manage social media content, develop content calendars, collaborate with design team, track content performance.',
                'benefits' => 'Competitive salary, health insurance, flexible schedule, creative freedom, team collaboration.',
                'department_id' => $departments->where('code', 'MKT')->first()->id,
                'employment_type' => 'full-time',
                'experience_level' => 'entry',
                'location' => 'Chicago, IL',
                'remote_allowed' => true,
                'salary_range' => '$50,000 - $70,000',
                'application_deadline' => now()->addDays(35),
                'max_applications' => 35,
                'application_instructions' => 'Submit writing samples and examples of content you\'ve created.',
                'status' => 'published',
                'featured' => false,
                'priority' => 3,
                'meta_title' => 'Content Marketing Specialist - Creative Writing',
                'meta_description' => 'Content Marketing Specialist position for creative content creation.',
                'meta_keywords' => 'content marketing, writing, social media, blog, creative',
                'created_by' => $users->first()->id,
                'published_at' => now(),
            ],

            // Sales Jobs
            [
                'title' => 'Sales Development Representative',
                'description' => 'Join our sales team to identify and qualify potential customers. You will be the first point of contact for prospects and help build our sales pipeline.',
                'requirements' => 'Bachelor\'s degree preferred. 1+ years of sales experience. Strong communication skills and persistence. CRM experience helpful.',
                'responsibilities' => 'Prospect and qualify leads, make outbound calls, schedule demos, maintain CRM records, collaborate with account executives.',
                'benefits' => 'Base salary + commission, health insurance, sales training, career growth opportunities, team competitions.',
                'department_id' => $departments->where('code', 'SALES')->first()->id,
                'employment_type' => 'full-time',
                'experience_level' => 'entry',
                'location' => 'Denver, CO',
                'remote_allowed' => false,
                'salary_range' => '$40,000 - $60,000 + Commission',
                'application_deadline' => now()->addDays(25),
                'max_applications' => 20,
                'application_instructions' => 'Include any sales experience and examples of persistence in challenging situations.',
                'status' => 'published',
                'featured' => false,
                'priority' => 4,
                'meta_title' => 'Sales Development Representative - Entry Level Sales',
                'meta_description' => 'Entry-level sales position with growth opportunities.',
                'meta_keywords' => 'sales, sdr, business development, entry level, commission',
                'created_by' => $users->first()->id,
                'published_at' => now(),
            ],

            // HR Jobs
            [
                'title' => 'HR Generalist',
                'description' => 'Support our growing team with all aspects of human resources. You will handle recruitment, employee relations, and HR administration.',
                'requirements' => 'Bachelor\'s degree in HR or related field. 3+ years of HR experience. Knowledge of employment laws and HR best practices.',
                'responsibilities' => 'Manage recruitment process, handle employee relations, administer benefits, maintain HR records, support performance management.',
                'benefits' => 'Competitive salary, health insurance, professional development, flexible schedule, team building events.',
                'department_id' => $departments->where('code', 'HR')->first()->id,
                'employment_type' => 'full-time',
                'experience_level' => 'mid',
                'location' => 'Seattle, WA',
                'remote_allowed' => true,
                'salary_range' => '$65,000 - $85,000',
                'application_deadline' => now()->addDays(40),
                'max_applications' => 15,
                'application_instructions' => 'Include examples of HR initiatives you\'ve led or supported.',
                'status' => 'published',
                'featured' => false,
                'priority' => 5,
                'meta_title' => 'HR Generalist - Human Resources',
                'meta_description' => 'HR Generalist position supporting all aspects of human resources.',
                'meta_keywords' => 'hr, human resources, recruitment, employee relations, benefits',
                'created_by' => $users->first()->id,
                'published_at' => now(),
            ],

            // Design Jobs
            [
                'title' => 'UI/UX Designer',
                'description' => 'Design intuitive and beautiful user experiences for our products. You will work closely with product managers and developers to create user-centered designs.',
                'requirements' => '3+ years of UI/UX design experience. Proficiency in Figma, Sketch, or Adobe Creative Suite. Strong portfolio demonstrating user-centered design.',
                'responsibilities' => 'Create wireframes and prototypes, conduct user research, design user interfaces, collaborate with development teams, maintain design systems.',
                'benefits' => 'Competitive salary, health insurance, design tools budget, flexible schedule, creative environment.',
                'department_id' => $departments->where('code', 'DESIGN')->first()->id,
                'employment_type' => 'full-time',
                'experience_level' => 'mid',
                'location' => 'Portland, OR',
                'remote_allowed' => true,
                'salary_range' => '$75,000 - $100,000',
                'application_deadline' => now()->addDays(50),
                'max_applications' => 25,
                'application_instructions' => 'Submit your portfolio showcasing your best UI/UX work.',
                'status' => 'published',
                'featured' => true,
                'priority' => 7,
                'meta_title' => 'UI/UX Designer - User Experience Design',
                'meta_description' => 'UI/UX Designer position focusing on user-centered design.',
                'meta_keywords' => 'ui design, ux design, figma, user experience, interface design',
                'created_by' => $users->first()->id,
                'published_at' => now(),
            ],

            // Internship
            [
                'title' => 'Software Engineering Intern',
                'description' => 'Gain hands-on experience in software development. Work on real projects with our engineering team and learn industry best practices.',
                'requirements' => 'Currently enrolled in Computer Science or related program. Basic programming knowledge. Eagerness to learn and grow.',
                'responsibilities' => 'Assist with software development projects, participate in code reviews, learn development tools and processes, collaborate with team members.',
                'benefits' => 'Stipend, mentorship program, flexible schedule, potential full-time offer, networking opportunities.',
                'department_id' => $departments->where('code', 'ENG')->first()->id,
                'employment_type' => 'internship',
                'experience_level' => 'entry',
                'location' => 'Boston, MA',
                'remote_allowed' => true,
                'salary_range' => '$20 - $25/hour',
                'application_deadline' => now()->addDays(15),
                'max_applications' => 10,
                'application_instructions' => 'Include your academic projects and any coding experience.',
                'status' => 'published',
                'featured' => false,
                'priority' => 2,
                'meta_title' => 'Software Engineering Intern - Summer Internship',
                'meta_description' => 'Summer internship opportunity for software engineering students.',
                'meta_keywords' => 'internship, software engineering, student, summer, programming',
                'created_by' => $users->first()->id,
                'published_at' => now(),
            ],

            // Draft Job (not published)
            [
                'title' => 'Senior Product Manager',
                'description' => 'Lead product strategy and roadmap for our core products. You will work with cross-functional teams to deliver exceptional user experiences.',
                'requirements' => '5+ years of product management experience. Strong analytical skills. Experience with agile development processes.',
                'responsibilities' => 'Define product strategy, create roadmaps, work with engineering teams, analyze user feedback, coordinate with stakeholders.',
                'benefits' => 'Competitive salary, equity, health insurance, flexible schedule, leadership opportunities.',
                'department_id' => $departments->where('code', 'PM')->first()->id,
                'employment_type' => 'full-time',
                'experience_level' => 'senior',
                'location' => 'San Diego, CA',
                'remote_allowed' => true,
                'salary_range' => '$130,000 - $170,000',
                'application_deadline' => null,
                'max_applications' => null,
                'application_instructions' => 'Include examples of products you\'ve managed and their impact.',
                'status' => 'draft',
                'featured' => false,
                'priority' => 0,
                'meta_title' => 'Senior Product Manager - Product Strategy',
                'meta_description' => 'Senior Product Manager position leading product strategy.',
                'meta_keywords' => 'product manager, product strategy, roadmap, agile, leadership',
                'created_by' => $users->first()->id,
                'published_at' => null,
            ],
        ];

        foreach ($jobs as $job) {
            CareerJob::firstOrCreate(
                ['title' => $job['title'], 'department_id' => $job['department_id']],
                $job
            );
        }

        $this->command->info('Created ' . count($jobs) . ' career jobs.');
    }
}
