<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Photo;
use App\Models\PhotoComment;

class EnhancedPhotoSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing photos
        Photo::truncate();
        PhotoComment::truncate();

        $graduationPhotos = [
            [
                'title' => 'Computer Science Graduation 2024',
                'description' => 'Celebrating our graduating class of Computer Science students who have mastered the art of programming and innovation.',
                'image_path' => 'gallery/2024/01/graduation_cs_2024.jpg',
                'alt_text' => 'Computer Science graduates throwing caps in the air',
                'category' => 'graduation',
                'photo_type' => 'graduation',
                'graduation_year' => 2024,
                'motto' => 'Code the Future, Debug the World',
                'student_name' => 'CS Class of 2024',
                'department' => 'Computer Science & IT',
                'degree_program' => 'BSc Computer Science',
                'photographer' => 'University Photography Team',
                'tags' => ['graduation', 'computer science', '2024', 'ceremony'],
                'is_featured' => true,
                'is_public' => true,
                'allow_comments' => true,
                'likes' => 156,
                'dislikes' => 3,
                'order' => 1,
                'taken_at' => now()->subDays(30),
                'approved_at' => now(),
                'approved_by' => 1
            ],
            [
                'title' => 'Engineering Excellence Awards',
                'description' => 'Our engineering students receiving awards for outstanding projects and academic excellence.',
                'image_path' => 'gallery/2024/01/engineering_awards_2024.jpg',
                'alt_text' => 'Engineering students receiving excellence awards',
                'category' => 'academic',
                'photo_type' => 'academic',
                'graduation_year' => 2024,
                'motto' => 'Building Tomorrow Today',
                'student_name' => 'Engineering Award Recipients',
                'department' => 'Engineering',
                'degree_program' => 'BSc Engineering',
                'photographer' => 'Dr. Michael Brown',
                'tags' => ['awards', 'engineering', 'excellence', 'academic'],
                'is_featured' => true,
                'is_public' => true,
                'allow_comments' => true,
                'likes' => 98,
                'dislikes' => 2,
                'order' => 2,
                'taken_at' => now()->subDays(25),
                'approved_at' => now(),
                'approved_by' => 1
            ],
            [
                'title' => 'Medical School White Coat Ceremony',
                'description' => 'New medical students receiving their white coats in a traditional ceremony marking their entry into the medical profession.',
                'image_path' => 'gallery/2024/02/medical_white_coat.jpg',
                'alt_text' => 'Medical students in white coat ceremony',
                'category' => 'ceremony',
                'photo_type' => 'event',
                'graduation_year' => 2024,
                'motto' => 'Healing Hands, Caring Hearts',
                'student_name' => 'Medical Class of 2024',
                'department' => 'Medicine & Health Sciences',
                'degree_program' => 'Doctor of Medicine',
                'photographer' => 'Healthcare Photography',
                'tags' => ['medicine', 'white coat', 'ceremony', 'healthcare'],
                'is_featured' => true,
                'is_public' => true,
                'allow_comments' => true,
                'likes' => 234,
                'dislikes' => 1,
                'order' => 3,
                'taken_at' => now()->subDays(20),
                'approved_at' => now(),
                'approved_by' => 1
            ],
            [
                'title' => 'Business School Case Competition Winners',
                'description' => 'MBA students celebrating their victory in the international business case competition.',
                'image_path' => 'gallery/2024/02/business_competition.jpg',
                'alt_text' => 'Business students with trophy from case competition',
                'category' => 'competition',
                'photo_type' => 'academic',
                'graduation_year' => 2024,
                'motto' => 'Leading with Innovation',
                'student_name' => 'MBA Team Alpha',
                'department' => 'Business & Management',
                'degree_program' => 'MBA',
                'photographer' => 'Business School Media',
                'tags' => ['MBA', 'competition', 'business', 'winners'],
                'is_featured' => false,
                'is_public' => true,
                'allow_comments' => true,
                'likes' => 67,
                'dislikes' => 0,
                'order' => 4,
                'taken_at' => now()->subDays(15),
                'approved_at' => now(),
                'approved_by' => 1
            ],
            [
                'title' => 'Chemistry Lab Research Breakthrough',
                'description' => 'Chemistry students celebrating a breakthrough in their research project on sustainable materials.',
                'image_path' => 'gallery/2024/03/chemistry_research.jpg',
                'alt_text' => 'Chemistry students in lab with research equipment',
                'category' => 'research',
                'photo_type' => 'academic',
                'graduation_year' => 2023,
                'motto' => 'Discovering the Elements of Tomorrow',
                'student_name' => 'Chemistry Research Team',
                'department' => 'Natural Sciences',
                'degree_program' => 'BSc Chemistry',
                'photographer' => 'Science Department',
                'tags' => ['chemistry', 'research', 'lab', 'breakthrough'],
                'is_featured' => false,
                'is_public' => true,
                'allow_comments' => true,
                'likes' => 89,
                'dislikes' => 4,
                'order' => 5,
                'taken_at' => now()->subDays(10),
                'approved_at' => now(),
                'approved_by' => 1
            ],
            [
                'title' => 'Psychology Students Community Outreach',
                'description' => 'Psychology students conducting mental health awareness workshops in the local community.',
                'image_path' => 'gallery/2024/03/psychology_outreach.jpg',
                'alt_text' => 'Psychology students conducting community workshop',
                'category' => 'community',
                'photo_type' => 'student_life',
                'graduation_year' => 2023,
                'motto' => 'Understanding Minds, Healing Hearts',
                'student_name' => 'Psychology Outreach Team',
                'department' => 'Social Sciences',
                'degree_program' => 'BSc Psychology',
                'photographer' => 'Community Relations',
                'tags' => ['psychology', 'community', 'outreach', 'mental health'],
                'is_featured' => false,
                'is_public' => true,
                'allow_comments' => true,
                'likes' => 123,
                'dislikes' => 2,
                'order' => 6,
                'taken_at' => now()->subDays(8),
                'approved_at' => now(),
                'approved_by' => 1
            ],
            [
                'title' => 'Campus Sports Day 2024',
                'description' => 'Annual sports day bringing together students from all departments for friendly competition and team spirit.',
                'image_path' => 'gallery/2024/04/sports_day.jpg',
                'alt_text' => 'Students participating in campus sports day activities',
                'category' => 'sports',
                'photo_type' => 'sports',
                'graduation_year' => null,
                'motto' => 'Stronger Together',
                'student_name' => 'GC University Athletes',
                'department' => 'All Departments',
                'degree_program' => 'Various',
                'photographer' => 'Sports Department',
                'tags' => ['sports', 'competition', 'teamwork', 'campus life'],
                'is_featured' => true,
                'is_public' => true,
                'allow_comments' => true,
                'likes' => 187,
                'dislikes' => 5,
                'order' => 7,
                'taken_at' => now()->subDays(5),
                'approved_at' => now(),
                'approved_by' => 1
            ],
            [
                'title' => 'International Student Welcome',
                'description' => 'Welcoming ceremony for international students joining our diverse academic community.',
                'image_path' => 'gallery/2024/04/international_welcome.jpg',
                'alt_text' => 'International students at welcome ceremony',
                'category' => 'event',
                'photo_type' => 'event',
                'graduation_year' => null,
                'motto' => 'Unity in Diversity',
                'student_name' => 'International Student Community',
                'department' => 'International Affairs',
                'degree_program' => 'Various Exchange Programs',
                'photographer' => 'International Office',
                'tags' => ['international', 'welcome', 'diversity', 'exchange'],
                'is_featured' => false,
                'is_public' => true,
                'allow_comments' => true,
                'likes' => 145,
                'dislikes' => 1,
                'order' => 8,
                'taken_at' => now()->subDays(3),
                'approved_at' => now(),
                'approved_by' => 1
            ],
            [
                'title' => 'Library Study Groups',
                'description' => 'Students collaborating in study groups at our state-of-the-art library facilities.',
                'image_path' => 'gallery/2024/05/library_study.jpg',
                'alt_text' => 'Students studying together in modern library',
                'category' => 'campus',
                'photo_type' => 'student_life',
                'graduation_year' => null,
                'motto' => 'Knowledge is Power',
                'student_name' => 'Study Group Participants',
                'department' => 'Library Services',
                'degree_program' => 'Cross-Departmental',
                'photographer' => 'Library Staff',
                'tags' => ['library', 'study', 'collaboration', 'academic'],
                'is_featured' => false,
                'is_public' => true,
                'allow_comments' => true,
                'likes' => 76,
                'dislikes' => 0,
                'order' => 9,
                'taken_at' => now()->subDays(2),
                'approved_at' => now(),
                'approved_by' => 1
            ],
            [
                'title' => 'Alumni Success Stories',
                'description' => 'Celebrating our successful alumni who have made significant contributions in their respective fields.',
                'image_path' => 'gallery/2024/05/alumni_success.jpg',
                'alt_text' => 'Alumni sharing their success stories with current students',
                'category' => 'alumni',
                'photo_type' => 'event',
                'graduation_year' => 2020,
                'motto' => 'Yesterday\'s Students, Tomorrow\'s Leaders',
                'student_name' => 'Distinguished Alumni',
                'department' => 'Alumni Relations',
                'degree_program' => 'Various',
                'photographer' => 'Alumni Office',
                'tags' => ['alumni', 'success', 'inspiration', 'achievement'],
                'is_featured' => true,
                'is_public' => true,
                'allow_comments' => true,
                'likes' => 298,
                'dislikes' => 2,
                'order' => 10,
                'taken_at' => now()->subDays(1),
                'approved_at' => now(),
                'approved_by' => 1
            ]
        ];

        foreach ($graduationPhotos as $photoData) {
            $photo = Photo::create($photoData);
            
            // Add some sample comments for popular photos
            if ($photo->likes > 100) {
                $this->addSampleComments($photo);
            }
        }
    }

    private function addSampleComments($photo)
    {
        $sampleComments = [
            [
                'commenter_name' => 'Sarah Johnson',
                'commenter_email' => 'sarah.j@example.com',
                'comment' => 'What an amazing moment! So proud of all the graduates. The future is bright! 🎓',
                'is_approved' => true,
                'likes' => rand(5, 25),
                'dislikes' => rand(0, 3),
                'created_at' => now()->subDays(rand(1, 5))
            ],
            [
                'commenter_name' => 'Michael Chen',
                'commenter_email' => 'michael.c@example.com',
                'comment' => 'This brings back so many memories of my own graduation. Congratulations to everyone!',
                'is_approved' => true,
                'likes' => rand(3, 15),
                'dislikes' => rand(0, 2),
                'created_at' => now()->subDays(rand(1, 4))
            ],
            [
                'commenter_name' => 'Emma Williams',
                'commenter_email' => 'emma.w@example.com',
                'comment' => 'Beautiful ceremony! The university always puts on such wonderful events for students.',
                'is_approved' => true,
                'likes' => rand(2, 12),
                'dislikes' => rand(0, 1),
                'created_at' => now()->subDays(rand(1, 3))
            ],
            [
                'commenter_name' => 'David Brown',
                'commenter_email' => 'david.b@example.com',
                'comment' => 'Inspiring to see the next generation of leaders ready to make their mark on the world!',
                'is_approved' => true,
                'likes' => rand(4, 18),
                'dislikes' => rand(0, 2),
                'created_at' => now()->subDays(rand(1, 2))
            ]
        ];

        foreach ($sampleComments as $commentData) {
            PhotoComment::create(array_merge($commentData, [
                'photo_id' => $photo->id,
                'approved_at' => now(),
                'approved_by' => 1
            ]));
        }
    }
}