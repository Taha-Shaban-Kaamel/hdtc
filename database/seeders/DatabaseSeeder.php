<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UsersType;
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
     
        UsersType::create([
            'name' => ['ar' => 'طالب', 'en' => 'student'],
        ]);
        // Create a default user type
        $userType = UsersType::create([
            'name' => ['ar' => 'مدير', 'en' => 'manager'],
        ]);
        
        // Create a super admin user
        $superAdmin = User::factory()->create([
            'email' => 'taha.shaban@zydx.com',
            'first_name' => ['ar' => 'طه', 'en' => 'taha'],
            'second_name' => ['ar' => 'شعبان', 'en' => 'shaban'],
            'user_type_id' => $userType->id,
            'password' => bcrypt('12345678'),
            'phone' => '123456789',
        ]);
        
        // Assign super admin role to the user
        $superAdmin->assignRole('super admin');
    }
}
