@extends('layouts.app')
@section('title', 'Register')

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-6"> {{-- Adjusted column width for more fields --}}
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h1 class="card-title text-center mb-4">Create Your Account</h1>
                    <p class="text-center text-muted mb-4">Join Flux today!</p>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control form-control-lg"
                                value="{{ old('name') }}" placeholder="Your Full Name">
                            @error('name')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" id="username" class="form-control form-control-lg"
                                value="{{ old('username') }}" placeholder="Choose a unique username">
                            @error('username')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" name="email" id="email" class="form-control form-control-lg"
                                value="{{ old('email') }}" placeholder="you@example.com">
                            @error('email')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control form-control-lg"
                                placeholder="Create a strong password">
                            @error('password')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control form-control-lg" placeholder="Confirm your password">
                        </div>
                        <div class="d-grid gap-2 my-4">
                            <button type="submit" class="btn btn-success btn-lg">Register</button> {{-- Changed button color to success --}}
                        </div>
                    </form>
                    <hr class="my-4">
                    <p class="text-center">Already have an account? <a href="{{ route('login') }}">Login here.</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection
