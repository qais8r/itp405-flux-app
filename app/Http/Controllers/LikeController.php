<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Post $post)
    {
        // Create a new like for the authenticated user
        $post->likes()->create([
            'user_id' => auth()->id()
        ]);

        // Redirect back with a success message
        return back()->with('success', 'Post liked successfully.');
    }

    public function destroy(Post $post)
    {
        // Delete the like for the authenticated user
        $post->likes()->where('user_id', auth()->id())->delete();

        // Redirect back with a success message
        return back()->with('success', 'Post unliked successfully.');
    }
}