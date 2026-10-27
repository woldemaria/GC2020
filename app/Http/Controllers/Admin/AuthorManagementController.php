<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class AuthorManagementController extends Controller
{
    /**
     * Display authors for admin management
     */
    public function index(Request $request): JsonResponse
    {
        $query = Author::withCount('articles')
            ->orderBy('name');

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhere('bio', 'like', "%{$search}%");
            });
        }

        $authors = $query->paginate($request->get('per_page', 15));

        return response()->json($authors);
    }

    /**
     * Store a new author
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:authors,email',
            'position' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'avatar' => 'nullable|string|max:255',
            'social_links' => 'nullable|array',
            'social_links.facebook' => 'nullable|url',
            'social_links.twitter' => 'nullable|url',
            'social_links.linkedin' => 'nullable|url',
            'social_links.instagram' => 'nullable|url',
            'is_active' => 'boolean'
        ]);

        // Convert social_links to JSON if provided
        if (isset($validatedData['social_links'])) {
            $validatedData['social_links'] = json_encode($validatedData['social_links']);
        }

        $author = Author::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Author created successfully',
            'data' => $author->loadCount('articles')
        ], 201);
    }

    /**
     * Display a specific author
     */
    public function show(string $id): JsonResponse
    {
        $author = Author::withCount('articles')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $author
        ]);
    }

    /**
     * Update an existing author
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $author = Author::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('authors')->ignore($id)],
            'position' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'avatar' => 'nullable|string|max:255',
            'social_links' => 'nullable|array',
            'social_links.facebook' => 'nullable|url',
            'social_links.twitter' => 'nullable|url',
            'social_links.linkedin' => 'nullable|url',
            'social_links.instagram' => 'nullable|url',
            'is_active' => 'boolean'
        ]);

        // Convert social_links to JSON if provided
        if (isset($validatedData['social_links'])) {
            $validatedData['social_links'] = json_encode($validatedData['social_links']);
        }

        $author->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Author updated successfully',
            'data' => $author->loadCount('articles')
        ]);
    }

    /**
     * Delete an author
     */
    public function destroy(string $id): JsonResponse
    {
        $author = Author::findOrFail($id);
        
        // Check if author has articles
        if ($author->articles()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete author who has published articles. Please reassign the articles first.'
            ], 422);
        }
        
        $author->delete();

        return response()->json([
            'success' => true,
            'message' => 'Author deleted successfully'
        ]);
    }

    /**
     * Toggle author active status
     */
    public function toggleActive(string $id): JsonResponse
    {
        $author = Author::findOrFail($id);
        $author->update(['is_active' => !$author->is_active]);

        return response()->json([
            'success' => true,
            'message' => $author->is_active ? 'Author activated' : 'Author deactivated',
            'data' => $author
        ]);
    }

    /**
     * Get author statistics
     */
    public function getStats(): JsonResponse
    {
        $stats = [
            'total' => Author::count(),
            'active' => Author::where('is_active', true)->count(),
            'with_articles' => Author::has('articles')->count(),
            'most_productive' => Author::withCount('articles')
                ->orderBy('articles_count', 'desc')
                ->limit(5)
                ->get(['id', 'name', 'position', 'avatar', 'articles_count'])
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Get authors for dropdowns
     */
    public function getForSelect(): JsonResponse
    {
        $authors = Author::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'position', 'avatar']);

        return response()->json([
            'success' => true,
            'data' => $authors
        ]);
    }
}