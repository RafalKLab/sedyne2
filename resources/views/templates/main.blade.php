<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap 5 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/main.css') }}">
    @yield('styles')
</head>
<body>

{{-- Sidebar --}}
<nav class="sidebar d-flex flex-column flex-shrink-0 p-3 text-white bg-dark">
    {{-- Logo / App name --}}
    <div class="mb-4 text-center">
        <a href="{{ url('/') }}" class="text-white text-decoration-none">
            <h4 class="mb-0 fw-bold">Sedyne</h4>
        </a>
    </div>

    {{-- Mobile toggle --}}
    <div class="d-md-none mb-3">
        <button class="btn btn-outline-light w-100" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
            ☰ Menu
        </button>
    </div>

    {{-- Navigation --}}
    <div class="collapse d-md-block" id="sidebarMenu">
        @auth
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item mb-1">
                    <a href="{{ route('dashboard') }}"
                       class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="{{ route('spaces') }}"
                       class="nav-link {{ request()->routeIs('spaces') ? 'active' : '' }}">
                        Spaces
                    </a>
                </li>
{{--                <li>--}}
{{--                    <a href="{{ route('seats.index') }}"--}}
{{--                       class="nav-link {{ request()->routeIs('seats.*') ? 'active' : '' }}">--}}
{{--                        Reserve a Seat--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li>--}}
{{--                    <a href="{{ route('reservations.index') }}"--}}
{{--                       class="nav-link {{ request()->routeIs('reservations.*') ? 'active' : '' }}">--}}
{{--                        My Reservations--}}
{{--                    </a>--}}
{{--                </li>--}}
                <li>
                    <a href="{{ route('profile.edit') }}"
                       class="nav-link mb-1 {{ request()->routeIs('profile') ? 'active' : '' }}">
                        Profile
                    </a>
                </li>
            </ul>

            {{-- Logout --}}
            <hr>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-light w-100">Logout</button>
            </form>
        @else
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="nav-link">Login</a>
                </li>
                <li>
                    <a href="{{ route('register') }}" class="nav-link">Register</a>
                </li>
            </ul>
        @endauth
    </div>
</nav>

{{-- Main Content --}}
<div class="main-content">
    <div class="container-fluid">
        @yield('content')
{{--        <h2>Office Seat Reservation</h2>--}}

{{--        --}}{{-- Example seat blocks --}}
{{--        <div class="row g-3 mt-4">--}}
{{--            @for ($i = 1; $i <= 12; $i++)--}}
{{--                <div class="col-md-3">--}}
{{--                    <div class="card text-center">--}}
{{--                        <div class="card-body">--}}
{{--                            <h5 class="card-title">Seat #{{ $i }}</h5>--}}
{{--                            <p class="card-text text-success">Available</p>--}}
{{--                            <a href="#" class="btn btn-primary btn-sm">Reserve</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endfor--}}
{{--        </div>--}}
    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
