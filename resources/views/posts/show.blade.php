@extends('layouts.app')
@section('title', 'View Post by @' . $post->user->username)

@section('content')
    <div class="row">
        {{-- Post Column --}}
        <div class="col-lg-7 mb-4 mb-lg-0">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center p-3">
                    <h1 class="h5 mb-0">
                        <a href="#" class="text-decoration-none text-dark fw-bold">&#64;{{ $post->user->username }}</a>
                    </h1>
                    <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                </div>
                <img src="{{ asset('storage/' . $post->image_path) }}" class="card-img-top"
                    alt="Post image by {{ $post->user->username }}"
                    style="max-height: 600px; width: 100%; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <p class="card-text mb-0">{{ $post->caption }}</p>
                        <span class="ms-2 text-muted">
                            {{ $post->likes()->count() }}
                            @if ($post->isLikedBy(auth()->user()))
                                <form action="{{ route('likes.destroy', $post) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm border-0 p-0 ms-1">
                                        <i class="bi bi-heart-fill"></i>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('likes.store', $post) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm border-0 p-0 ms-1">
                                        <i class="bi bi-heart"></i>
                                    </button>
                                </form>
                            @endif
                        </span>
                    </div>
                    @auth {{-- Action Buttons --}}
                        <div class="d-flex gap-2 border-top pt-3 mt-auto">
                            @if ($post->isFavoritedBy(auth()->user()))
                                {{-- Unfavorite Button --}}
                                <form action="{{ route('favorites.destroy', $post) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-warning" title="Unfavorite">
                                        <i class="bi bi-bookmark-fill me-1"></i> Favorited
                                    </button>
                                </form>
                            @else
                                {{-- Favorite Button --}}
                                <form action="{{ route('favorites.store', $post) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-warning" title="Favorite">
                                        <i class="bi bi-bookmark me-1"></i> Favorite
                                    </button>
                                </form>
                            @endif

                            @if (auth()->id() === $post->user_id)
                                {{-- Edit Button --}}
                                <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-outline-secondary ms-auto">
                                    <i class="bi bi-pencil-fill me-1"></i> Edit
                                </a>
                                {{-- Delete Button --}}
                                <form action="{{ route('posts.destroy', $post) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this post?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash-fill me-1"></i> Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        {{-- Comments Column --}}
        <div class="col-lg-5">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light p-3">
                    <h3 class="h5 mb-0">Comments ({{ $post->comments->count() }})</h3>
                </div>
                <div class="card-body d-flex flex-column">
                    @auth
                        <!-- Add Comment Form -->
                        <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-4">
                            @csrf
                            <div class="mb-2">
                                <textarea name="body" rows="2" class="form-control @error('body') is-invalid @enderror"
                                    placeholder="Add your comment...">{{ old('body') }}</textarea>
                                @error('body')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="bi bi-send-fill me-1"></i> Submit Comment
                            </button>
                        </form>
                    @else
                        <p class="text-muted">Please <a href="{{ route('login') }}">log in</a> or <a
                                href="{{ route('register') }}">register</a> to comment.</p>
                    @endauth

                    <!-- Display Comments -->
                    <div class="flex-grow-1" style="overflow-y: auto; max-height: 450px;"> {{-- Added wrapper for scrollable comments --}}
                        @if ($post->comments->isEmpty())
                            <p class="text-muted text-center mt-3">No comments yet. Be the first!</p>
                        @else
                            <ul class="list-unstyled mb-0">
                                @foreach ($post->comments->sortByDesc('created_at') as $index => $comment)
                                    <li class="{{ $index > 0 ? 'mt-3 pt-3 border-top' : '' }}">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <strong>
                                                    <a href="#"
                                                        class="text-decoration-none text-dark">&#64;{{ $comment->user->username }}</a>
                                                </strong>
                                                <p class="mb-1">{{ $comment->body }}</p>
                                                <small
                                                    class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                            </div>
                                            @auth
                                                @if (auth()->id() === $comment->user_id)
                                                    <div class="d-flex gap-1 flex-shrink-0 ms-2">
                                                        {{-- Edit Button --}}
                                                        <a href="{{ route('comments.edit', $comment) }}"
                                                            class="btn btn-sm btn-outline-secondary" title="Edit">
                                                            <i class="bi bi-pencil-fill"></i>
                                                        </a>
                                                        {{-- Delete Button --}}
                                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST"
                                                            class="d-inline"
                                                            onsubmit="return confirm('Are you sure you want to delete this post?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                title="Delete">
                                                                <i class="bi bi-trash-fill"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            @endauth
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
