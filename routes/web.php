<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\AuthController;

// Authentication
Route::get('register',      [AuthController::class, 'showRegister'])->name('register');
Route::post('register',     [AuthController::class, 'register']);
Route::get('login',         [AuthController::class, 'showLogin'])->name('login');
Route::post('login',        [AuthController::class, 'login']);
Route::post('logout',       [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    // Home → list of posts
    Route::get('/', [PostController::class, 'index'])->name('posts.index');

    // Posts
    Route::get('/posts',                 [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create',          [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts',                [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}',          [PostController::class, 'show'])->name('posts.show');
    Route::get('/posts/{post}/edit',     [PostController::class, 'edit'])->name('posts.edit')->middleware('owns.post'); 
    Route::put('/posts/{post}',          [PostController::class, 'update'])->name('posts.update')->middleware('owns.post'); 
    Route::delete('/posts/{post}',       [PostController::class, 'destroy'])->name('posts.destroy')->middleware('owns.post'); 

    // Comments (nested under posts for creation)
    Route::post('/posts/{post}/comments',          [CommentController::class, 'store'])->name('comments.store');
    Route::get('/comments/{comment}/edit',         [CommentController::class, 'edit'])->name('comments.edit')->middleware('owns.comment'); 
    Route::put('/comments/{comment}',              [CommentController::class, 'update'])->name('comments.update')->middleware('owns.comment'); 
    Route::delete('/comments/{comment}',           [CommentController::class, 'destroy'])->name('comments.destroy')->middleware('owns.comment'); 

    // Favorites / Bookmarks
    Route::get('/favorites',                       [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/posts/{post}/favorite',          [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/posts/{post}/favorite',        [FavoriteController::class, 'destroy'])->name('favorites.destroy');

    // Likes
    Route::post('/posts/{post}/like',       [LikeController::class, 'store'])->name('likes.store');
    Route::delete('/posts/{post}/like',     [LikeController::class, 'destroy'])->name('likes.destroy');

});