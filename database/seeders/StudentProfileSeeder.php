<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profiles = [
            [
                'name' => 'Sarah Martinez',
                'student_id' => 'GC2024001',
                'email' => 'sarah.martinez@gcuni.edu',
                'avatar' => '/images/avatars/sarah-martinez.jpg',
                'bio' => 'Passionate software developer with a focus on machine learning and artificial intelligence. Currently working on my thesis about neural networks in educational technology. I believe technology can transform how we learn and teach.',
                'major' => 'Computer Science',
                'graduation_year' => '2024',
                'gpa' => '3.9',
                'motto' => 'Innovation distinguishes leaders from followers',
                'achievements' => ['Dean\'s List (2022-2024)', 'Outstanding Student Award', 'Google Summer of Code Participant', 'Research Publication in AI Conference', 'Hackathon Winner - EduTech Challenge'],
                'interests' => ['Machine Learning', 'Web Development', 'Photography', 'Rock Climbing', 'Open Source Contributing'],
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/sarahmartinez',
                    'github' => 'https://github.com/sarahmartinez',
                    'twitter' => 'https://twitter.com/sarahmartinez'
                ],
                'is_featured' => true
            ],
            [
                'name' => 'Marcus Johnson',
                'student_id' => 'GC2025002',
                'email' => 'marcus.johnson@gcuni.edu',
                'avatar' => '/images/avatars/marcus-johnson.jpg',
                'bio' => 'Entrepreneurship enthusiast and business strategy student. Founded two successful student organizations and currently developing a startup focused on sustainable campus solutions. Passionate about creating positive environmental impact.',
                'major' => 'Business Administration',
                'graduation_year' => '2025',
                'gpa' => '3.7',
                'motto' => 'Be the change you wish to see in the world',
                'achievements' => ['Student Government President', 'Entrepreneurship Competition Winner', 'Leadership Excellence Award', 'Sustainability Initiative Founder', 'Business Plan Competition Finalist'],
                'interests' => ['Entrepreneurship', 'Sustainability', 'Public Speaking', 'Basketball', 'Environmental Policy'],
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/marcusjohnson',
                    'twitter' => 'https://twitter.com/marcusjohnson'
                ],
                'is_featured' => true
            ],
            [
                'name' => 'Aisha Patel',
                'student_id' => 'GC2024003',
                'email' => 'aisha.patel@gcuni.edu',
                'avatar' => '/images/avatars/aisha-patel.jpg',
                'bio' => 'Biomedical engineering student with research experience in medical device development. Passionate about creating technology that improves healthcare outcomes and making medical solutions more accessible globally.',
                'major' => 'Engineering',
                'graduation_year' => '2024',
                'gpa' => '3.8',
                'motto' => 'Excellence is not a skill, it\'s an attitude',
                'achievements' => ['Research Excellence Award', 'IEEE Student Member', 'Patent Application - Medical Device', 'Biomedical Engineering Society President', 'National Conference Presenter'],
                'interests' => ['Biomedical Engineering', 'Healthcare Innovation', 'Yoga', 'Cooking', 'Medical Research'],
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/aishapatel',
                    'github' => 'https://github.com/aishapatel'
                ],
                'is_featured' => false
            ],
            [
                'name' => 'David Chen',
                'student_id' => 'GC2026004',
                'email' => 'david.chen@gcuni.edu',
                'avatar' => '/images/avatars/david-chen.jpg',
                'bio' => 'Psychology major interested in cognitive behavioral therapy and mental health advocacy. Active volunteer at the campus counseling center and passionate about reducing mental health stigma among students.',
                'major' => 'Psychology',
                'graduation_year' => '2026',
                'gpa' => '3.6',
                'motto' => 'Your potential is endless',
                'achievements' => ['Mental Health Advocate of the Year', 'Volunteer of the Year', 'Psychology Research Grant Recipient', 'Peer Counseling Certification'],
                'interests' => ['Mental Health', 'Counseling', 'Music Therapy', 'Hiking', 'Community Service'],
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/davidchen'
                ],
                'is_featured' => false
            ],
            [
                'name' => 'Emily Rodriguez',
                'student_id' => 'GC2025005',
                'email' => 'emily.rodriguez@gcuni.edu',
                'avatar' => '/images/avatars/emily-rodriguez.jpg',
                'bio' => 'Biology student conducting research on environmental conservation and climate change impacts. Active member of the university\'s sustainability committee and environmental club president.',
                'major' => 'Biology',
                'graduation_year' => '2025',
                'gpa' => '3.85',
                'motto' => 'The future belongs to those who believe in their dreams',
                'achievements' => ['Environmental Research Grant', 'Sustainability Leadership Award', 'Honor Society Member', 'National Parks Service Intern', 'Climate Action Conference Speaker'],
                'interests' => ['Environmental Science', 'Conservation Biology', 'Gardening', 'Travel', 'Wildlife Photography'],
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/emilyrodriguez',
                    'twitter' => 'https://twitter.com/emilyrodriguez'
                ],
                'is_featured' => false
            ],
            [
                'name' => 'Alex Thompson',
                'student_id' => 'GC2027006',
                'email' => 'alex.thompson@gcuni.edu',
                'avatar' => '/images/avatars/alex-thompson.jpg',
                'bio' => 'Art & Design student specializing in digital media and graphic design. Creator of the university\'s visual identity for multiple campaigns and passionate about using design for social impact.',
                'major' => 'Art & Design',
                'graduation_year' => '2027',
                'gpa' => '3.5',
                'motto' => 'Be fearless in the pursuit of what sets your soul on fire',
                'achievements' => ['Design Competition Winner', 'Student Exhibition Featured Artist', 'University Branding Project Lead', 'Adobe Creative Scholarship Recipient'],
                'interests' => ['Graphic Design', 'Digital Art', 'Photography', 'Skateboarding', 'Social Impact Design'],
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/alexthompson',
                    'github' => 'https://github.com/alexthompson',
                    'twitter' => 'https://twitter.com/alexthompson'
                ],
                'is_featured' => false
            ],
            [
                'name' => 'Priya Sharma',
                'student_id' => 'GC2024007',
                'email' => 'priya.sharma@gcuni.edu',
                'avatar' => '/images/avatars/priya-sharma.jpg',
                'bio' => 'Computer Science student with expertise in cybersecurity and blockchain technology. Leading the university\'s cybersecurity club and interning at a fintech startup focused on secure payment solutions.',
                'major' => 'Computer Science',
                'graduation_year' => '2024',
                'gpa' => '3.75',
                'motto' => 'Knowledge is power, wisdom is knowing how to use it',
                'achievements' => ['Cybersecurity Club President', 'Ethical Hacking Certification', 'Blockchain Innovation Award', 'Women in Tech Scholarship'],
                'interests' => ['Cybersecurity', 'Blockchain', 'Chess', 'Martial Arts', 'Tech Ethics'],
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/priyasharma',
                    'github' => 'https://github.com/priyasharma'
                ],
                'is_featured' => true
            ],
            [
                'name' => 'Jordan Williams',
                'student_id' => 'GC2025008',
                'email' => 'jordan.williams@gcuni.edu',
                'avatar' => '/images/avatars/jordan-williams.jpg',
                'bio' => 'Psychology major with a focus on sports psychology and performance enhancement. Captain of the university soccer team and working on research about motivation in competitive athletics.',
                'major' => 'Psychology',
                'graduation_year' => '2025',
                'gpa' => '3.4',
                'motto' => 'Hard work beats talent when talent doesn\'t work hard',
                'achievements' => ['Soccer Team Captain', 'Student-Athlete Leadership Award', 'Sports Psychology Research Assistant', 'All-Conference Team Selection'],
                'interests' => ['Sports Psychology', 'Soccer', 'Fitness Training', 'Team Leadership', 'Performance Coaching'],
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/jordanwilliams'
                ],
                'is_featured' => false
            ]
        ];

        foreach ($profiles as $profile) {
            \App\Models\StudentProfile::create($profile);
        }
    }
}
