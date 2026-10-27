<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ArticleRating;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ArticleRatingController extends Controller
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
     * Submit a rating for an article
     */
    public function rate(Request $request, $articleId): JsonResponse
    {
        try {
            $validated = $request->validate([
                'rating' => 'required|integer|min:1|max:5'
            ]);

            $article = Article::findOrFail($articleId);
            $sessionId = $this->getSessionId($request);
            
            $success = ArticleRating::submitRating(
                $articleId, 
                $sessionId, 
                $validated['rating']
            );

            if ($success) {
                $stats = ArticleRating::getArticleRatingStats($articleId);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Rating submitted successfully!',
                    'stats' => $stats
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to submit rating'
                ], 400);
            }

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid rating value',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while submitting rating'
            ], 500);
        }
    }

    /**
     * Get rating statistics for an article
     */
    public function stats($articleId): JsonResponse
    {
        $article = Article::findOrFail($articleId);
        $stats = ArticleRating::getArticleRatingStats($articleId);
        
        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }

    /**
     * Get user's rating for an article
     */
    public function userRating(Request $request, $articleId): JsonResponse
    {
        $sessionId = $this->getSessionId($request);
        $rating = ArticleRating::getUserRating($articleId, $sessionId);
        
        return response()->json([
            'rating' => $rating
        ]);
    }
}