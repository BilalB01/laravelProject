<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilePageController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\NewsCommentController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminNewsController;
use App\Http\Controllers\Admin\AdminFaqCategoryController;
use App\Http\Controllers\Admin\AdminFaqController;
use App\Http\Controllers\Admin\AdminContactController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Search route
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Contact routes
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Community posts routes
Route::get('/community', [PostController::class, 'index'])->name('posts.index');
Route::middleware(['auth'])->group(function () {
    Route::post('/community', [PostController::class, 'store'])->name('posts.store');
    Route::delete('/community/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});

// Public news routes
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{news}', [NewsController::class, 'show'])->name('news.show');

// News comments routes (auth required)
Route::middleware(['auth'])->group(function () {
    Route::post('/news/{news}/comments', [NewsCommentController::class, 'store'])->name('news.comments.store');
    Route::delete('/news/comments/{comment}', [NewsCommentController::class, 'destroy'])->name('news.comments.destroy');
});

// Public FAQ route
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');

// Public profile (accessible to everyone)
Route::get('/profile/{username}', [ProfilePageController::class, 'show'])->name('profile.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Private profile edit
    Route::get('/my-profile/edit', [ProfilePageController::class, 'edit'])->name('profile.page.edit');
    Route::patch('/my-profile', [ProfilePageController::class, 'update'])->name('profile.page.update');
});

// Admin routes (protected by auth and admin middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // User management
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::patch('/users/{user}/toggle-admin', [AdminUserController::class, 'toggleAdmin'])->name('users.toggleAdmin');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    
    // News management
    Route::resource('news', AdminNewsController::class);
    
    // FAQ management
    Route::resource('faq-categories', AdminFaqCategoryController::class);
    Route::resource('faqs', AdminFaqController::class);
    
    // Contact messages management
    Route::get('/contact', [AdminContactController::class, 'index'])->name('contact.index');
    Route::get('/contact/{contactMessage}', [AdminContactController::class, 'show'])->name('contact.show');
    Route::post('/contact/{contactMessage}/reply', [AdminContactController::class, 'reply'])->name('contact.reply');
    Route::delete('/contact/{contactMessage}', [AdminContactController::class, 'destroy'])->name('contact.destroy');
});

require __DIR__.'/auth.php';
