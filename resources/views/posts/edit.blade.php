@extends('layouts.app')
@section('title', 'Edit Post')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-light p-3">
                    <h1 class="mb-0 h4">Edit Post</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4 text-center">
                            <label class="form-label d-block">Current Image</label>
                            <img src="{{ asset('storage/' . $post->image_path) }}" class="img-thumbnail mb-2"
                                alt="Current post image" style="max-height: 300px; max-width: 100%;">
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label">Upload New Image (Optional)</label>
                            <input type="file" name="image" id="image"
                                class="form-control @error('image') is-invalid @enderror">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="caption" class="form-label">Caption</label>
                            <textarea name="caption" id="caption" rows="4" class="form-control @error('caption') is-invalid @enderror"
                                placeholder="Update your caption...">{{ old('caption', $post->caption) }}</textarea>
                            @error('caption')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-check-circle-fill me-2"></i>Update Post
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
