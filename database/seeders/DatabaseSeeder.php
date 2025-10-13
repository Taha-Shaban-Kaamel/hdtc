<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\Admin;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['name' => 'super admin']);
        Role::create(['name' => 'instructor']);
        Role::create(['name' => 'student']);
        Role::create(['name' => 'admin']);

        $superAdmin = User::create([
            'email' => 'taha.shaban@zydx.com',
            'first_name' => 'taha',
            'second_name' => 'shaban',
            'password' => bcrypt('12345678'),
            'phone' => '123456789',
            'email_verified_at' => now(),
        ]);


        $adminUser = User::create([
            'email' => 'admin@zydx.com',
            'first_name' => 'admin',
            'second_name' => 'admin',
            'password' => bcrypt('12345678'),
            'phone' => '123456789',
            'email_verified_at' => now(),
        ]);
        
        $admin= Admin::create([
            'user_id' => $adminUser->id,
        ]);

        $adminUser->assignRole('admin');
        $superAdmin->assignRole('super admin');

        $this->call([
            CourseCategorieSeeder::class,
        ]);

        $this->call([
            InstructorSeeder::class,
        ]);

        $this->call([
            CourseSeeder::class,
        ]);

        $this->call([
            PermissionTableSeeder::class,
        ]);
    }
}
