<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Instructor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InstructorSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'first_name' =>['en' => 'Taha', 'ar' => 'طه'],
            'second_name' =>['en' => 'Shaban', 'ar' => 'شعبان'],
            'email' => 'taha@zydx.com',
            'password' => Hash::make('password'),
            'phone' => '123456789',
            'email_verified_at' => now(),
        ]);

        $user->assignRole('instructor');
        
        Instructor::create([
            'user_id' => $user->id,
            'specialization' => ['en' => 'Web Development', 'ar' => 'تطوير الويب'],
            'experience' => 5,
            'education' => [
                'en' => 'MSc in Computer Science',
                'ar' => 'ماجستير في علوم الحاسوب'
            ],
            'bio' => [
                'en' => 'Experienced web developer with 5+ years of experience',
                'ar' => 'مطور ويب محترف مع خبرة تزيد عن 5 سنوات'
            ],
            'company' => 'Tech Solutions Inc.',
            'rating' => 4.8,
            'twitter_url' => 'https://twitter.com/johndoe',
            'linkedin_url' => 'https://linkedin.com/in/johndoe',
            'facebook_url' => 'https://facebook.com/johndoe',
            'youtube_url' => 'https://youtube.com/johndoe',
            'is_active' => true,
        ]);

        for ($i = 1; $i <= 4; $i++) {
            $user = User::create([
                'first_name' =>['en' => 'Instructor' . $i, 'ar' => 'مدرس' . $i],
                'second_name' =>['en' => 'User', 'ar' => 'مستخدم'],
                'email' => 'instructor' . $i . '@example.com',
                'password' => Hash::make('password'),
                'phone' => '123456789' . $i,
                'email_verified_at' => now(),
            ]);

            Instructor::create([
                'user_id' => $user->id,
                'specialization' => ['en' => 'Specialization ' . $i, 'ar' => 'تخصص ' . $i],
                'experience' => rand(2, 10),
                'education' => [
                    'en' => 'Education ' . $i,
                    'ar' => 'تعليم ' . $i
                ],
                'bio' => [
                    'en' => 'Bio for instructor ' . $i,
                    'ar' => 'نبذة عن المدرب ' . $i
                ],
                'company' => 'Company ' . $i,
                'rating' => rand(30, 50) / 10,
                'is_active' => true,
            ]);
        }
    }
}
