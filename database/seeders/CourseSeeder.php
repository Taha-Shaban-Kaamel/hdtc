<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseCategorie;
use App\Models\Instructor;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run()
    {
        $instructors = Instructor::all();
        $categories = CourseCategorie::all();

        $courses = [
            [
                'title' => [
                    'en' => 'Complete Web Development Bootcamp',
                    'ar' => 'دورة تطوير الويب الكاملة'
                ],
                'name' => [
                    'en' => 'web-development-bootcamp',
                    'ar' => 'دورة-تطوير-الويب-الكاملة'
                ],
                'description' => [
                    'en' => 'Learn web development from scratch with this comprehensive course',
                    'ar' => 'تعلم تطوير الويب من الصفر مع هذه الدورة الشاملة'
                ],
                'objectives' => [
                    'en' => ['HTML & CSS', 'JavaScript', 'React', 'Node.js', 'MongoDB'],
                    'ar' => ['HTML و CSS', 'جافاسكريبت', 'رياكت', 'نود جي إس', 'مونغو دي بي']
                ],
                'price' => 99.99,
                'duration' => 40, // in hours
                'difficulty_degree' => [
                    'en' => 'Beginner',
                    'ar' => 'مبتدئ'
                ],
                'thumbnail' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80',
                'cover' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80',
                'video' => 'https://www.youtube.com/embed/sample-video',
                'status' => 'active',
            ],
            [
                'title' => [
                    'en' => 'Mobile App Development with Flutter',
                    'ar' => 'تطوير تطبيقات الموبايل باستخدام فلاتر'
                ],
                'name' => [
                    'en' => 'flutter-mobile-development',
                    'ar' => 'تطوير-تطبيقات-الموبايل-باستخدام-فلاتر'
                ],
                'description' => [
                    'en' => 'Build beautiful native apps with Flutter',
                    'ar' => 'قم ببناء تطبيقات جميلة باستخدام فلاتر'
                ],
                'objectives' => [
                    'en' => ['Dart Programming', 'Flutter Basics', 'State Management', 'API Integration'],
                    'ar' => ['برمجة دارت', 'أساسيات فلاتر', 'إدارة الحالة', 'دمج واجهة برمجة التطبيقات']
                ],
                'price' => 79.99,
                'duration' => 30,
                'difficulty_degree' => [
                    'en' => 'Intermediate',
                    'ar' => 'متوسط'
                ],
                'thumbnail' => 'https://images.unsplash.com/photo-1551650975-87deedd944c3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80',
                'cover' => 'https://images.unsplash.com/photo-1551650975-87deedd944c3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80',
                'video' => 'https://www.youtube.com/embed/flutter-video',
                'status' => 'active',
            ],
        ];

        foreach ($courses as $courseData) {
            $course = Course::create([
                'title' => $courseData['title'],
                'name' => $courseData['name'],
                'description' => $courseData['description'],
                'objectives' => $courseData['objectives'],
                'price' => $courseData['price'],
                'duration' => $courseData['duration'],
                'difficulty_degree' => $courseData['difficulty_degree'],
                'thumbnail' => $courseData['thumbnail'],
                'cover' => $courseData['cover'],
                'video' => $courseData['video'],
                'status' => $courseData['status'],
            ]);

            $course->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );

            $course->instructors()->attach(
                $instructors->random()->id
            );
        }
    }
}
