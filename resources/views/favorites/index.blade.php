@extends('layouts.app')
@section('title', 'Your Favorites')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Your Favorite Posts</h1>
        {{-- Optional: Add a button or link back if needed --}}
    </div>

    @if ($favorites->isEmpty())
        <div class="alert alert-warning text-center shadow-sm" role="alert">
            <h4 class="alert-heading py-3">😔 Nothing here yet...</h4>
            <p>You haven't favorited any posts. Why not <a href="{{ route('posts.index') }}" class="alert-link">browse the
                    feed</a> and find some you like?</p>
        </div>
    @else
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach ($favorites as $post)
                <div class="col">
                    <div class="card h-100 shadow-sm border-light">
                        <a href="{{ route('posts.show', $post) }}">
                            <img src="{{ asset('storage/' . $post->image_path) }}" class="card-img-top"
                                alt="Post image by {{ $post->user->username }}"
                                style="aspect-ratio: 1 / 1; object-fit: cover;">
                        </a>
                        <div class="card-body d-flex flex-column">
                            <p class="card-text mb-2">{{ Str::limit($post->caption, 80) }}</p>
                            <div class="text-muted small mb-3">
                                <div><i class="bi bi-person"></i> Posted by {{ $post->user->username }}</div>
                                <div><i class="bi bi-clock"></i> Posted {{ $post->created_at->diffForHumans() }}</div>
                                <div><i class="bi bi-bookmark-heart"></i> Favorited {{ $post->pivot->created_at->diffForHumans() }}</div>
                            </div>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye-fill me-1"></i> View
                                </a>
                                {{-- Unfavorite Button --}}
                                <form action="{{ route('favorites.destroy', $post) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-warning" title="Unfavorite">
                                        <i class="bi bi-bookmark-x-fill"></i> Unfavorite
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
