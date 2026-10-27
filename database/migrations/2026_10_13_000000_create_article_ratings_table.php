<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('article_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->string('session_id'); // For anonymous users
            $table->tinyInteger('rating')->unsigned(); // 1-5 stars
            $table->timestamps();
            
            $table->unique(['session_id', 'article_id']);
            $table->index(['article_id', 'rating']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_ratings');
    }
};