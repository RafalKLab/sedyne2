@extends('templates.main')

@section('title')
    Login
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/auth.css') }}">
@endsection

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card shadow-sm p-4 auth-card">
            <h3 class="text-center mb-4">Welcome to Sedyne</h3>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                    >
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        required
                        autocomplete="current-password"
                    >
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                    <label class="form-check-label" for="remember_me">Remember me</label>
                </div>

                {{-- Buttons --}}
                <div class="d-flex justify-content-between align-items-center">
                    @if (Route::has('password.request'))
                        <a class="small text-decoration-none" href="{{ route('password.request') }}">
                            Forgot password?
                        </a>
                    @endif

                    <button type="submit" class="btn btn-primary px-4">
                        Log in
                    </button>
                </div>
            </form>

            {{-- Optional: Register link --}}
            <div class="mt-3 text-center">
                <small>Don't have an account? <a href="{{ route('register') }}">Register</a></small>
            </div>
        </div>
    </div>
@endsection
