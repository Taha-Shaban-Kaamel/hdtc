<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure student role exists
        $studentRole = Role::firstOrCreate(
            ['name' => 'student'],
            ['guard_name' => 'web']
        );

        // Create sample students
        $students = [
            [
                'first_name' => ['ar' => 'أحمد', 'en' => 'Ahmed'],
                'second_name' => ['ar' => 'محمد', 'en' => 'Mohammed'],
                'email' => 'ahmed.mohammed@example.com',
                'phone' => '1234567890',
                'gender' => 'male',
                'birth_date' => '2000-01-15',
            ],
            [
                'first_name' => ['ar' => 'فاطمة', 'en' => 'Fatima'],
                'second_name' => ['ar' => 'علي', 'en' => 'Ali'],
                'email' => 'fatima.ali@example.com',
                'phone' => '1234567891',
                'gender' => 'female',
                'birth_date' => '1999-05-20',
            ],
            [
                'first_name' => ['ar' => 'محمود', 'en' => 'Mahmoud'],
                'second_name' => ['ar' => 'حسن', 'en' => 'Hassan'],
                'email' => 'mahmoud.hassan@example.com',
                'phone' => '1234567892',
                'gender' => 'male',
                'birth_date' => '2001-03-10',
            ],
            [
                'first_name' => ['ar' => 'سارة', 'en' => 'Sara'],
                'second_name' => ['ar' => 'أحمد', 'en' => 'Ahmed'],
                'email' => 'sara.ahmed@example.com',
                'phone' => '1234567893',
                'gender' => 'female',
                'birth_date' => '2000-08-25',
            ],
            [
                'first_name' => ['ar' => 'عمر', 'en' => 'Omar'],
                'second_name' => ['ar' => 'خالد', 'en' => 'Khaled'],
                'email' => 'omar.khaled@example.com',
                'phone' => '1234567894',
                'gender' => 'male',
                'birth_date' => '1998-12-05',
            ],
            [
                'first_name' => ['ar' => 'مريم', 'en' => 'Mariam'],
                'second_name' => ['ar' => 'يوسف', 'en' => 'Youssef'],
                'email' => 'mariam.youssef@example.com',
                'phone' => '1234567895',
                'gender' => 'female',
                'birth_date' => '2002-06-18',
            ],
            [
                'first_name' => ['ar' => 'يوسف', 'en' => 'Youssef'],
                'second_name' => ['ar' => 'عبدالله', 'en' => 'Abdullah'],
                'email' => 'youssef.abdullah@example.com',
                'phone' => '1234567896',
                'gender' => 'male',
                'birth_date' => '1999-11-22',
            ],
            [
                'first_name' => ['ar' => 'نور', 'en' => 'Nour'],
                'second_name' => ['ar' => 'محمود', 'en' => 'Mahmoud'],
                'email' => 'nour.mahmoud@example.com',
                'phone' => '1234567897',
                'gender' => 'female',
                'birth_date' => '2001-04-30',
            ],
            [
                'first_name' => ['ar' => 'كريم', 'en' => 'Karim'],
                'second_name' => ['ar' => 'سعيد', 'en' => 'Said'],
                'email' => 'karim.said@example.com',
                'phone' => '1234567898',
                'gender' => 'male',
                'birth_date' => '2000-09-14',
            ],
            [
                'first_name' => ['ar' => 'ليلى', 'en' => 'Layla'],
                'second_name' => ['ar' => 'حسين', 'en' => 'Hussein'],
                'email' => 'layla.hussein@example.com',
                'phone' => '1234567899',
                'gender' => 'female',
                'birth_date' => '1998-07-08',
            ],
        ];

        foreach ($students as $studentData) {
            $user = User::create([
                'first_name' => $studentData['first_name'],
                'second_name' => $studentData['second_name'],
                'email' => $studentData['email'],
                'phone' => $studentData['phone'],
                'password' => Hash::make('password123'),
                'gender' => $studentData['gender'],
                'birth_date' => $studentData['birth_date'],
                'status' => 'active',
                'email_verified_at' => now(),
            ]);

            // Assign student role
            $user->assignRole($studentRole);
        }

        $this->command->info('Created ' . count($students) . ' students successfully!');
    }
}
