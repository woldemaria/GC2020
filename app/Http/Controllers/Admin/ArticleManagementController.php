<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ArticleManagementController extends Controller
{
    /**
     * Display articles for admin management
     */
    public function index(Request $request): JsonResponse
    {
        $query = Article::with(['category', 'author'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->has('status')) {
            if ($request->status === 'published') {
                $query->where('is_published', true);
            } elseif ($request->status === 'draft') {
                $query->where('is_published', false);
            }
        }

        // Filter by category
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $articles = $query->paginate($request->get('per_page', 15));

        return response()->json($articles);
    }

    /**
     * Store a new article
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:articles,slug',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|string',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'string',
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'required|exists:authors,id',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50'
        ]);

        // Generate slug if not provided
        if (empty($validatedData['slug'])) {
            $validatedData['slug'] = Str::slug($validatedData['title']);
            
            // Ensure uniqueness
            $originalSlug = $validatedData['slug'];
            $counter = 1;
            while (Article::where('slug', $validatedData['slug'])->exists()) {
                $validatedData['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        // Set published_at if publishing
        if (!empty($validatedData['is_published']) && empty($validatedData['published_at'])) {
            $validatedData['published_at'] = now();
        }

        // Process content for image optimization
        $validatedData['content'] = $this->processContentImages($validatedData['content']);

        $article = Article::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Article created successfully',
            'data' => $article->load(['category', 'author'])
        ], 201);
    }

    /**
     * Display a specific article
     */
    public function show(string $id): JsonResponse
    {
        $article = Article::with(['category', 'author'])->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $article
        ]);
    }

    /**
     * Update an existing article
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $article = Article::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('articles')->ignore($id)],
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|string',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'string',
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'required|exists:authors,id',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50'
        ]);

        // Generate slug if not provided
        if (empty($validatedData['slug'])) {
            $validatedData['slug'] = Str::slug($validatedData['title']);
        }

        // Set published_at if publishing for the first time
        if (!empty($validatedData['is_published']) && !$article->published_at) {
            $validatedData['published_at'] = now();
        }

        // Process content for image optimization
        $validatedData['content'] = $this->processContentImages($validatedData['content']);

        $article->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Article updated successfully',
            'data' => $article->load(['category', 'author'])
        ]);
    }

    /**
     * Delete an article
     */
    public function destroy(string $id): JsonResponse
    {
        $article = Article::findOrFail($id);
        
        // Clean up associated images if needed
        $this->cleanupArticleImages($article);
        
        $article->delete();

        return response()->json([
            'success' => true,
            'message' => 'Article deleted successfully'
        ]);
    }

    /**
     * Toggle article featured status
     */
    public function toggleFeatured(string $id): JsonResponse
    {
        $article = Article::findOrFail($id);
        $article->update(['is_featured' => !$article->is_featured]);

        return response()->json([
            'success' => true,
            'message' => $article->is_featured ? 'Article featured' : 'Article unfeatured',
            'data' => $article
        ]);
    }

    /**
     * Toggle article published status
     */
    public function togglePublished(string $id): JsonResponse
    {
        $article = Article::findOrFail($id);
        
        $updateData = ['is_published' => !$article->is_published];
        
        // Set published_at when publishing
        if ($updateData['is_published'] && !$article->published_at) {
            $updateData['published_at'] = now();
        }
        
        $article->update($updateData);

        return response()->json([
            'success' => true,
            'message' => $article->is_published ? 'Article published' : 'Article unpublished',
            'data' => $article
        ]);
    }

    /**
     * Get categories and authors for form dropdowns
     */
    public function getFormData(): JsonResponse
    {
        $categories = Category::orderBy('name')->get(['id', 'name', 'slug', 'color']);
        $authors = Author::orderBy('name')->get(['id', 'name', 'position', 'avatar']);

        return response()->json([
            'success' => true,
            'data' => [
                'categories' => $categories,
                'authors' => $authors
            ]
        ]);
    }

    /**
     * Process content images for optimization
     */
    private function processContentImages(string $content): string
    {
        // Add lazy loading and responsive attributes to images
        $content = preg_replace(
            '/<img([^>]*?)src="([^"]*)"([^>]*?)>/i',
            '<img$1src="$2"$3 loading="lazy" style="max-width: 100%; height: auto;">',
            $content
        );

        // Process base64 images (from rich text editor) and convert to files
        $content = preg_replace_callback(
            '/src="data:image\/([^;]+);base64,([^"]+)"/i',
            function ($matches) {
                return $this->convertBase64ToFile($matches[1], $matches[2]);
            },
            $content
        );

        return $content;
    }

    /**
     * Convert base64 image to file and return file path
     */
    private function convertBase64ToFile(string $extension, string $data): string
    {
        try {
            $imageData = base64_decode($data);
            $filename = 'content_' . time() . '_' . uniqid() . '.' . $extension;
            $path = 'images/articles/' . $filename;
            
            // Save to storage
            \Storage::disk('public')->put($path, $imageData);
            
            return 'src="/storage/' . $path . '"';
        } catch (\Exception $e) {
            // Return original if conversion fails
            return 'src="data:image/' . $extension . ';base64,' . $data . '"';
        }
    }

    /**
     * Clean up article images when deleting
     */
    private function cleanupArticleImages(Article $article): void
    {
        // This could be expanded to actually remove unused image files
        // For now, we just log that cleanup should happen
        \Log::info('Article images cleanup needed for article: ' . $article->id);
    }

    /**
     * Duplicate an article
     */
    public function duplicate(string $id): JsonResponse
    {
        $original = Article::findOrFail($id);
        
        $duplicate = $original->replicate();
        $duplicate->title = $original->title . ' (Copy)';
        $duplicate->slug = Str::slug($duplicate->title) . '-' . time();
        $duplicate->is_published = false;
        $duplicate->is_featured = false;
        $duplicate->published_at = null;
        $duplicate->views = 0;
        $duplicate->save();

        return response()->json([
            'success' => true,
            'message' => 'Article duplicated successfully',
            'data' => $duplicate->load(['category', 'author'])
        ]);
    }

    /**
     * Bulk operations
     */
    public function bulkAction(Request $request): JsonResponse
    {
        $request->validate([
            'action' => 'required|in:publish,unpublish,feature,unfeature,delete',
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:articles,id'
        ]);

        $action = $request->action;
        $ids = $request->ids;
        $count = 0;

        switch ($action) {
            case 'publish':
                $count = Article::whereIn('id', $ids)->update([
                    'is_published' => true,
                    'published_at' => now()
                ]);
                break;
                
            case 'unpublish':
                $count = Article::whereIn('id', $ids)->update(['is_published' => false]);
                break;
                
            case 'feature':
                $count = Article::whereIn('id', $ids)->update(['is_featured' => true]);
                break;
                
            case 'unfeature':
                $count = Article::whereIn('id', $ids)->update(['is_featured' => false]);
                break;
                
            case 'delete':
                $count = Article::whereIn('id', $ids)->delete();
                break;
        }

        return response()->json([
            'success' => true,
            'message' => ucfirst($action) . " completed for {$count} articles"
        ]);
    }
}
