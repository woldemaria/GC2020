<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run all our custom seeders in the correct order
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            AuthorSeeder::class,
            ArticleSeeder::class,
            PhotoSeeder::class,
            StudentProfileSeeder::class,
            NewsletterSeeder::class,
            CertificateSeeder::class,
            EventSeeder::class,
        ]);
    }
}
