<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class MediaController extends Controller
{
    protected $imageManager;

    public function __construct()
    {
        $this->imageManager = new ImageManager(new Driver());
    }

    /**
     * Upload and process images
     */
    public function uploadImage(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240', // 10MB max
                'type' => 'required|string|in:article,avatar,gallery,general',
                'resize' => 'sometimes|boolean',
                'width' => 'sometimes|integer|min:50|max:2000',
                'height' => 'sometimes|integer|min:50|max:2000',
            ]);

            $file = $request->file('image');
            $type = $request->input('type', 'general');
            
            // Generate unique filename
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $filename = $originalName . '_' . time() . '_' . uniqid() . '.' . $extension;
            
            // Determine storage path based on type
            $storagePath = $this->getStoragePath($type);
            $fullPath = $storagePath . '/' . $filename;
            
            // Ensure storage directory exists
            $fullStoragePath = storage_path('app/public/' . $storagePath);
            if (!file_exists($fullStoragePath)) {
                mkdir($fullStoragePath, 0755, true);
            }
            
            // Process image with Intervention Image
            $image = $this->imageManager->read($file->getPathname());
            
            // Apply type-specific processing
            $this->processImageByType($image, $type, $request);
            
            // Save processed image
            $savedPath = storage_path('app/public/' . $fullPath);
            $image->save($savedPath);
            
            // Generate thumbnail for larger images
            $thumbnailPath = null;
            if ($image->width() > 400 || $image->height() > 400) {
                $thumbnailPath = $this->generateThumbnail($image, $storagePath, $filename);
            }
            
            // Get file size after processing
            $fileSize = file_exists($savedPath) ? filesize($savedPath) : 0;
            
            return response()->json([
                'success' => true,
                'message' => 'Image uploaded successfully',
                'data' => [
                    'filename' => $filename,
                    'original_name' => $file->getClientOriginalName(),
                    'path' => '/storage/' . $fullPath,
                    'thumbnail' => $thumbnailPath ? '/storage/' . $thumbnailPath : null,
                    'size' => [
                        'width' => $image->width(),
                        'height' => $image->height()
                    ],
                    'file_size' => $fileSize,
                    'mime_type' => $file->getMimeType(),
                    'type' => $type
                ]
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Image upload failed', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Image upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload multiple images
     */
    public function uploadMultiple(Request $request): JsonResponse
    {
        $request->validate([
            'images' => 'required|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'type' => 'required|string|in:article,avatar,gallery,general'
        ]);

        $uploadedFiles = [];
        $errors = [];

        foreach ($request->file('images') as $index => $file) {
            try {
                $singleRequest = new Request();
                $singleRequest->files->set('image', $file);
                $singleRequest->merge(['type' => $request->input('type')]);
                
                $response = $this->uploadImage($singleRequest);
                $responseData = json_decode($response->getContent(), true);
                
                if ($responseData['success']) {
                    $uploadedFiles[] = $responseData['data'];
                } else {
                    $errors[] = "File {$index}: " . $responseData['message'];
                }
            } catch (\Exception $e) {
                $errors[] = "File {$index}: " . $e->getMessage();
            }
        }

        return response()->json([
            'success' => count($uploadedFiles) > 0,
            'message' => count($uploadedFiles) . ' images uploaded successfully',
            'data' => $uploadedFiles,
            'errors' => $errors
        ]);
    }

    /**
     * Delete uploaded image
     */
    public function deleteImage(Request $request): JsonResponse
    {
        $request->validate([
            'path' => 'required|string'
        ]);

        try {
            $path = str_replace('/storage/', '', $request->input('path'));
            
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
                
                // Also delete thumbnail if exists
                $thumbnailPath = $this->getThumbnailPath($path);
                if ($thumbnailPath && Storage::disk('public')->exists($thumbnailPath)) {
                    Storage::disk('public')->delete($thumbnailPath);
                }
                
                return response()->json([
                    'success' => true,
                    'message' => 'Image deleted successfully'
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Image not found'
            ], 404);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete image: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * List uploaded images
     */
    public function listImages(Request $request): JsonResponse
    {
        $type = $request->input('type', 'general');
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 20);
        
        $storagePath = $this->getStoragePath($type);
        
        try {
            if (!Storage::disk('public')->exists($storagePath)) {
                return response()->json([
                    'success' => true,
                    'data' => [],
                    'pagination' => [
                        'current_page' => 1,
                        'total' => 0,
                        'per_page' => $perPage
                    ]
                ]);
            }
            
            $files = collect(Storage::disk('public')->files($storagePath))
                ->filter(function ($file) {
                    $extension = pathinfo($file, PATHINFO_EXTENSION);
                    return in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'svg']);
                })
                ->map(function ($file) {
                    $fullPath = storage_path('app/public/' . $file);
                    return [
                        'filename' => basename($file),
                        'path' => '/storage/' . $file,
                        'thumbnail' => $this->getThumbnailUrl($file),
                        'size' => file_exists($fullPath) ? filesize($fullPath) : 0,
                        'created_at' => file_exists($fullPath) ? date('Y-m-d H:i:s', filectime($fullPath)) : null
                    ];
                })
                ->sortByDesc('created_at')
                ->values();
            
            $total = $files->count();
            $offset = ($page - 1) * $perPage;
            $paginatedFiles = $files->slice($offset, $perPage)->values();
            
            return response()->json([
                'success' => true,
                'data' => $paginatedFiles,
                'pagination' => [
                    'current_page' => $page,
                    'total' => $total,
                    'per_page' => $perPage,
                    'total_pages' => ceil($total / $perPage)
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to list images: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get storage path based on type
     */
    private function getStoragePath(string $type): string
    {
        $paths = [
            'article' => 'images/articles',
            'avatar' => 'images/avatars',
            'gallery' => 'images/gallery',
            'general' => 'images/uploads'
        ];
        
        return $paths[$type] ?? $paths['general'];
    }

    /**
     * Process image based on type
     */
    private function processImageByType($image, string $type, Request $request): void
    {
        switch ($type) {
            case 'avatar':
                // Square crop for avatars
                $size = min($image->width(), $image->height());
                $image->crop($size, $size);
                $image->resize(300, 300);
                break;
                
            case 'article':
                // Resize for articles (maintain aspect ratio)
                if ($image->width() > 1200) {
                    $image->resize(1200, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                }
                break;
                
            case 'gallery':
                // Optimize for gallery
                if ($image->width() > 800) {
                    $image->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                }
                break;
        }

        // Apply custom resize if requested
        if ($request->has('resize') && $request->input('resize')) {
            $width = $request->input('width');
            $height = $request->input('height');
            
            if ($width && $height) {
                $image->resize($width, $height);
            } elseif ($width) {
                $image->resize($width, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            } elseif ($height) {
                $image->resize(null, $height, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
        }

        // Optimize image quality
        $image->encode(quality: 85);
    }

    /**
     * Generate thumbnail
     */
    private function generateThumbnail($image, string $storagePath, string $filename): ?string
    {
        try {
            $thumbnailName = 'thumb_' . $filename;
            $thumbnailPath = $storagePath . '/thumbnails/' . $thumbnailName;
            
            // Ensure thumbnails directory exists
            if (!Storage::disk('public')->exists($storagePath . '/thumbnails')) {
                Storage::disk('public')->makeDirectory($storagePath . '/thumbnails');
            }
            
            // Create thumbnail (200x200 max, maintain aspect ratio)
            $thumbnail = clone $image;
            $thumbnail->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            $thumbnail->save(storage_path('app/public/' . $thumbnailPath));
            
            return $thumbnailPath;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get thumbnail path
     */
    private function getThumbnailPath(string $originalPath): ?string
    {
        $pathInfo = pathinfo($originalPath);
        return $pathInfo['dirname'] . '/thumbnails/thumb_' . $pathInfo['basename'];
    }

    /**
     * Get thumbnail URL
     */
    private function getThumbnailUrl(string $originalPath): ?string
    {
        $thumbnailPath = $this->getThumbnailPath($originalPath);
        return $thumbnailPath && Storage::disk('public')->exists($thumbnailPath) 
            ? '/storage/' . $thumbnailPath 
            : null;
    }
}
