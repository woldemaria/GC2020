<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\PhotoComment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class GalleryManagementController extends Controller
{
    /**
     * Get all photos for admin management
     */
    public function index(Request $request): JsonResponse
    {
        $query = Photo::query();

        // Apply filters
        if ($request->filled('is_public')) {
            $query->where('is_public', $request->boolean('is_public'));
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

        if ($request->filled('approved_status')) {
            if ($request->approved_status === 'approved') {
                $query->whereNotNull('approved_at');
            } else {
                $query->whereNull('approved_at');
            }
        }

        $photos = $query->orderBy('created_at', 'desc')->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $photos->items(),
            'pagination' => [
                'current_page' => $photos->currentPage(),
                'per_page' => $photos->perPage(),
                'total' => $photos->total(),
                'last_page' => $photos->lastPage()
            ],
            'stats' => [
                'total_photos' => Photo::count(),
                'public_photos' => Photo::where('is_public', true)->count(),
                'pending_approval' => Photo::whereNull('approved_at')->count(),
                'total_likes' => Photo::sum('likes'),
                'total_comments' => PhotoComment::count(),
                'pending_comments' => PhotoComment::where('is_approved', false)->count()
            ]
        ]);
    }

    /**
     * Upload a new photo to gallery
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240', // 10MB max
            'title' => 'required|string|max:200',
            'description' => 'nullable|string|max:1000',
            'category' => 'required|string|max:50',
            'photo_type' => 'required|string|in:graduation,event,campus,student_life,academic,sports,other',
            'graduation_year' => 'nullable|integer|min:1990|max:2030',
            'motto' => 'nullable|string|max:200',
            'student_name' => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
            'degree_program' => 'nullable|string|max:100',
            'photographer' => 'nullable|string|max:100',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'is_featured' => 'boolean',
            'is_public' => 'boolean',
            'allow_comments' => 'boolean',
            'alt_text' => 'nullable|string|max:200'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Handle image upload
            $image = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $directory = 'gallery/' . date('Y/m');
            $path = $directory . '/' . $filename;

            // Create directory if it doesn't exist
            Storage::disk('public')->makeDirectory($directory);

            // Store original image
            Storage::disk('public')->put($path, file_get_contents($image));

            // Create thumbnail
            $thumbnailPath = $directory . '/' . pathinfo($filename, PATHINFO_FILENAME) . '_thumb.' . $image->getClientOriginalExtension();
            $thumbnailImage = Image::make($image)->fit(300, 200);
            Storage::disk('public')->put($thumbnailPath, $thumbnailImage->encode());

            // Create photo record
            $photo = Photo::create([
                'title' => $request->title,
                'description' => $request->description,
                'image_path' => $path,
                'alt_text' => $request->alt_text ?: $request->title,
                'category' => $request->category,
                'photo_type' => $request->photo_type,
                'graduation_year' => $request->graduation_year,
                'motto' => $request->motto,
                'student_name' => $request->student_name,
                'department' => $request->department,
                'degree_program' => $request->degree_program,
                'photographer' => $request->photographer,
                'tags' => $request->tags,
                'is_featured' => $request->boolean('is_featured'),
                'is_public' => $request->boolean('is_public', true),
                'allow_comments' => $request->boolean('allow_comments', true),
                'uploaded_by' => auth()->id(), // If authentication is implemented
                'approved_at' => now(), // Auto-approve admin uploads
                'approved_by' => auth()->id(),
                'taken_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Photo uploaded successfully',
                'photo' => [
                    'id' => $photo->id,
                    'title' => $photo->title,
                    'image_url' => $photo->image_url,
                    'thumbnail_url' => $photo->thumbnail_url,
                    'category' => $photo->category,
                    'photo_type' => $photo->photo_type,
                    'is_public' => $photo->is_public,
                    'created_at' => $photo->created_at->format('F j, Y')
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload photo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update photo details
     */
    public function update(Request $request, $id): JsonResponse
    {
        $photo = Photo::find($id);
        if (!$photo) {
            return response()->json([
                'success' => false,
                'message' => 'Photo not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:200',
            'description' => 'nullable|string|max:1000',
            'category' => 'sometimes|required|string|max:50',
            'photo_type' => 'sometimes|required|string|in:graduation,event,campus,student_life,academic,sports,other',
            'graduation_year' => 'nullable|integer|min:1990|max:2030',
            'motto' => 'nullable|string|max:200',
            'student_name' => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
            'degree_program' => 'nullable|string|max:100',
            'photographer' => 'nullable|string|max:100',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'is_featured' => 'boolean',
            'is_public' => 'boolean',
            'allow_comments' => 'boolean',
            'alt_text' => 'nullable|string|max:200',
            'admin_notes' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $photo->update($request->only([
                'title', 'description', 'category', 'photo_type', 'graduation_year',
                'motto', 'student_name', 'department', 'degree_program', 'photographer',
                'tags', 'is_featured', 'is_public', 'allow_comments', 'alt_text', 'admin_notes'
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Photo updated successfully',
                'photo' => $photo
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update photo'
            ], 500);
        }
    }

    /**
     * Delete a photo
     */
    public function destroy($id): JsonResponse
    {
        $photo = Photo::find($id);
        if (!$photo) {
            return response()->json([
                'success' => false,
                'message' => 'Photo not found'
            ], 404);
        }

        try {
            // Delete image files
            if ($photo->image_path && Storage::disk('public')->exists($photo->image_path)) {
                Storage::disk('public')->delete($photo->image_path);
            }

            // Delete thumbnail if exists
            $thumbnailPath = $this->getThumbnailPath($photo->image_path);
            if ($thumbnailPath && Storage::disk('public')->exists($thumbnailPath)) {
                Storage::disk('public')->delete($thumbnailPath);
            }

            // Delete photo record
            $photo->delete();

            return response()->json([
                'success' => true,
                'message' => 'Photo deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete photo'
            ], 500);
        }
    }

    /**
     * Approve/disapprove a photo
     */
    public function toggleApproval($id): JsonResponse
    {
        $photo = Photo::find($id);
        if (!$photo) {
            return response()->json([
                'success' => false,
                'message' => 'Photo not found'
            ], 404);
        }

        if ($photo->approved_at) {
            $photo->update([
                'approved_at' => null,
                'approved_by' => null
            ]);
            $status = 'disapproved';
        } else {
            $photo->update([
                'approved_at' => now(),
                'approved_by' => auth()->id()
            ]);
            $status = 'approved';
        }

        return response()->json([
            'success' => true,
            'message' => "Photo {$status} successfully",
            'approved' => $photo->approved_at !== null
        ]);
    }

    /**
     * Get photo comments for moderation
     */
    public function getComments($id): JsonResponse
    {
        $photo = Photo::find($id);
        if (!$photo) {
            return response()->json([
                'success' => false,
                'message' => 'Photo not found'
            ], 404);
        }

        $comments = PhotoComment::where('photo_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'photo' => [
                'id' => $photo->id,
                'title' => $photo->title,
                'allow_comments' => $photo->allow_comments
            ],
            'comments' => $comments->items(),
            'pagination' => [
                'current_page' => $comments->currentPage(),
                'per_page' => $comments->perPage(),
                'total' => $comments->total(),
                'last_page' => $comments->lastPage()
            ]
        ]);
    }

    /**
     * Bulk operations on photos
     */
    public function bulkAction(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|string|in:approve,disapprove,make_public,make_private,delete,feature,unfeature',
            'photo_ids' => 'required|array|min:1',
            'photo_ids.*' => 'integer|exists:photos,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $photoIds = $request->photo_ids;
        $action = $request->action;
        $updated = 0;

        try {
            switch ($action) {
                case 'approve':
                    $updated = Photo::whereIn('id', $photoIds)->update([
                        'approved_at' => now(),
                        'approved_by' => auth()->id()
                    ]);
                    break;
                case 'disapprove':
                    $updated = Photo::whereIn('id', $photoIds)->update([
                        'approved_at' => null,
                        'approved_by' => null
                    ]);
                    break;
                case 'make_public':
                    $updated = Photo::whereIn('id', $photoIds)->update(['is_public' => true]);
                    break;
                case 'make_private':
                    $updated = Photo::whereIn('id', $photoIds)->update(['is_public' => false]);
                    break;
                case 'feature':
                    $updated = Photo::whereIn('id', $photoIds)->update(['is_featured' => true]);
                    break;
                case 'unfeature':
                    $updated = Photo::whereIn('id', $photoIds)->update(['is_featured' => false]);
                    break;
                case 'delete':
                    $photos = Photo::whereIn('id', $photoIds)->get();
                    foreach ($photos as $photo) {
                        // Delete image files
                        if ($photo->image_path && Storage::disk('public')->exists($photo->image_path)) {
                            Storage::disk('public')->delete($photo->image_path);
                        }
                        $thumbnailPath = $this->getThumbnailPath($photo->image_path);
                        if ($thumbnailPath && Storage::disk('public')->exists($thumbnailPath)) {
                            Storage::disk('public')->delete($thumbnailPath);
                        }
                        $photo->delete();
                        $updated++;
                    }
                    break;
            }

            return response()->json([
                'success' => true,
                'message' => "Bulk action '{$action}' completed successfully",
                'updated_count' => $updated
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Bulk action failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get gallery statistics
     */
    public function getStats(): JsonResponse
    {
        $stats = [
            'total_photos' => Photo::count(),
            'public_photos' => Photo::where('is_public', true)->count(),
            'featured_photos' => Photo::where('is_featured', true)->count(),
            'pending_approval' => Photo::whereNull('approved_at')->count(),
            'total_likes' => Photo::sum('likes'),
            'total_dislikes' => Photo::sum('dislikes'),
            'total_comments' => PhotoComment::count(),
            'approved_comments' => PhotoComment::where('is_approved', true)->count(),
            'pending_comments' => PhotoComment::where('is_approved', false)->count(),
            'flagged_comments' => PhotoComment::where('is_flagged', true)->count(),
            'photos_by_type' => Photo::select('photo_type')
                ->selectRaw('count(*) as count')
                ->groupBy('photo_type')
                ->pluck('count', 'photo_type'),
            'photos_by_year' => Photo::whereNotNull('graduation_year')
                ->select('graduation_year')
                ->selectRaw('count(*) as count')
                ->groupBy('graduation_year')
                ->orderBy('graduation_year', 'desc')
                ->pluck('count', 'graduation_year'),
            'recent_activity' => [
                'photos_this_month' => Photo::where('created_at', '>=', now()->startOfMonth())->count(),
                'comments_this_month' => PhotoComment::where('created_at', '>=', now()->startOfMonth())->count(),
                'likes_this_month' => Photo::where('updated_at', '>=', now()->startOfMonth())->sum('likes')
            ]
        ];

        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }

    /**
     * Helper method to get thumbnail path
     */
    private function getThumbnailPath($imagePath)
    {
        if (!$imagePath) return null;
        
        $pathInfo = pathinfo($imagePath);
        return $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '_thumb.' . $pathInfo['extension'];
    }
}