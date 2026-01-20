<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'name' => 'Engineering',
                'code' => 'ENG',
                'description' => 'Software development, technical architecture, and engineering solutions',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Marketing',
                'code' => 'MKT',
                'description' => 'Digital marketing, brand management, and customer acquisition',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Sales',
                'code' => 'SALES',
                'description' => 'Business development, client relations, and revenue generation',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Human Resources',
                'code' => 'HR',
                'description' => 'Talent acquisition, employee relations, and organizational development',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Finance',
                'code' => 'FIN',
                'description' => 'Financial planning, accounting, and business analytics',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Operations',
                'code' => 'OPS',
                'description' => 'Business operations, process optimization, and project management',
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Customer Support',
                'code' => 'SUPPORT',
                'description' => 'Customer service, technical support, and client success',
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'Product Management',
                'code' => 'PM',
                'description' => 'Product strategy, roadmap planning, and feature development',
                'is_active' => true,
                'sort_order' => 8,
            ],
            [
                'name' => 'Design',
                'code' => 'DESIGN',
                'description' => 'UI/UX design, graphic design, and user experience',
                'is_active' => true,
                'sort_order' => 9,
            ],
            [
                'name' => 'Data & Analytics',
                'code' => 'DATA',
                'description' => 'Data science, business intelligence, and analytics',
                'is_active' => true,
                'sort_order' => 10,
            ],
        ];

        foreach ($departments as $department) {
            Department::firstOrCreate(
                ['code' => $department['code']],
                $department
            );
        }
    }
}
