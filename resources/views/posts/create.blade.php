@extends('layouts.app')
@section('title', 'Create Post')

@section('content')
    <div class="bg-white text-dark p-4 rounded">
        <h1 class="mb-4">Create New Post</h1>
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" name="image" id="image" class="form-control">
                @error('image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="caption" class="form-label">Caption</label>
                <textarea name="caption" id="caption" rows="3" class="form-control">{{ old('caption') }}</textarea>
                @error('caption')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button class="btn btn-success">Post</button>
        </form>
    </div>
@endsection
