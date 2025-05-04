<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        // Retrieve the authenticated user's favorite posts
        $favorites = auth()->user()
            ->favoritePosts()
            ->with('user')
            ->get();

        // Pass the favorites to the view
        return view('favorites.index', compact('favorites'));
    }

    public function store(Post $post)
    {
        // Create a new favorite for the authenticated user
        auth()->user()->favorites()->create([
            'post_id' => $post->id,
        ]);

        // Flash a success message
        session()->flash('success', 'Post favorited.');

        // Redirect back to the previous page
        return back();
    }

    public function destroy(Post $post)
    {
        // Delete the favorite for the authenticated user
        auth()->user()->favorites()
            ->where('post_id', $post->id)
            ->delete();

        // Flash a success message
        session()->flash('success', 'Favorite removed.');

        // Redirect back to the previous page
        return back();
    }
}
