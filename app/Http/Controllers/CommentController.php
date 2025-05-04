<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        // Validate the request data
        $data = $request->validate([
            'body' => 'required|string',
        ]);

        // Create a new comment for the authenticated user
        $post->comments()->create([
            'user_id' => auth()->id(),
            'body'    => $data['body'],
        ]);

        // Flash a success message
        session()->flash('success', 'Comment added.');

        // Redirect back to the previous page
        return back();
    }

    public function edit(Comment $comment)
    {
        // Show the edit form for the comment
        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        // Validate the request data
        $data = $request->validate([
            'body' => 'required|string',
        ]);

        // Update the comment
        $comment->update(['body' => $data['body']]);

        // Flash a success message
        session()->flash('success', 'Comment updated.');

        // Redirect back to the previous page
        return redirect()->route('posts.show', $comment->post_id);
    }

    public function destroy(Comment $comment)
    {
        // Delete the comment
        $comment->delete();

        // Flash a success message
        session()->flash('success', 'Comment deleted.');

        // Redirect back to the previous page
        return back();
    }
}