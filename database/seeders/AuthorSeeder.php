<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = [
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@gcuni.edu',
                'avatar' => '/images/avatars/sarah.jpg',
                'bio' => 'Computer Science major with a passion for web development and artificial intelligence. Currently working on my thesis about machine learning applications in education.',
                'position' => 'Student',
                'department' => 'Computer Science',
                'graduation_year' => '2024',
                'social_links' => [
                    'twitter' => 'https://twitter.com/sarahjohnson',
                    'linkedin' => 'https://linkedin.com/in/sarahjohnson',
                    'github' => 'https://github.com/sarahjohnson'
                ]
            ],
            [
                'name' => 'Michael Chen',
                'email' => 'michael.chen@gcuni.edu',
                'avatar' => '/images/avatars/michael.jpg',
                'bio' => 'Business Administration student and editor-in-chief of GC Magazine. Passionate about entrepreneurship and digital marketing.',
                'position' => 'Student',
                'department' => 'Business Administration',
                'graduation_year' => '2025',
                'social_links' => [
                    'twitter' => 'https://twitter.com/michaelchen',
                    'linkedin' => 'https://linkedin.com/in/michaelchen'
                ]
            ],
            [
                'name' => 'Dr. Emily Rodriguez',
                'email' => 'emily.rodriguez@gcuni.edu',
                'avatar' => '/images/avatars/emily.jpg',
                'bio' => 'Professor of Digital Media and Communications. Research interests include social media impact on education and digital storytelling.',
                'position' => 'Faculty',
                'department' => 'Communications',
                'graduation_year' => null,
                'social_links' => [
                    'twitter' => 'https://twitter.com/dremilyrodriguez',
                    'linkedin' => 'https://linkedin.com/in/emilyrodriguez'
                ]
            ],
            [
                'name' => 'Alex Thompson',
                'email' => 'alex.thompson@alumni.gcuni.edu',
                'avatar' => '/images/avatars/alex.jpg',
                'bio' => 'Software Engineer at Google and proud GC alumnus. Graduated with a degree in Computer Engineering and now mentors current students.',
                'position' => 'Alumni',
                'department' => 'Computer Engineering',
                'graduation_year' => '2020',
                'social_links' => [
                    'twitter' => 'https://twitter.com/alexthompson',
                    'linkedin' => 'https://linkedin.com/in/alexthompson'
                ]
            ]
        ];

        foreach ($authors as $author) {
            \App\Models\Author::create($author);
        }
    }
}
