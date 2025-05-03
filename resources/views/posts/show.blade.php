@extends('layouts.app')
@section('title', 'View Post')

@section('content')
        <h1 class="mb-4">&#64;{{ $post->user->username }} • Post</h1>
        @auth {{-- Ensure user is logged in --}}
            <div class="mb-3">
                @if ($post->isFavoritedBy(auth()->user()))
                    {{-- Unfavorite Button --}}
                    <form action="{{ route('favorites.destroy', $post) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-warning" title="Unfavorite">
                            <i class="bi bi-bookmark-fill"></i> Favorited
                        </button>
                    </form>
                @else
                    {{-- Favorite Button --}}
                    <form action="{{ route('favorites.store', $post) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-warning" title="Favorite">
                            <i class="bi bi-bookmark"></i> Favorite
                        </button>
                    </form>
                @endif

                @if (auth()->id() === $post->user_id)
                    {{-- Edit Button --}}
                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-outline-secondary ms-1">Edit</a>
                    {{-- Delete Button --}}
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline ms-1"
                        onsubmit="return confirm('Are you sure you want to delete this post?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">
                            <i class="bi bi-trash"></i> Delete Post
                        </button>
                    </form>
                @endif
            </div>
        @endauth
        <div class="mb-4">
            <img src="{{ asset('storage/' . $post->image_path) }}" class="img-fluid rounded"
                alt="&#64;{{ $post->user->username }} image">
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
@endsection
