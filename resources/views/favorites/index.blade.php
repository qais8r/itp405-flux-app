@extends('layouts.app')
@section('title', 'Your Favorites')

@section('content')
    <div class="bg-white text-dark p-4 rounded">
        <h1 class="mb-4">Your Favorite Posts</h1>
        @if ($favorites->isEmpty())
            <p>You haven't favorited any posts yet. <a href="{{ route('posts.index') }}">Browse posts</a>.</p>
        @else
            <div class="row">
                @foreach ($favorites as $post)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="{{ asset('storage/' . $post->image_path) }}" class="card-img-top" alt="Post image">
                            <div class="card-body">
                                <p class="card-text">{{ Str::limit($post->caption, 100) }}</p>
                                <a href="{{ route('posts.show', $post) }}" class="btn btn-primary">View</a>
                                <form action="{{ route('favorites.destroy', $post) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger">Remove</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
