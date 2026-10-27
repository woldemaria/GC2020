<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PhotoController;
use App\Http\Controllers\Api\StudentProfileController;
use App\Http\Controllers\Api\NewsletterController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\BookmarkController;
use App\Http\Controllers\Api\ArticleRatingController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ArticleManagementController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\CategoryManagementController;
use App\Http\Controllers\Admin\AuthorManagementController;
use App\Http\Controllers\Api\CertificateController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Admin\CertificateManagementController;
use App\Http\Controllers\Api\CourseEnrollmentController;
use App\Http\Controllers\Api\SyllabusController;
use App\Http\Controllers\Api\PhotoCommentController;
use App\Http\Controllers\Admin\GalleryManagementController;

// Public API routes for the magazine website
Route::prefix('v1')->group(function () {
    // Articles
    Route::get('articles', [ArticleController::class, 'index']);
    Route::get('articles/featured', [ArticleController::class, 'featured']);
    Route::get('articles/{slug}', [ArticleController::class, 'show']);
    Route::get('articles/{slug}/related', [ArticleController::class, 'related']);
    
    // Categories
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{slug}', [CategoryController::class, 'show']);

    // Authors
    Route::get('authors', [AuthorManagementController::class, 'getForSelect']);
    
    // Photos/Gallery with enhanced features
    // NOTE: static routes (featured, category, stats) MUST come before the {id} wildcard
    Route::get('photos', [PhotoController::class, 'index']);
    Route::get('photos/featured', [PhotoController::class, 'featured']);
    Route::get('photos/stats', [PhotoController::class, 'getStats']);
    Route::get('photos/category/{category}', [PhotoController::class, 'byCategory']);
    Route::get('photos/{id}', [PhotoController::class, 'show']);
    Route::post('photos/{id}/like', [PhotoController::class, 'like']);
    Route::post('photos/{id}/dislike', [PhotoController::class, 'dislike']);

    // Photo Comments
    Route::get('photos/{photoId}/comments', [PhotoCommentController::class, 'index']);
    Route::post('photos/{photoId}/comments', [PhotoCommentController::class, 'store']);
    Route::post('photos/{photoId}/comments/{commentId}/like', [PhotoCommentController::class, 'toggleLike']);
    Route::post('photos/{photoId}/comments/{commentId}/report', [PhotoCommentController::class, 'report']);
    
    // Course Enrollment
    // NOTE: static sub-routes (status, student) MUST come before {id} wildcard
    Route::post('course-enrollments', [CourseEnrollmentController::class, 'store']);
    Route::get('course-enrollments/status', [CourseEnrollmentController::class, 'getStatus']);
    Route::get('course-enrollments/student/{email}', [CourseEnrollmentController::class, 'getByEmail']);
    Route::get('course-enrollments/{id}', [CourseEnrollmentController::class, 'show']);
    
    // Syllabus
    Route::get('syllabus', [SyllabusController::class, 'show']);
    Route::post('syllabus/download', [SyllabusController::class, 'downloadPdf']);
    
    // Student Profiles
    // NOTE: static sub-routes (featured, data/*) MUST come before {id} wildcard
    Route::get('student-profiles', [StudentProfileController::class, 'index']);
    Route::get('student-profiles/featured', [StudentProfileController::class, 'featured']);
    Route::get('student-profiles/data/majors', [StudentProfileController::class, 'majors']);
    Route::get('student-profiles/data/graduation-years', [StudentProfileController::class, 'graduationYears']);
    Route::get('student-profiles/{id}', [StudentProfileController::class, 'show']);
    
    // Newsletter
    Route::post('newsletter/subscribe', [NewsletterController::class, 'subscribe']);
    Route::post('newsletter/unsubscribe', [NewsletterController::class, 'unsubscribe']);
    Route::get('newsletter/status', [NewsletterController::class, 'status']);
    
    // Comments
    Route::get('articles/{articleId}/comments', [CommentController::class, 'index']);
    Route::post('articles/{articleId}/comments', [CommentController::class, 'store']);
    Route::get('articles/{articleId}/comments/count', [CommentController::class, 'count']);
    
    // Bookmarks
    Route::post('articles/{articleId}/bookmark', [BookmarkController::class, 'toggle']);
    Route::get('articles/{articleId}/bookmark/status', [BookmarkController::class, 'status']);
    Route::get('bookmarks', [BookmarkController::class, 'index']);
    Route::delete('bookmarks/{bookmarkId}', [BookmarkController::class, 'destroy']);
    
    // Article Ratings
    Route::post('articles/{articleId}/rating', [ArticleRatingController::class, 'rate']);
    Route::get('articles/{articleId}/rating/stats', [ArticleRatingController::class, 'stats']);
    Route::get('articles/{articleId}/rating/user', [ArticleRatingController::class, 'userRating']);

    
    // Events Calendar
    Route::get('events', [EventController::class, 'index']);
    Route::get('events/{slug}', [EventController::class, 'show']);
    Route::post('events/{slug}/register', [EventController::class, 'register']);
    // Certificate Verification
    Route::post('certificates/verify', [CertificateController::class, 'verify']);
    Route::get('certificates/verify/{code}', [CertificateController::class, 'getByCode']);
    Route::get('certificates/search', [CertificateController::class, 'search']);
    Route::get('university-info', [CertificateController::class, 'universityInfo']);

    // Registration Status (Public)
    Route::get('registration-status', [\App\Http\Controllers\Auth\RegisterController::class, 'status']);
});

// Admin API routes
Route::prefix('admin')->group(function () {
    // Dashboard & System
    Route::get('dashboard/stats', [AdminController::class, 'getDashboardStats']);
    Route::get('system-status', [AdminController::class, 'getSystemStatus']);
    Route::get('system-info', [AdminController::class, 'getSystemInfo']);
    Route::get('settings/registration', [AdminController::class, 'getRegistrationSettings']);
    Route::post('settings/registration', [AdminController::class, 'updateRegistrationSettings']);
    Route::post('clear-cache', [AdminController::class, 'clearCache']);
    Route::post('export', [AdminController::class, 'exportData']);
    
    // Article Management
    // NOTE: form-data and bulk-action MUST be before apiResource to avoid {article} wildcard capturing them
    Route::get('articles/form-data', [ArticleManagementController::class, 'getFormData']);
    Route::post('articles/bulk-action', [ArticleManagementController::class, 'bulkAction']);
    Route::apiResource('articles', ArticleManagementController::class);
    Route::post('articles/{id}/toggle-featured', [ArticleManagementController::class, 'toggleFeatured']);
    Route::post('articles/{id}/toggle-published', [ArticleManagementController::class, 'togglePublished']);
    Route::post('articles/{id}/duplicate', [ArticleManagementController::class, 'duplicate']);
    
    // Category Management
    Route::apiResource('categories', CategoryManagementController::class);
    Route::post('categories/{id}/toggle-active', [CategoryManagementController::class, 'toggleActive']);
    Route::get('categories-stats', [CategoryManagementController::class, 'getStats']);
    
    // Author Management
    Route::apiResource('authors', AuthorManagementController::class);
    Route::post('authors/{id}/toggle-active', [AuthorManagementController::class, 'toggleActive']);
    Route::get('authors-stats', [AuthorManagementController::class, 'getStats']);
    Route::get('authors-select', [AuthorManagementController::class, 'getForSelect']);
    
    // User Management
    Route::apiResource('users', UserManagementController::class);
    Route::post('users/{id}/toggle-admin', [UserManagementController::class, 'toggleAdmin']);
    
    // Media Management
    Route::post('media/upload', [MediaController::class, 'uploadImage']);
    Route::post('media/upload-multiple', [MediaController::class, 'uploadMultiple']);
    Route::delete('media/delete', [MediaController::class, 'deleteImage']);
    Route::get('media/list', [MediaController::class, 'listImages']);
    
    // Certificate Management
    Route::post('certificates/bulk-action', [CertificateManagementController::class, 'bulkAction']);
    Route::get('certificates-stats', [CertificateManagementController::class, 'getStats']);
    Route::apiResource('certificates', CertificateManagementController::class);
    
    // Gallery Management
    Route::post('gallery/bulk-action', [GalleryManagementController::class, 'bulkAction']);
    Route::get('gallery-stats', [GalleryManagementController::class, 'getStats']);
    Route::apiResource('gallery', GalleryManagementController::class);
    Route::post('gallery/{id}/toggle-approval', [GalleryManagementController::class, 'toggleApproval']);
    Route::get('gallery/{id}/comments', [GalleryManagementController::class, 'getComments']);
    
    // Course Enrollment Management
    Route::get('course-enrollments', [CourseEnrollmentController::class, 'adminIndex']);
    Route::post('course-enrollments/bulk-action', [CourseEnrollmentController::class, 'bulkAction']);
    Route::patch('course-enrollments/{id}/status', [CourseEnrollmentController::class, 'updateStatus']);
    
    // Program Downloads and Events
    Route::get('download-program', [AdminController::class, 'downloadGraduationProgram']);
    Route::post('programs/download-brochure', [AdminController::class, 'downloadProgramBrochure']);
    Route::get('events', [AdminController::class, 'getEvents']);
    Route::post('events', [AdminController::class, 'createEvent']);
    Route::post('events/register', [AdminController::class, 'registerForEvent']);
    Route::get('event-registrations', [AdminController::class, 'getEventRegistrations']);
    
    // Marketing Analytics and Campaigns
    Route::get('marketing/analytics', [AdminController::class, 'getMarketingAnalytics']);
    Route::post('marketing/campaigns', [AdminController::class, 'createMarketingCampaign']);
    Route::get('marketing/email-templates', [AdminController::class, 'getEmailTemplates']);
    Route::post('marketing/email-campaigns', [AdminController::class, 'sendEmailCampaign']);
});

// Protected routes (future admin functionality)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
