<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArticleRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'session_id',
        'rating'
    ];

    protected $casts = [
        'rating' => 'integer'
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public static function submitRating(int $articleId, string $sessionId, int $rating): bool
    {
        if ($rating < 1 || $rating > 5) {
            return false;
        }

        return static::updateOrCreate(
            [
                'article_id' => $articleId,
                'session_id' => $sessionId
            ],
            [
                'rating' => $rating
            ]
        ) !== null;
    }

    public static function getArticleRatingStats(int $articleId): array
    {
        $ratings = static::where('article_id', $articleId)->get();
        
        if ($ratings->isEmpty()) {
            return [
                'average' => 0,
                'count' => 0,
                'distribution' => [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0]
            ];
        }

        $count = $ratings->count();
        $sum = $ratings->sum('rating');
        $average = round($sum / $count, 1);
        
        $distribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $distribution[$i] = $ratings->where('rating', $i)->count();
        }

        return [
            'average' => $average,
            'count' => $count,
            'distribution' => $distribution
        ];
    }

    public static function getUserRating(int $articleId, string $sessionId): ?int
    {
        $rating = static::where('article_id', $articleId)
            ->where('session_id', $sessionId)
            ->first();
            
        return $rating?->rating;
    }
}