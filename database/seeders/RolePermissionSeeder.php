<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Clear cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User permissions
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',

            // Project permissions
            'view-projects',
            'create-projects',
            'edit-projects',
            'delete-projects',

            // Task permissions
            'view-tasks',
            'create-tasks',
            'edit-tasks',
            'delete-tasks',

            // Role & Permission permissions
            'view-roles',
            'create-roles',
            'edit-roles',
            'delete-roles',
            'view-permissions',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $managerRole = Role::firstOrCreate(['name' => 'manager']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Assign all permissions to admin
        $adminRole->givePermissionTo(Permission::all());

        // Assign permissions to manager
        $managerPermissions = [
            'view-users',
            'view-projects',
            'create-projects',
            'edit-projects',
            'delete-projects',
            'view-tasks',
            'create-tasks',
            'edit-tasks',
            'delete-tasks',
        ];
        $managerRole->givePermissionTo($managerPermissions);

        // Assign permissions to user
        $userPermissions = [
            'view-projects',
            'view-tasks',
            'create-tasks',
            'edit-tasks',
        ];
        $userRole->givePermissionTo($userPermissions);

        // Create users only if they don't exist
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ],
            [
                'name' => 'Project Manager',
                'email' => 'manager@example.com',
                'password' => Hash::make('password123'),
                'role' => 'manager',
            ],
            [
                'name' => 'Regular User',
                'email' => 'user@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => $userData['password'],
                    'email_verified_at' => now(),
                ]
            );

            // Assign role
            $user->assignRole($userData['role']);
        }

        $this->command->info('Roles, permissions, and users created successfully!');
        $this->command->info('Admin: admin@example.com / password123');
        $this->command->info('Manager: manager@example.com / password123');
        $this->command->info('User: user@example.com / password123');
    }
}
