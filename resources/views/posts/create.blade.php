@extends('layouts.app')
@section('title', 'Create Post')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-light p-3">
                    <h1 class="mb-0 h4">Create New Post</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="image" class="form-label">Upload Image*</label>
                            <input type="file" name="image" id="image"
                                class="form-control @error('image') is-invalid @enderror" required>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="caption" class="form-label">Caption</label>
                            <textarea name="caption" id="caption" rows="4" class="form-control @error('caption') is-invalid @enderror"
                                placeholder="Write a caption...">{{ old('caption') }}</textarea>
                            @error('caption')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-cloud-upload-fill me-2"></i>Post
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
