<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::redirect('/register', '/login')->name('register');
Route::redirect('/signup', '/login');
Route::post('/api/login', [LoginController::class, 'login'])->middleware('web');
Route::post('/api/logout', [LoginController::class, 'logout'])->middleware('web');
Route::get('/api/user', [LoginController::class, 'user'])->middleware('web');

// Admin routes (protected by admin auth middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/{any}', [AdminController::class, 'index'])
        ->where('any', '.*')
        ->name('admin');
});

// Certificate verification routes
Route::get('/verify-certificate', function () {
    return view('app');
})->name('certificate.verify');

Route::get('/verify-certificate/{code}', function ($code) {
    return view('app');
})->name('certificate.verify.code');

// Catch-all route for Vue.js SPA (main website)
Route::get('/{any}', function () {
    return view('app');
})->where('any', '^(?!api/|admin/).*$');
