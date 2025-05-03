@extends('layouts.app')
@section('title', 'All Posts')

@section('content')
    <div class="bg-white text-dark p-4 rounded">
        <h1 class="mb-4">All Posts</h1>
        @if ($posts->isEmpty())
            <p>You haven't created any posts. <a href="{{ route('posts.create') }}">Create one now</a>.</p>
        @else
            <div class="row">
                @foreach ($posts as $post)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="{{ asset('storage/' . $post->image_path) }}" class="card-img-top" alt="Post image">
                            <div class="card-body">
                                <p class="card-text">{{ Str::limit($post->caption, 100) }}</p>
                                <a href="{{ route('posts.show', $post) }}" class="btn btn-primary">View</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
