<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BookmarkController extends Controller
{
    /**
     * Get a stable session/client identifier for API requests.
     */
    protected function getSessionId(Request $request): string
    {
        if ($request->hasSession() && $request->session()->isStarted()) {
            return $request->session()->getId();
        }

        if ($request->header('X-Session-ID')) {
            return (string) $request->header('X-Session-ID');
        }

        return hash('sha256', ($request->ip() ?? '127.0.0.1') . ($request->userAgent() ?? 'guest'));
    }

    /**
     * Toggle bookmark for an article
     */
    public function toggle(Request $request, $articleId): JsonResponse
    {
        $sessionId = $this->getSessionId($request);
        $article = Article::findOrFail($articleId);
        
        $isBookmarked = Bookmark::toggleBookmark($sessionId, $articleId);

        return response()->json([
            'success' => true,
            'bookmarked' => $isBookmarked,
            'message' => $isBookmarked ? 'Article bookmarked!' : 'Bookmark removed!'
        ]);
    }

    /**
     * Get user's bookmarks
     */
    public function index(Request $request): JsonResponse
    {
        $sessionId = $this->getSessionId($request);
        
        $bookmarks = Bookmark::where('session_id', $sessionId)
            ->with(['article' => function ($query) {
                $query->select('id', 'title', 'slug', 'excerpt', 'featured_image', 'created_at')
                      ->with(['category:id,name', 'author:id,name']);
            }])
            ->latest()
            ->paginate($request->get('per_page', 10));

        return response()->json($bookmarks);
    }

    /**
     * Check if article is bookmarked
     */
    public function status(Request $request, $articleId): JsonResponse
    {
        $sessionId = $this->getSessionId($request);
        
        $isBookmarked = Bookmark::isBookmarked($sessionId, $articleId);

        return response()->json([
            'bookmarked' => $isBookmarked
        ]);
    }

    /**
     * Remove specific bookmark
     */
    public function destroy(Request $request, $bookmarkId): JsonResponse
    {
        $sessionId = $this->getSessionId($request);
        
        $bookmark = Bookmark::where('id', $bookmarkId)
            ->where('session_id', $sessionId)
            ->firstOrFail();
            
        $bookmark->delete();

        return response()->json([
            'success' => true,
            'message' => 'Bookmark removed successfully!'
        ]);
    }
}