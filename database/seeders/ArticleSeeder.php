<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [
            [
                'title' => 'How to Prepare for Your First Job After Graduation',
                'slug' => 'how-to-prepare-first-job-graduation',
                'excerpt' => 'Graduating from university is a huge milestone, but it also means it\'s time to face the real world. Here are essential tips to prepare for your career journey.',
                'content' => '<p>Graduating from university is an exciting milestone, but it can also feel overwhelming as you prepare to enter the professional world. Here\'s a comprehensive guide to help you navigate this transition successfully.</p><h2>1. Build a Strong Resume</h2><p>Your resume is your first impression with potential employers. Make sure it highlights your education, internships, projects, and any relevant experience. Focus on achievements rather than just job duties.</p><h2>2. Develop Your Professional Network</h2><p>Networking is crucial in today\'s job market. Attend career fairs, join professional associations, and connect with alumni from your university.</p><h2>3. Practice Your Interview Skills</h2><p>Prepare for common interview questions and practice your responses. Research the companies you\'re interested in and be ready to explain why you want to work there specifically.</p><p>Remember, your first job doesn\'t have to be perfect. It\'s a stepping stone to building your career and gaining valuable experience.</p>',
                'featured_image' => '/images/articles/job-preparation.jpg',
                'category_id' => 5, // Career Advice
                'author_id' => 1, // Sarah Johnson
                'is_featured' => true,
                'is_published' => true,
                'published_at' => '2024-03-15',
                'views' => 1250
            ],
            [
                'title' => 'The Future of Open Source Education',
                'slug' => 'future-open-source-education',
                'excerpt' => 'Exploring how open source technologies are revolutionizing the way we learn and teach in universities worldwide.',
                'content' => '<p>Open source software and educational resources are transforming higher education, making quality learning materials accessible to students and educators globally.</p><h2>Open Source Learning Platforms</h2><p>Universities are increasingly adopting open source learning management systems and collaboration tools that provide flexibility and customization options.</p><h2>Benefits for Students</h2><p>Students gain access to industry-standard tools and can contribute to real-world projects, building practical skills alongside academic knowledge.</p><h2>The Future Landscape</h2><p>As open source continues to evolve, we can expect more innovative educational technologies that democratize access to quality education.</p>',
                'featured_image' => '/images/articles/open-source.jpg',
                'category_id' => 4, // Technology
                'author_id' => 2, // Michael Chen
                'is_featured' => true,
                'is_published' => true,
                'published_at' => '2024-03-12',
                'views' => 890
            ],
            [
                'title' => 'Class of 2024: Dreams and Achievements',
                'slug' => 'class-2024-dreams-achievements',
                'excerpt' => 'Meet the outstanding graduates of 2024 and discover their inspiring stories of academic success and future aspirations.',
                'content' => '<p>The Class of 2024 represents a remarkable group of students who have overcome challenges and achieved extraordinary success during their academic journey.</p><h2>Academic Excellence</h2><p>This year\'s graduates have maintained exceptional academic standards while contributing to research, community service, and campus life.</p><h2>Future Aspirations</h2><p>From pursuing advanced degrees to launching startups, our graduates are ready to make their mark on the world.</p><h2>Words of Wisdom</h2><p>Current graduates share their advice for incoming students and reflect on their transformative university experience.</p>',
                'featured_image' => '/images/articles/graduation-2024.jpg',
                'category_id' => 2, // Student Stories
                'author_id' => 3, // Dr. Emily Rodriguez
                'is_featured' => true,
                'is_published' => true,
                'published_at' => '2024-03-10',
                'views' => 2100
            ],
            [
                'title' => 'Building a Strong Portfolio: A Student\'s Guide',
                'slug' => 'building-strong-portfolio-guide',
                'excerpt' => 'Learn how to create an impressive portfolio that showcases your skills and stands out to potential employers.',
                'content' => '<p>A well-crafted portfolio is essential for showcasing your skills, projects, and achievements to potential employers or graduate school admissions committees.</p><h2>What to Include</h2><p>Your portfolio should demonstrate your best work, including academic projects, internship experiences, and personal initiatives that highlight your capabilities.</p><h2>Digital vs. Physical Portfolios</h2><p>Consider the advantages of digital portfolios for easy sharing and updating, while understanding when physical portfolios might be more appropriate.</p><h2>Presentation Matters</h2><p>Learn how to organize and present your work in a professional, engaging manner that tells your story effectively.</p>',
                'featured_image' => '/images/articles/portfolio-guide.jpg',
                'category_id' => 5, // Career Advice
                'author_id' => 4, // Alex Thompson
                'is_featured' => false,
                'is_published' => true,
                'published_at' => '2024-03-08',
                'views' => 1580
            ],
            [
                'title' => 'Campus Innovation Week 2024 Highlights',
                'slug' => 'campus-innovation-week-2024',
                'excerpt' => 'Recap of the most exciting moments and groundbreaking projects from this year\'s Campus Innovation Week.',
                'content' => '<p>Campus Innovation Week 2024 brought together students, faculty, and industry professionals for a week of creativity, collaboration, and cutting-edge presentations.</p><h2>Student Competitions</h2><p>This year featured record-breaking participation in hackathons, pitch competitions, and research showcases across all academic disciplines.</p><h2>Industry Partnerships</h2><p>Leading companies sponsored challenges and provided mentorship opportunities, creating valuable connections between students and potential employers.</p><h2>Looking Ahead</h2><p>The success of Innovation Week 2024 sets the stage for even more ambitious programming in the coming year.</p>',
                'featured_image' => '/images/articles/innovation-week.jpg',
                'category_id' => 3, // Campus Events
                'author_id' => 1, // Sarah Johnson
                'is_featured' => false,
                'is_published' => true,
                'published_at' => '2024-03-05',
                'views' => 750
            ],
            [
                'title' => 'Study Tips: Mastering Time Management',
                'slug' => 'study-tips-time-management',
                'excerpt' => 'Effective strategies for managing your time as a student and balancing academic work with personal life.',
                'content' => '<p>Time management is one of the most crucial skills for academic success. Here are proven strategies to help you make the most of your study time.</p><h2>The Pomodoro Technique</h2><p>Break your study sessions into focused 25-minute intervals with short breaks. This technique helps maintain concentration and prevents burnout.</p><h2>Priority Matrix</h2><p>Learn to categorize tasks by urgency and importance, focusing on high-impact activities that align with your academic goals.</p><h2>Digital Tools</h2><p>Explore apps and platforms that can help you track assignments, set reminders, and maintain a structured approach to your coursework.</p>',
                'featured_image' => '/images/articles/time-management.jpg',
                'category_id' => 1, // Academic Life
                'author_id' => 3, // Dr. Emily Rodriguez
                'is_featured' => false,
                'is_published' => true,
                'published_at' => '2024-03-02',
                'views' => 1920
            ]
        ];

        foreach ($articles as $article) {
            \App\Models\Article::create($article);
        }
    }
}
