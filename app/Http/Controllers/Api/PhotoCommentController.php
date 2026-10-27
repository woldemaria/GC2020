<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\PhotoComment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class PhotoCommentController extends Controller
{
    /**
     * Get comments for a specific photo
     */
    public function index($photoId): JsonResponse
    {
        $photo = Photo::find($photoId);
        if (!$photo) {
            return response()->json([
                'success' => false,
                'message' => 'Photo not found'
            ], 404);
        }

        $comments = PhotoComment::where('photo_id', $photoId)
            ->where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->get();

        $formattedComments = $comments->map(function($comment) {
            return [
                'id' => $comment->id,
                'author_name' => $comment->commenter_name,
                'content' => $comment->comment,
                'created_at' => $comment->created_at->toISOString(),
                'likes' => $comment->likes ?? 0,
                'dislikes' => $comment->dislikes ?? 0
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $formattedComments
        ]);
    }

    /**
     * Store a new comment for a photo
     */
    public function store(Request $request, $photoId): JsonResponse
    {
        $photo = Photo::find($photoId);
        if (!$photo) {
            return response()->json([
                'success' => false,
                'message' => 'Photo not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'author_name' => 'required|string|max:100|min:2',
            'content' => 'required|string|max:1000|min:5'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $comment = PhotoComment::create([
                'photo_id' => $photoId,
                'commenter_name' => $request->author_name,
                'comment' => $request->content,
                'is_approved' => true, // Auto-approve for demo
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Comment added successfully',
                'comment' => [
                    'id' => $comment->id,
                    'author_name' => $comment->commenter_name,
                    'content' => $comment->comment,
                    'created_at' => $comment->created_at->toISOString()
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit comment'
            ], 500);
        }
    }

    /**
     * Toggle like/dislike for a comment
     */
    public function toggleLike(Request $request, $photoId, $commentId): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|in:like,dislike,unlike,undislike'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid action',
                'errors' => $validator->errors()
            ], 422);
        }

        $comment = PhotoComment::where('photo_id', $photoId)
            ->where('id', $commentId)
            ->approved()
            ->first();

        if (!$comment) {
            return response()->json([
                'success' => false,
                'message' => 'Comment not found'
            ], 404);
        }

        $action = $request->action;
        
        switch ($action) {
            case 'like':
                $comment->increment('likes');
                break;
            case 'dislike':
                $comment->increment('dislikes');
                break;
            case 'unlike':
                if ($comment->likes > 0) {
                    $comment->decrement('likes');
                }
                break;
            case 'undislike':
                if ($comment->dislikes > 0) {
                    $comment->decrement('dislikes');
                }
                break;
        }

        $comment->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Vote recorded successfully',
            'data' => [
                'likes' => $comment->likes,
                'dislikes' => $comment->dislikes,
                'total_votes' => $comment->total_votes
            ]
        ]);
    }

    /**
     * Report a comment as inappropriate
     */
    public function report(Request $request, $photoId, $commentId): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'reason' => 'required|string|max:500|in:spam,inappropriate,harassment,other'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid reason',
                'errors' => $validator->errors()
            ], 422);
        }

        $comment = PhotoComment::where('photo_id', $photoId)
            ->where('id', $commentId)
            ->first();

        if (!$comment) {
            return response()->json([
                'success' => false,
                'message' => 'Comment not found'
            ], 404);
        }

        $comment->update([
            'is_flagged' => true,
            'flag_reason' => $request->reason
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Comment reported successfully. Our moderators will review it.'
        ]);
    }
}