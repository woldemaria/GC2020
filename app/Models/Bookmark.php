<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bookmark extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'article_id'
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public static function toggleBookmark(string $sessionId, int $articleId): bool
    {
        $bookmark = static::where('session_id', $sessionId)
            ->where('article_id', $articleId)
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            return false; // Removed bookmark
        } else {
            static::create([
                'session_id' => $sessionId,
                'article_id' => $articleId
            ]);
            return true; // Added bookmark
        }
    }

    public static function isBookmarked(string $sessionId, int $articleId): bool
    {
        return static::where('session_id', $sessionId)
            ->where('article_id', $articleId)
            ->exists();
    }
}