<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryManagementController extends Controller
{
    /**
     * Display categories for admin management
     */
    public function index(Request $request): JsonResponse
    {
        $query = Category::withCount('articles')
            ->orderBy('name');

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $categories = $query->paginate($request->get('per_page', 15));

        return response()->json($categories);
    }

    /**
     * Store a new category
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string|max:500',
            'color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/',
            'is_active' => 'boolean'
        ]);

        // Generate slug if not provided
        if (empty($validatedData['slug'])) {
            $validatedData['slug'] = Str::slug($validatedData['name']);
            
            // Ensure uniqueness
            $originalSlug = $validatedData['slug'];
            $counter = 1;
            while (Category::where('slug', $validatedData['slug'])->exists()) {
                $validatedData['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        $category = Category::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully',
            'data' => $category->load('articles')
        ], 201);
    }

    /**
     * Display a specific category
     */
    public function show(string $id): JsonResponse
    {
        $category = Category::withCount('articles')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $category
        ]);
    }

    /**
     * Update an existing category
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $category = Category::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('categories')->ignore($id)],
            'description' => 'nullable|string|max:500',
            'color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/',
            'is_active' => 'boolean'
        ]);

        // Generate slug if not provided
        if (empty($validatedData['slug'])) {
            $validatedData['slug'] = Str::slug($validatedData['name']);
        }

        $category->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully',
            'data' => $category->load('articles')
        ]);
    }

    /**
     * Delete a category
     */
    public function destroy(string $id): JsonResponse
    {
        $category = Category::findOrFail($id);
        
        // Check if category has articles
        if ($category->articles()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete category that has articles. Please reassign or delete the articles first.'
            ], 422);
        }
        
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully'
        ]);
    }

    /**
     * Toggle category active status
     */
    public function toggleActive(string $id): JsonResponse
    {
        $category = Category::findOrFail($id);
        $category->update(['is_active' => !$category->is_active]);

        return response()->json([
            'success' => true,
            'message' => $category->is_active ? 'Category activated' : 'Category deactivated',
            'data' => $category
        ]);
    }

    /**
     * Get category statistics
     */
    public function getStats(): JsonResponse
    {
        $stats = [
            'total' => Category::count(),
            'active' => Category::where('is_active', true)->count(),
            'with_articles' => Category::has('articles')->count(),
            'most_popular' => Category::withCount('articles')
                ->orderBy('articles_count', 'desc')
                ->limit(5)
                ->get(['id', 'name', 'color', 'articles_count'])
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}