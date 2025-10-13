<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'admins' => [
                'view-admins',
                'create-admins',
                'edit-admins',
                'delete-admins'
            ],
            'roles' => [
                'view-roles',
                'create-roles',
                'edit-roles',
                'delete-roles'
            ],
            'courses' => [
                'view-courses',
                'create-courses',
                'edit-courses',
                'delete-courses'
            ],

            'notifications' => [
                'view-notifications',
                'create-notifications',
                'edit-notifications',
                'delete-notifications'
            ],

            'plans' => [
                'view-plans',
                'create-plans',
                'edit-plans',
                'delete-plans'
            ],

            'instructors' => [
                'view-instructors',
                'create-instructors',
                'edit-instructors',
                'delete-instructors'
            ],
        ];

        foreach ($permissions as $section => $permissionList) {
            foreach ($permissionList as $permission) {
                Permission::firstOrCreate([
                    'name' => $permission,
                    'guard_name' => 'web'
                ]);
            }
        }
    }
}