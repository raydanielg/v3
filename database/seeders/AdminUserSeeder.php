<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::firstOrCreate(
            ['email' => 'airezra2@gmail.com'],
            [
            'name' => 'Admin User',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
            'phone' => '+255 123 456 789',
            'date_of_birth' => '1990-01-15',
            'address' => 'Dar es Salaam, Tanzania',
            'school_name' => 'Emas School',
            'school_id' => 'SCH-2024-001',
            'role' => 'admin',
            'avatar_url' => null,
            'last_login_at' => now(),
            ]
        );

        // Create Sample Regular Users
        User::firstOrCreate(
            ['email' => 'john@example.com'],
            [
            'name' => 'John Teacher',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'phone' => '+255 700 111 222',
            'date_of_birth' => '1985-05-20',
            'address' => 'Dar es Salaam, Tanzania',
            'school_name' => 'Emas School',
            'school_id' => 'SCH-2024-001',
            'role' => 'teacher',
            'avatar_url' => null,
            'last_login_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'jane@example.com'],
            [
            'name' => 'Jane Student',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'phone' => '+255 700 222 333',
            'date_of_birth' => '2005-08-10',
            'address' => 'Dar es Salaam, Tanzania',
            'school_name' => 'Emas School',
            'school_id' => 'SCH-2024-001',
            'role' => 'student',
            'avatar_url' => null,
            'last_login_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'mike@example.com'],
            [
            'name' => 'Mike School Manager',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'phone' => '+255 700 333 444',
            'date_of_birth' => '1980-03-15',
            'address' => 'Dar es Salaam, Tanzania',
            'school_name' => 'Emas School',
            'school_id' => 'SCH-2024-001',
            'role' => 'school_manager',
            'avatar_url' => null,
            'last_login_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'david@example.com'],
            [
            'name' => 'David District Manager',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'phone' => '+255 700 444 555',
            'date_of_birth' => '1978-07-22',
            'address' => 'Dar es Salaam, Tanzania',
            'school_name' => 'District Office',
            'school_id' => 'DIST-2024-001',
            'role' => 'district_manager',
            'avatar_url' => null,
            'last_login_at' => now(),
            ]
        );
    }
}
