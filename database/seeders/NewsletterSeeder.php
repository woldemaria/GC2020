<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Newsletter;

class NewsletterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subscribers = [
            [
                'email' => 'sarah.martinez@example.com',
                'name' => 'Sarah Martinez',
                'is_active' => true,
                'subscribed_at' => now()->subDays(30)
            ],
            [
                'email' => 'john.doe@example.com',
                'name' => 'John Doe',
                'is_active' => true,
                'subscribed_at' => now()->subDays(15)
            ],
            [
                'email' => 'jane.smith@example.com',
                'name' => 'Jane Smith',
                'is_active' => true,
                'subscribed_at' => now()->subDays(7)
            ],
            [
                'email' => 'mike.johnson@example.com',
                'name' => 'Mike Johnson',
                'is_active' => false,
                'subscribed_at' => now()->subDays(60),
                'unsubscribed_at' => now()->subDays(10)
            ]
        ];

        foreach ($subscribers as $subscriber) {
            Newsletter::create($subscriber);
        }
    }
}