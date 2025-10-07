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

        
        // Create a super admin user
        $superAdmin = User::factory()->create([
            'email' => 'taha.shaban@zydx.com',
            'first_name' => ['ar' => 'طه', 'en' => 'taha'],
            'second_name' => ['ar' => 'شعبان', 'en' => 'shaban'],
            'password' => bcrypt('12345678'),
            'phone' => '123456789',
        ]);
        
        $superAdmin->assignRole('super admin');
    }
}
