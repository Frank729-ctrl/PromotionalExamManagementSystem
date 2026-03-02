<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Student;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['student', 'instructor', 'examboard', 'director'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        $users = [
            ['name' => 'Student One', 'email' => 'student@example.com', 'role' => 'student'],
            ['name' => 'Instructor', 'email' => 'instructor@example.com', 'role' => 'instructor'],
            ['name' => 'Chief Examiner', 'email' => 'examboard@example.com', 'role' => 'examboard'],
            ['name' => 'Director General', 'email' => 'director@example.com', 'role' => 'director'],
        ];

        foreach ($users as $u) {
            $user = User::firstOrCreate(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    'password' => bcrypt('password'),
                ]
            );

            if (!$user->hasRole($u['role'])) {
                $user->assignRole($u['role']);
            }

            // Only create student record for student role
            if ($u['role'] === 'student' && !$user->student) {
                Student::create([
                    'user_id'      => $user->id,
                    'level'        => 'A',
                    'category'     => 'A',
                    'group'        => 'A',
                    'index_number' => 'STU-' . str_pad($user->id, 3, '0', STR_PAD_LEFT),
                    'attempts_left'=> 3,
                ]);
            }
        }
    }
}
