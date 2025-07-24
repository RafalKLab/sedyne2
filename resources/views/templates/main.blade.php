<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap 5 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>


    <link rel="stylesheet" href="{{ asset('assets/main.css') }}">
    @yield('styles')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    <a href="{{ route('reservation.create') }}" class="btn btn-primary w-100 rounded-pill fw-bold">
                        Reserve
                    </a>
                </li>
                <hr>

                <li class="nav-item mb-1">
                    <a href="{{ route('reservation.index') }}"
                       class="nav-link {{ request()->routeIs('reservation.index') ? 'active' : '' }}">
                        My Reservations
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="{{ route('spaces') }}"
                       class="nav-link {{ request()->routeIs('spaces') ? 'active' : '' }}">
                        Spaces
                    </a>
                </li>
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
    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
{{-- Alerts --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if (session('success'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            showClass: {
                popup: 'swal2-show animate__animated animate__fadeInLeft'
            },
            hideClass: {
                popup: 'swal2-hide animate__animated animate__fadeOut'
            }
        });
        @endif

        @if (session('danger'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: '{{ session('danger') }}',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            showClass: {
                popup: 'swal2-show animate__animated animate__fadeInLeft'
            },
            hideClass: {
                popup: 'swal2-hide animate__animated animate__fadeOut'
            }
        });
        @endif
    });
</script>

@yield('scripts')
</body>
</html>
