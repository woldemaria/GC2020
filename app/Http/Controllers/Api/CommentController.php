<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class CommentController extends Controller
{
    /**
     * Get comments for an article
     */
    public function index(Request $request, $articleId): JsonResponse
    {
        $article = Article::findOrFail($articleId);
        
        $comments = $article->approvedComments()
            ->latest()
            ->paginate($request->get('per_page', 10));

        return response()->json($comments);
    }

    /**
     * Store a new comment
     */
    public function store(Request $request, $articleId): JsonResponse
    {
        try {
            $article = Article::findOrFail($articleId);

            $validated = $request->validate([
                'author_name' => 'required|string|max:255',
                'author_email' => 'required|email|max:255',
                'content' => 'required|string|max:1000'
            ]);

            $comment = $article->comments()->create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Comment submitted successfully and is awaiting approval.',
                'data' => $comment
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit comment. Please try again.'
            ], 500);
        }
    }

    /**
     * Get comment count for an article
     */
    public function count($articleId): JsonResponse
    {
        $article = Article::findOrFail($articleId);
        
        return response()->json([
            'count' => $article->approvedComments()->count()
        ]);
    }
}