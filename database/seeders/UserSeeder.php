<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'superadmin@hligreenpower.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('Hlipassword123'),
                'phone' => '087889919396',
                'position' => 'Super Admin',
                'bio' => 'Super Admin',
                'email_verified_at' => now(),
            ]
        );
    }
}
