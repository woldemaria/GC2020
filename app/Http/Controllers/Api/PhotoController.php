<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PhotoController extends Controller
{
    /**
     * Display a listing of photos with enhanced filtering
     */
    public function index(Request $request): JsonResponse
    {
        $query = Photo::where('is_public', true);

        // Apply filters
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('photo_type')) {
            $query->where('photo_type', $request->photo_type);
        }

        if ($request->filled('graduation_year')) {
            $query->where('graduation_year', $request->graduation_year);
        }

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('student_name', 'LIKE', "%{$search}%")
                  ->orWhere('motto', 'LIKE', "%{$search}%");
            });
        }

        // Sorting options
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        if ($sortBy === 'popularity') {
            $query->orderBy('likes', 'desc');
        } elseif ($sortBy === 'graduation_year') {
            $query->orderBy('graduation_year', $sortOrder);
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        $perPage = min($request->get('per_page', 12), 50);
        $photos = $query->paginate($perPage);

        $enhancedPhotos = $photos->getCollection()->map(function ($photo) {
            return [
                'id' => $photo->id,
                'title' => $photo->title,
                'description' => $photo->description,
                'image_path' => $photo->image_path ? (str_starts_with($photo->image_path, 'http') ? $photo->image_path : asset('storage/' . $photo->image_path)) : asset('images/placeholder-gallery.jpg'),
                'alt_text' => $photo->alt_text,
                'category' => $photo->category,
                'photo_type' => $photo->photo_type,
                'is_featured' => $photo->is_featured,
                'taken_at' => $photo->taken_at?->format('Y-m-d'),
                'likes_count' => $photo->likes ?? 0,
                'dislikes_count' => $photo->dislikes ?? 0,
                'total_votes' => ($photo->likes ?? 0) + ($photo->dislikes ?? 0),
                'like_percentage' => (($photo->likes ?? 0) + ($photo->dislikes ?? 0)) > 0 ? round((($photo->likes ?? 0) / (($photo->likes ?? 0) + ($photo->dislikes ?? 0))) * 100, 1) : 0,
                'comments_count' => $photo->comments()->count(),
                'graduation_year' => $photo->graduation_year,
                'motto' => $photo->motto,
                'student_name' => $photo->student_name,
                'student_names' => $photo->student_names ?? [],
                'department' => $photo->department,
                'degree_program' => $photo->degree_program,
                'photographer' => $photo->photographer,
                'tags' => $photo->tags ?? [],
                'allow_comments' => $photo->allow_comments,
                'created_at' => $photo->created_at->format('F j, Y'),
                'aspect_ratio' => '3/4' // Default aspect ratio for gallery display
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $enhancedPhotos,
            'pagination' => [
                'current_page' => $photos->currentPage(),
                'per_page' => $photos->perPage(),
                'total' => $photos->total(),
                'last_page' => $photos->lastPage(),
                'has_more' => $photos->hasMorePages()
            ]
        ]);
    }

    /**
     * Display the specified photo with enhanced details
     */
    public function show(string $id): JsonResponse
    {
        $photo = Photo::with(['comments' => function($query) {
            $query->approved()->orderBy('created_at', 'desc');
        }])->find($id);

        if (!$photo || !$photo->is_public) {
            return response()->json([
                'success' => false,
                'message' => 'Photo not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'photo' => [
                'id' => $photo->id,
                'title' => $photo->title,
                'description' => $photo->description,
                'image_url' => $photo->image_url,
                'alt_text' => $photo->alt_text,
                'category' => $photo->category,
                'photo_type' => $photo->photo_type,
                'is_featured' => $photo->is_featured,
                'taken_at' => $photo->taken_at?->format('F j, Y'),
                'likes' => $photo->likes,
                'dislikes' => $photo->dislikes,
                'total_votes' => $photo->total_votes,
                'like_percentage' => $photo->like_percentage,
                'graduation_year' => $photo->graduation_year,
                'motto' => $photo->motto,
                'student_name' => $photo->student_name,
                'department' => $photo->department,
                'degree_program' => $photo->degree_program,
                'photographer' => $photo->photographer,
                'tags' => $photo->tags,
                'allow_comments' => $photo->allow_comments,
                'created_at' => $photo->created_at->format('F j, Y'),
                'comments' => $photo->comments->map(function($comment) {
                    return [
                        'id' => $comment->id,
                        'commenter_name' => $comment->commenter_name,
                        'comment' => $comment->comment,
                        'likes' => $comment->likes,
                        'dislikes' => $comment->dislikes,
                        'time_ago' => $comment->time_ago,
                        'created_at' => $comment->created_at->format('F j, Y g:i A')
                    ];
                })
            ]
        ]);
    }

    /**
     * Get featured photos for homepage or gallery highlights
     */
    public function featured(): JsonResponse
    {
        $photos = Photo::featured()
            ->public()
            ->approved()
            ->orderBy('order', 'asc')
            ->orderBy('taken_at', 'desc')
            ->limit(8)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $photos->map(function ($photo) {
                return [
                    'id' => $photo->id,
                    'title' => $photo->title,
                    'image_url' => $photo->image_url,
                    'thumbnail_url' => $photo->thumbnail_url,
                    'category' => $photo->category,
                    'photo_type' => $photo->photo_type,
                    'likes' => $photo->likes,
                    'graduation_year' => $photo->graduation_year,
                    'student_name' => $photo->student_name
                ];
            })
        ]);
    }

    /**
     * Get photos by category with enhanced data
     */
    public function byCategory(string $category): JsonResponse
    {
        $photos = Photo::byCategory($category)
            ->public()
            ->approved()
            ->orderBy('order', 'asc')
            ->orderBy('taken_at', 'desc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $photos->items(),
            'pagination' => [
                'current_page' => $photos->currentPage(),
                'per_page' => $photos->perPage(),
                'total' => $photos->total(),
                'last_page' => $photos->lastPage()
            ]
        ]);
    }

    /**
     * Like a photo
     */
    public function like($id): JsonResponse
    {
        $photo = Photo::find($id);
        if (!$photo) {
            return response()->json([
                'success' => false,
                'message' => 'Photo not found'
            ], 404);
        }

        // For demo purposes, we'll just increment the counter
        // In a real app, you'd track user votes to prevent duplicate voting
        $photo->increment('likes');
        $photo->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Photo liked successfully',
            'likes_count' => $photo->likes,
            'dislikes_count' => $photo->dislikes,
            'user_liked' => true,
            'user_disliked' => false
        ]);
    }

    /**
     * Dislike a photo  
     */
    public function dislike($id): JsonResponse
    {
        $photo = Photo::find($id);
        if (!$photo) {
            return response()->json([
                'success' => false,
                'message' => 'Photo not found'
            ], 404);
        }

        // For demo purposes, we'll just increment the counter
        $photo->increment('dislikes');
        $photo->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Photo disliked successfully',
            'likes_count' => $photo->likes,
            'dislikes_count' => $photo->dislikes,
            'user_liked' => false,
            'user_disliked' => true
        ]);
    }

    /**
     * Get photo statistics
     */
    public function getStats(): JsonResponse
    {
        $stats = [
            'total_photos' => Photo::public()->count(),
            'total_likes' => Photo::public()->sum('likes'),
            'most_liked' => Photo::public()->orderBy('likes', 'desc')->first(['title', 'likes']),
            'recent_uploads' => Photo::public()->where('created_at', '>=', now()->subDays(30))->count(),
            'photos_by_type' => Photo::public()
                ->select('photo_type', DB::raw('count(*) as count'))
                ->groupBy('photo_type')
                ->pluck('count', 'photo_type'),
            'graduation_years' => Photo::public()
                ->whereNotNull('graduation_year')
                ->select('graduation_year', DB::raw('count(*) as count'))
                ->groupBy('graduation_year')
                ->orderBy('graduation_year', 'desc')
                ->pluck('count', 'graduation_year')
        ];

        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }
}
