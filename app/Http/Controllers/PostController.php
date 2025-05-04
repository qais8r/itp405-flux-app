<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        // Retrieve the authenticated user and their posts
        $user = auth()->user();

        // Retrieve all posts with their associated user and comments
        $posts = Post::latest()
            ->with(['user', 'comments'])
            ->get();

        // Pass the user and posts to the view
        return view('posts.index', compact('user', 'posts'));
    }

    public function create()
    {
        // Show the create post form
        return view('posts.create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $data = $request->validate([
            'image'   => 'required|image',
            'caption' => 'nullable|string|max:255',
        ]);

        // Store the image in the storage directory
        $path = $request->file('image')->store('posts', 'public');

        // Create a new post
        $post = Post::create([
            'user_id'    => auth()->id(),
            'image_path' => $path,
            'caption'    => $data['caption'] ?? null,
        ]);

        // Flash a success message
        session()->flash('success', 'Post created successfully.');

        // Redirect to the post details page
        return redirect()->route('posts.show', $post);
    }

    public function show(Post $post)
    {
        // Load the user and comments relationships
        $post->load(['user', 'comments.user']);

        // Pass the post to the view
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        // Pass the post to the view
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        // Validate the request data
        $data = $request->validate([
            'image'   => 'nullable|image',
            'caption' => 'nullable|string|max:255',
        ]);

        // Update the post
        if ($request->hasFile('image')) {
            // Delete the old image file from storage
            Storage::disk('public')->delete($post->image_path);
            // Store the new image file in storage
            $post->image_path = $request->file('image')->store('posts', 'public');
        }

        // Update the post
        $post->caption = $data['caption'] ?? $post->caption;
        $post->save();

        // Flash a success message
        session()->flash('success', 'Post updated successfully.');

        // Redirect to the post details page
        return redirect()->route('posts.show', $post);
    }

    public function destroy(Post $post)
    {
        // Delete the image file from storage first
        Storage::disk('public')->delete($post->image_path);
        
        // Then delete the post record
        $post->delete();

        // Flash a success message
        session()->flash('success', 'Post deleted successfully.');

        // Redirect to the posts index page
        return redirect()->route('posts.index');
    }
}