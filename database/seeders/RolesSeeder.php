<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Roles to create
        $roles = ['student', 'instructor', 'examboard', 'director'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        // Sample users for each role
        $users = [
            ['name' => 'Student', 'email' => 'student@example.com', 'role' => 'student'],
            ['name' => 'Instructor', 'email' => 'instructor@example.com', 'role' => 'instructor'],
            ['name' => 'Chief Examiner', 'email' => 'examboard@example.com', 'role' => 'examboard'],
            ['name' => 'Director General', 'email' => 'director@example.com', 'role' => 'director'],
        ];

        foreach ($users as $u) {
            $user = User::firstOrCreate(
                ['email' => $u['email']], // check if user exists
                [
                    'name' => $u['name'],
                    'password' => bcrypt('password'), // default password
                ]
            );

            // Assign role safely
            if (!$user->hasRole($u['role'])) {
                $user->assignRole($u['role']);
            }
        }
    }
}
