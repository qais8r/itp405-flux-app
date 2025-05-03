@extends('layouts.app')
@section('title', 'Edit Comment')

@section('content')
    <h1 class="mb-4">Edit Comment</h1>
    <form action="{{ route('comments.update', $comment) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <textarea name="body" rows="3" class="form-control">{{ old('body', $comment->body) }}</textarea>
            @error('body')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button class="btn btn-primary">Update Comment</button>
    </form>
@endsection
