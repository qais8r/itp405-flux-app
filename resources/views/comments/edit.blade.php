@extends('layouts.app')
@section('title', 'Edit Comment')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-light p-3">
                    <h1 class="mb-0 h4">Edit Comment</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('comments.update', $comment) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="body" class="form-label visually-hidden">Comment Body</label> {{-- Hide label visually but keep for accessibility --}}
                            <textarea name="body" id="body" rows="3" class="form-control @error('body') is-invalid @enderror" placeholder="Update your comment...">{{ old('body', $comment->body) }}</textarea>
                            @error('body')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-check-circle-fill me-2"></i>Update Comment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
