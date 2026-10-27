<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ArticleController extends Controller
{
    /**
     * Display a listing of articles.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Article::with(['category', 'author'])
            ->where('is_published', true)
            ->orderBy('published_at', 'desc');

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by featured
        if ($request->has('featured') && $request->featured === 'true') {
            $query->where('is_featured', true);
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Pagination
        $perPage = $request->get('per_page', 12);
        $articles = $query->paginate($perPage);

        // Add read time to each article
        $articles->getCollection()->transform(function ($article) {
            $article->read_time = $this->calculateReadTime($article->content);
            return $article;
        });

        return response()->json($articles);
    }

    /**
     * Display the specified article by slug.
     */
    public function show(Request $request, string $slug): JsonResponse
    {
        $article = Article::with(['category', 'author'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Increment view count
        $article->increment('views');
        $article->incrementViewCount();
        $article->refresh();

        // Add read time
        $article->read_time = $this->calculateReadTime($article->content);
        
        // Add comment count
        $article->comment_count = $article->approvedComments()->count();
        
        // Check if bookmarked
        $sessionId = ($request->hasSession() && $request->session()->isStarted())
            ? $request->session()->getId()
            : ($request->header('X-Session-ID') ?: hash('sha256', ($request->ip() ?? '127.0.0.1') . ($request->userAgent() ?? 'guest')));
        $article->is_bookmarked = \App\Models\Bookmark::isBookmarked($sessionId, $article->id);

        return response()->json($article);
    }

    /**
     * Get featured articles for homepage.
     */
    public function featured(): JsonResponse
    {
        $articles = Article::with(['category', 'author'])
            ->where('is_published', true)
            ->where('is_featured', true)
            ->orderBy('published_at', 'desc')
            ->limit(6)
            ->get();

        // Add read time to each article
        $articles->transform(function ($article) {
            $article->read_time = $this->calculateReadTime($article->content);
            return $article;
        });

        return response()->json($articles);
    }

    /**
     * Get related articles based on category.
     */
    public function related(string $slug): JsonResponse
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        
        $relatedArticles = Article::with(['category', 'author'])
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        // Add read time to each article
        $relatedArticles->transform(function ($article) {
            $article->read_time = $this->calculateReadTime($article->content);
            return $article;
        });

        return response()->json($relatedArticles);
    }

    /**
     * Calculate estimated read time in minutes.
     */
    private function calculateReadTime(string $content): int
    {
        $wordCount = str_word_count(strip_tags($content));
        return max(1, ceil($wordCount / 200)); // 200 words per minute average
    }
}
