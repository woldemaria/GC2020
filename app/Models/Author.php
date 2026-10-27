<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    protected $fillable = [
        'name',
        'email',
        'avatar',
        'bio',
        'position',
        'department',
        'graduation_year',
        'social_links'
    ];

    protected $casts = [
        'social_links' => 'array'
    ];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function publishedArticles(): HasMany
    {
        return $this->hasMany(Article::class)->where('is_published', true);
    }
}
