<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Academic Life',
                'slug' => 'academic-life',
                'description' => 'Stories about academic achievements, study tips, and campus learning experiences',
                'color' => '#3B82F6'
            ],
            [
                'name' => 'Student Stories',
                'slug' => 'student-stories',
                'description' => 'Personal experiences and journeys of our students',
                'color' => '#10B981'
            ],
            [
                'name' => 'Campus Events',
                'slug' => 'campus-events',
                'description' => 'Coverage of university events, ceremonies, and activities',
                'color' => '#F59E0B'
            ],
            [
                'name' => 'Technology',
                'slug' => 'technology',
                'description' => 'Latest tech trends, coding tips, and digital innovation',
                'color' => '#8B5CF6'
            ],
            [
                'name' => 'Career Advice',
                'slug' => 'career-advice',
                'description' => 'Job preparation, interview tips, and career guidance',
                'color' => '#EF4444'
            ],
            [
                'name' => 'Alumni Success',
                'slug' => 'alumni-success',
                'description' => 'Stories of successful graduates and their achievements',
                'color' => '#06B6D4'
            ]
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}
