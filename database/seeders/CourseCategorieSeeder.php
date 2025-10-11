<?php

namespace Database\Seeders;

use App\Models\CourseCategorie;
use Illuminate\Database\Seeder;

class CourseCategorieSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => ['en' => 'Web Development', 'ar' => 'تطوير الويب'],
                'description' => ['en' => 'Learn web development from scratch', 'ar' => 'تعلم تطوير الويب من الصفر'],
                'image' => 'https://images.unsplash.com/photo-1547658719-da2b51169166?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
            ],
            [
                'name' => ['en' => 'Mobile Development', 'ar' => 'تطوير التطبيقات'],
                'description' => ['en' => 'Build mobile applications', 'ar' => 'بناء تطبيقات الموبايل'],
                'image' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                'parent_id' => 1,
            ],
            [
                'name' => ['en' => 'Data Science', 'ar' => 'علم البيانات'],
                'description' => ['en' => 'Master data science and analytics', 'ar' => 'إتقان علم البيانات والتحليلات'],
                'image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
            ],
            [
                'name' => ['en' => 'Business', 'ar' => 'أعمال'],
                'description' => ['en' => 'Business and management courses', 'ar' => 'دورات الأعمال والإدارة'],
                'image' => 'https://images.unsplash.com/photo-1554224155-3a58922a22c3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
            ],
            [
                'name' => ['en' => 'Design', 'ar' => 'تصميم'],
                'description' => ['en' => 'Learn design principles and tools', 'ar' => 'تعلم مبادئ وأدوات التصميم'],
                'image' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
            ],
        ];

        foreach ($categories as $category) {
            CourseCategorie::create($category);
        }
    }
}
