@extends('layouts.app')
@section('title', 'Flux Feed')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Flux Feed</h1>
        <a href="{{ route('posts.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle-fill me-1"></i> Create Post
        </a>
    </div>

    @if ($posts->isEmpty())
        <div class="alert alert-info text-center" role="alert">
            <h4 class="alert-heading">No posts yet!</h4>
            <p>Your feed is empty. Why not <a href="{{ route('posts.create') }}" class="alert-link">create your first
                    post</a>?</p>
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($posts as $post)
                <div class="col">
                    <div class="card h-100 shadow-sm border-light">
                        <a href="{{ route('posts.show', $post) }}">
                            <img src="{{ asset('storage/' . $post->image_path) }}" class="card-img-top"
                                alt="Post image by {{ $post->user->username }}"
                                style="aspect-ratio: 1 / 1; object-fit: cover;">
                        </a>
                        <div class="card-body d-flex flex-column">
                            <p class="card-text mb-2">{{ Str::limit($post->caption, 80) }}</p>
                            <small class="text-muted mb-3">Posted by {{ $post->user->username }}
                                {{ $post->created_at->diffForHumans() }}</small>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye-fill me-1"></i>View
                                </a>
                                @auth {{-- Ensure user is logged in --}}
                                    <div class="d-flex gap-1">
                                        @if ($post->isFavoritedBy(auth()->user()))
                                            {{-- Unfavorite Button --}}
                                            <form action="{{ route('favorites.destroy', $post) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-warning" title="Unfavorite">
                                                    <i class="bi bi-bookmark-fill"></i>
                                                </button>
                                            </form>
                                        @else
                                            {{-- Favorite Button --}}
                                            <form action="{{ route('favorites.store', $post) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-warning" title="Favorite">
                                                    <i class="bi bi-bookmark"></i>
                                                </button>
                                            </form>
                                        @endif

                                        @if (auth()->id() === $post->user_id)
                                            {{-- Edit Button --}}
                                            <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-outline-secondary"
                                                title="Edit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            {{-- Delete Button --}}
                                            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this post?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{-- Optional: Add pagination links if you implement pagination --}}
        {{-- <div class="mt-4">
            {{ $posts->links() }}
        </div> --}}
    @endif
@endsection
