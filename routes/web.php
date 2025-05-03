<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;

// Home → list of posts
Route::get('/', [PostController::class, 'index'])->name('posts.index');

// Posts
Route::get('/posts',                 [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/create',          [PostController::class, 'create'])->name('posts.create');
Route::post('/posts',                [PostController::class, 'store'])->name('posts.store');
Route::get('/posts/{post}',          [PostController::class, 'show'])->name('posts.show');
Route::get('/posts/{post}/edit',     [PostController::class, 'edit'])->name('posts.edit');
Route::put('/posts/{post}',          [PostController::class, 'update'])->name('posts.update');
Route::delete('/posts/{post}',       [PostController::class, 'destroy'])->name('posts.destroy');

// Comments (nested under posts for creation)
Route::post('/posts/{post}/comments',          [CommentController::class, 'store'])->name('comments.store');
Route::get('/comments/{comment}/edit',         [CommentController::class, 'edit'])->name('comments.edit');
Route::put('/comments/{comment}',              [CommentController::class, 'update'])->name('comments.update');
Route::delete('/comments/{comment}',           [CommentController::class, 'destroy'])->name('comments.destroy');

// Favorites / Bookmarks
Route::get('/favorites',                       [FavoriteController::class, 'index'])->name('favorites.index');
Route::post('/posts/{post}/favorite',          [FavoriteController::class, 'store'])->name('favorites.store');
Route::delete('/posts/{post}/favorite',        [FavoriteController::class, 'destroy'])->name('favorites.destroy');
