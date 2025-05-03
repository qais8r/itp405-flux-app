<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = auth()->user()
            ->favoritePosts()
            ->with('user')
            ->get();

        return view('favorites.index', compact('favorites'));
    }

    public function store(Post $post)
    {
        auth()->user()->favorites()->create([
            'post_id' => $post->id,
        ]);

        session()->flash('success', 'Post favorited.');

        return back();
    }

    public function destroy(Post $post)
    {
        auth()->user()->favorites()
            ->where('post_id', $post->id)
            ->delete();

        session()->flash('success', 'Favorite removed.');

        return back();
    }
}
