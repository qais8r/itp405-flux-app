<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $data = $request->validate([
            'body' => 'required|string',
        ]);

        $post->comments()->create([
            'user_id' => auth()->id(),
            'body'    => $data['body'],
        ]);

        session()->flash('success', 'Comment added.');

        return back();
    }

    public function edit(Comment $comment)
    {
        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        $data = $request->validate([
            'body' => 'required|string',
        ]);

        $comment->update(['body' => $data['body']]);

        session()->flash('success', 'Comment updated.');

        return redirect()->route('posts.show', $comment->post_id);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        session()->flash('success', 'Comment deleted.');

        return back();
    }
}