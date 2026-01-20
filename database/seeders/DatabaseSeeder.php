<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Seed users
        $this->call(UserSeeder::class);

        // Seed departments
        $this->call(DepartmentSeeder::class);
        
        // Seed vacancies
        $this->call(VacancySeeder::class);
        
        // Seed career applications
        $this->call(CareerApplicationSeeder::class);
        
        // Seed publications
        $this->call(PublicationSeeder::class);
    }
}
