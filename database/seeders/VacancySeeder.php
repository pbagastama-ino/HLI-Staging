<?php

namespace Database\Seeders;

use App\Models\Vacancy;
use App\Models\User;
use Illuminate\Database\Seeder;

class VacancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users for foreign keys
        $users = User::all();
        
        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please create users first.');
            return;
        }

        $vacancies = [
            [
                'title' => 'Battery Manufacturing Engineer',
                'requirements' => 'Bachelor\'s or Master\'s degree in Chemical Engineering, Mechanical Engineering, or related field. Minimum 3+ years of experience in battery manufacturing or lithium-ion battery production. Strong knowledge of electrode manufacturing, cell assembly processes, and battery testing methodologies. Experience with quality control systems and process optimization in manufacturing environments.',
                'description' => 'We are seeking an experienced Battery Manufacturing Engineer to lead our production processes for EV battery cells. You will be responsible for optimizing manufacturing operations, ensuring quality standards are met, and implementing process improvements. This role involves overseeing electrode coating and calendering processes, managing cell assembly line operations, analyzing production data to identify improvements, coordinating with quality control teams, and troubleshooting manufacturing issues to minimize downtime.',
                'department_name' => 'Production',
                'created_by' => $users->first()->id,
                'updated_by' => $users->first()->id,
            ],
            [
                'title' => 'Quality Control Specialist',
                'requirements' => 'Bachelor\'s degree in Chemistry, Materials Science, or related field. 2+ years of experience in battery quality control or testing. Knowledge of lithium-ion battery testing protocols and failure analysis. Familiarity with quality control standards (ISO 9001, IATF 16949). Strong attention to detail and analytical skills.',
                'description' => 'Join our quality assurance team to ensure our EV batteries meet the highest standards of performance and safety. You will conduct comprehensive testing and analysis of battery cells and modules throughout the production process. This role involves performing electrical testing on battery cells (capacity, impedance, cycling), conducting visual inspections and dimensional measurements, documenting test results and maintaining quality records, identifying and reporting defects or anomalies, and collaborating with production teams to resolve quality issues.',
                'department_name' => 'Quality Assurance',
                'created_by' => $users->first()->id,
                'updated_by' => $users->first()->id,
            ],
            [
                'title' => 'Production Line Supervisor',
                'requirements' => 'Bachelor\'s degree in Engineering or related field. 5+ years of experience in manufacturing operations, preferably in battery or automotive industry. Strong leadership and team management skills. Knowledge of lean manufacturing principles and safety protocols. Experience with production planning and scheduling.',
                'description' => 'Lead our production team to ensure efficient and safe manufacturing operations for our EV battery facility. You will supervise daily production activities, manage team performance, and ensure targets are met while maintaining the highest safety and quality standards. This role involves supervising production line operations and monitoring key performance indicators, managing and training production staff, ensuring compliance with safety protocols and regulations, coordinating with other departments (maintenance, quality, logistics), optimizing production schedules to meet delivery targets, and implementing continuous improvement initiatives.',
                'department_name' => 'Production',
                'created_by' => $users->first()->id,
                'updated_by' => $users->first()->id,
            ],
        ];

        foreach ($vacancies as $vacancy) {
            Vacancy::firstOrCreate(
                ['title' => $vacancy['title'], 'department_name' => $vacancy['department_name']],
                $vacancy
            );
        }

        $this->command->info('Created ' . count($vacancies) . ' vacancies.');
    }
}
