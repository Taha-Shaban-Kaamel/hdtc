<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create(['name' => 'super admin']);
        Role::create(['name' => 'instructor']);
        Role::create(['name' => 'student']);

        $superAdmin = User::create([
            'email' => 'taha.shaban@zydx.com',
            'first_name' => 'taha',
            'second_name' => 'shaban',
            'password' => bcrypt('12345678'),
            'phone' => '123456789',
            'email_verified_at' => now(),
        ]);
        
        $superAdmin->assignRole('super admin');

        // Seed categories first
        $this->call([
            CourseCategorieSeeder::class,
        ]);

        // Then seed instructors (which create users with instructor role)
        $this->call([
            InstructorSeeder::class,
        ]);

        // Finally seed courses (which depend on categories and instructors)
        $this->call([
            CourseSeeder::class,
        ]);
    }
}
