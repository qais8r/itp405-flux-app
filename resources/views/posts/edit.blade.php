@extends('layouts.app')
@section('title', 'Edit Post')

@section('content')
    <div class="bg-white text-dark p-4 rounded">
        <h1 class="mb-4">Edit Post</h1>
        <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Current Image</label>
                <div><img src="{{ asset('storage/' . $post->image_path) }}" class="img-thumbnail" alt=""></div>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">New Image (optional)</label>
                <input type="file" name="image" id="image" class="form-control">
                @error('image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="caption" class="form-label">Caption</label>
                <textarea name="caption" id="caption" rows="3" class="form-control">{{ old('caption', $post->caption) }}</textarea>
                @error('caption')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
