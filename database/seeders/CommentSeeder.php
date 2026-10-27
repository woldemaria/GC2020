<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Article;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = Article::all();

        $comments = [
            [
                'author_name' => 'Alice Thompson',
                'author_email' => 'alice.thompson@example.com',
                'content' => 'Great article! This really helped me prepare for my job interviews. The tips on networking are especially valuable.',
                'is_approved' => true,
                'created_at' => now()->subDays(5)
            ],
            [
                'author_name' => 'David Chen',
                'author_email' => 'david.chen@example.com',
                'content' => 'Thank you for sharing this. As a recent graduate, I found the resume building section particularly helpful.',
                'is_approved' => true,
                'created_at' => now()->subDays(3)
            ],
            [
                'author_name' => 'Maria Rodriguez',
                'author_email' => 'maria.rodriguez@example.com',
                'content' => 'Excellent insights! I wish I had read this before starting my job search. Will definitely bookmark for future reference.',
                'is_approved' => true,
                'created_at' => now()->subDays(2)
            ],
            [
                'author_name' => 'James Wilson',
                'author_email' => 'james.wilson@example.com',
                'content' => 'Very comprehensive guide. The interview preparation tips worked well for me. Just got my first job offer!',
                'is_approved' => true,
                'created_at' => now()->subDays(1)
            ],
            [
                'author_name' => 'Spam User',
                'author_email' => 'spam@example.com',
                'content' => 'Check out this amazing opportunity! Click here for instant success!',
                'is_approved' => false,
                'created_at' => now()->subHours(6)
            ]
        ];

        foreach ($articles->take(3) as $article) {
            foreach ($comments as $commentData) {
                $comment = $commentData;
                $comment['article_id'] = $article->id;
                Comment::create($comment);
            }
        }

        // Add some additional random comments
        $randomComments = [
            'This is exactly what I needed to read today. Thanks for the motivation!',
            'Great perspective on this topic. Looking forward to more articles like this.',
            'Very well written and informative. Keep up the excellent work!',
            'This article changed my approach completely. Thank you for the insights.',
            'Bookmarking this for future reference. Excellent resource!',
            'Clear and concise explanation. Easy to follow and implement.',
            'Love the practical examples provided. Makes it much easier to understand.'
        ];

        $names = ['Emily Davis', 'Robert Brown', 'Lisa Wang', 'Carlos Martinez', 'Anna Johnson', 'Tom Anderson', 'Sophie Miller'];
        
        foreach ($articles as $article) {
            $numComments = rand(1, 4);
            for ($i = 0; $i < $numComments; $i++) {
                Comment::create([
                    'article_id' => $article->id,
                    'author_name' => $names[array_rand($names)],
                    'author_email' => strtolower(str_replace(' ', '.', $names[array_rand($names)])) . '@example.com',
                    'content' => $randomComments[array_rand($randomComments)],
                    'is_approved' => rand(0, 10) > 1, // 90% approval rate
                    'created_at' => now()->subDays(rand(1, 30))->subHours(rand(1, 23))
                ]);
            }
        }
    }
}