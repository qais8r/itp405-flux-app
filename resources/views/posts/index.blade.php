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
                            <img src="{{ asset('storage/' . $post->image_path) }}" class="card-img-top" alt="Post image" style="aspect-ratio: 1 / 1; object-fit: cover;">
                            <div class="card-body">
                                <p class="card-text">{{ Str::limit($post->caption, 100) }}</p>
                                <a href="{{ route('posts.show', $post) }}" class="btn btn-primary">View</a>
                                @if (auth()->id() === $post->user_id)
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this post?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
