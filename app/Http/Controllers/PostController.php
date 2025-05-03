<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()
            ->with(['user', 'comments'])
            ->get();

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'image'   => 'required|image',
            'caption' => 'nullable|string|max:255',
        ]);

        $path = $request->file('image')->store('posts', 'public');

        $post = Post::create([
            'user_id'    => auth()->id(),
            'image_path' => $path,
            'caption'    => $data['caption'] ?? null,
        ]);

        session()->flash('success', 'Post created successfully.');

        return redirect()->route('posts.show', $post);
    }

    public function show(Post $post)
    {
        $post->load(['user', 'comments.user']);

        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'image'   => 'nullable|image',
            'caption' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($post->image_path);

            $post->image_path = $request->file('image')->store('posts', 'public');
        }

        $post->caption = $data['caption'] ?? $post->caption;
        $post->save();

        session()->flash('success', 'Post updated successfully.');

        return redirect()->route('posts.show', $post);
    }

    public function destroy(Post $post)
    {
        // Delete the image file from storage first
        Storage::disk('public')->delete($post->image_path);
        
        // Then delete the post record
        $post->delete();

        session()->flash('success', 'Post deleted successfully.');

        return redirect()->route('posts.index');
    }
}