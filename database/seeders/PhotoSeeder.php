<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $photos = [
            [
                'title' => 'Campus Library Study Session',
                'description' => 'Students collaborating in the main library during finals week.',
                'image_path' => '/images/gallery/library-study.jpg',
                'alt_text' => 'Students studying in library',
                'category' => 'campus',
                'order' => 1,
                'is_featured' => true,
                'taken_at' => '2024-03-15'
            ],
            [
                'title' => 'Graduation Ceremony 2024',
                'description' => 'Proud graduates celebrating their achievements at the annual commencement ceremony.',
                'image_path' => '/images/gallery/graduation.jpg',
                'alt_text' => 'Graduation ceremony with students in caps and gowns',
                'category' => 'graduation',
                'order' => 2,
                'is_featured' => true,
                'taken_at' => '2024-05-20'
            ],
            [
                'title' => 'Science Lab Innovation',
                'description' => 'Students conducting cutting-edge experiments in the new chemistry research laboratory.',
                'image_path' => '/images/gallery/science-lab.jpg',
                'alt_text' => 'Students working in science laboratory',
                'category' => 'facilities',
                'order' => 3,
                'is_featured' => true,
                'taken_at' => '2024-02-10'
            ],
            [
                'title' => 'Student Activity Fair',
                'description' => 'Annual fair showcasing various student clubs, organizations, and volunteer opportunities.',
                'image_path' => '/images/gallery/activity-fair.jpg',
                'alt_text' => 'Student activity fair with booths and displays',
                'category' => 'events',
                'order' => 4,
                'is_featured' => false,
                'taken_at' => '2024-01-25'
            ],
            [
                'title' => 'Campus Green Spaces',
                'description' => 'Beautiful landscaping and outdoor study areas perfect for relaxation and learning.',
                'image_path' => '/images/gallery/campus-green.jpg',
                'alt_text' => 'Campus green spaces with trees and benches',
                'category' => 'campus',
                'order' => 5,
                'is_featured' => true,
                'taken_at' => '2024-03-01'
            ],
            [
                'title' => 'Basketball Championship Victory',
                'description' => 'University team celebrating their regional championship win in an intense final game.',
                'image_path' => '/images/gallery/basketball.jpg',
                'alt_text' => 'Basketball team celebrating championship victory',
                'category' => 'events',
                'order' => 6,
                'is_featured' => false,
                'taken_at' => '2024-02-28'
            ],
            [
                'title' => 'Student Art Gallery Opening',
                'description' => 'Opening night of the annual student artwork exhibition in the campus art center.',
                'image_path' => '/images/gallery/art-gallery.jpg',
                'alt_text' => 'Art gallery with student artwork on display',
                'category' => 'events',
                'order' => 7,
                'is_featured' => false,
                'taken_at' => '2024-03-05'
            ],
            [
                'title' => 'Modern Dormitory Common Area',
                'description' => 'Newly renovated student housing with modern collaborative spaces and study areas.',
                'image_path' => '/images/gallery/dorm-common.jpg',
                'alt_text' => 'Modern dormitory common room with students',
                'category' => 'student life',
                'order' => 8,
                'is_featured' => false,
                'taken_at' => '2024-01-15'
            ],
            [
                'title' => 'Computer Lab Coding Session',
                'description' => 'Students working on programming projects in the state-of-the-art computer science lab.',
                'image_path' => '/images/gallery/computer-lab.jpg',
                'alt_text' => 'Students coding in computer lab',
                'category' => 'facilities',
                'order' => 9,
                'is_featured' => true,
                'taken_at' => '2024-02-20'
            ],
            [
                'title' => 'Campus Food Festival',
                'description' => 'Annual international food festival celebrating the diverse cultures of our student body.',
                'image_path' => '/images/gallery/food-festival.jpg',
                'alt_text' => 'Students at campus food festival',
                'category' => 'events',
                'order' => 10,
                'is_featured' => false,
                'taken_at' => '2024-04-12'
            ]
        ];

        foreach ($photos as $photo) {
            \App\Models\Photo::create($photo);
        }
    }
}
