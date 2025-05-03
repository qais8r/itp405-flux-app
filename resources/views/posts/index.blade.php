@extends('layouts.app')
@section('title', 'All Posts')

@section('content')
    <div class="bg-white text-dark p-4 rounded">
        <a href="{{ route('posts.create') }}" class="btn btn-primary float-end">Create</a>
        <h1 class="mb-4">All Posts</h1>
        <div class="row">
            @if ($posts->isEmpty())
                <p>You haven't created any posts. <a href="{{ route('posts.create') }}">Create one now</a>.</p>
            @else
                @foreach ($posts as $post)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="{{ asset('storage/' . $post->image_path) }}" class="card-img-top" alt="Post image"
                                style="aspect-ratio: 1 / 1; object-fit: cover;">
                            <div class="card-body">
                                <p class="card-text">{{ Str::limit($post->caption, 100) }}</p>
                                <a href="{{ route('posts.show', $post) }}" class="btn btn-primary">View</a>
                                @auth {{-- Ensure user is logged in --}}
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
                                        <a href="{{ route('posts.edit', $post) }}"
                                            class="btn btn-outline-secondary ms-1">Edit</a>
                                        {{-- Delete Button --}}
                                        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline ms-1"
                                            onsubmit="return confirm('Are you sure you want to delete this post?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-outline-danger">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
