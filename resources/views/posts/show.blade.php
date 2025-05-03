@extends('layouts.app')
@section('title', 'View Post')

@section('content')
    <div class="bg-white text-dark p-4 rounded">
        <h1 class="mb-4">&#64;{{ $post->user->username }} • Post</h1>
        <div class="mb-4">
            <img src="{{ asset('storage/' . $post->image_path) }}" class="img-fluid rounded" alt="Post image">
        </div>
        <p>{{ $post->caption }}</p>
        <p class="text-muted">Posted {{ $post->created_at->diffForHumans() }}</p>

        <hr>

        <!-- Comments -->
        <h3 class="mt-4">Comments</h3>
        @if ($post->comments->isEmpty())
            <p>No comments yet. Be the first to comment!</p>
        @else
            @foreach ($post->comments as $comment)
                <div class="mb-3">
                    <strong>{{ $comment->user->username }}</strong> <span
                        class="text-muted">{{ $comment->created_at->diffForHumans() }}</span>
                    <p>{{ $comment->body }}</p>
                    @if (auth()->id() === $comment->user_id)
                        <a href="{{ route('comments.edit', $comment) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    @endif
                </div>
            @endforeach
        @endif

        <hr>

        <!-- Add Comment -->
        <h4>Add a Comment</h4>
        <form action="{{ route('comments.store', $post) }}" method="POST">
            @csrf
            <div class="mb-3">
                <textarea name="body" rows="2" class="form-control">{{ old('body') }}</textarea>
                @error('body')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button class="btn btn-primary">Submit Comment</button>
        </form>
    </div>
@endsection
