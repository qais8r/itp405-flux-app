<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') • Flux</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    {{-- Custom CSS for Flash Message --}}
    <style>
        /* Add padding to prevent content from hiding behind fixed navbar */
        body {
            padding-top: 4.5rem;
        }

        /* Define animation for progress bar */
        @keyframes progressBarShrink {
            from {
                width: 100%;
            }

            to {
                width: 0%;
            }
        }

        /* Style for flash message */
        #flash-message {
            position: fixed;
            bottom: 25px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1050;
            min-width: 300px;
            max-width: 90%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            background-color: var(--bs-success-bg-subtle);
            color: var(--bs-success-text-emphasis);
            border: 1px solid var(--bs-success-border-subtle);
            border-radius: var(--bs-alert-border-radius);
            opacity: 1;
            transition: opacity 0.5s ease-out;
            overflow: hidden;
            padding-bottom: 20px;
            /* Add padding for the progress bar */
        }

        /* Progress bar using ::after pseudo-element */
        #flash-message::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            height: 5px;
            /* Height of the progress bar */
            width: 100%;
            /* Starts full width */
            background-color: var(--bs-success);
            /* Darker success color for the bar */
            /* Apply the animation */
            animation: progressBarShrink 5s linear forwards;
            /* 5s duration, linear timing */
        }

        /* Fade out effect */
        #flash-message.fade-out {
            opacity: 0;
        }

        /* Style for close button */
        #flash-message .btn-close {
            filter: none;
            color: var(--bs-success-text-emphasis);
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top border">
        <div class="container">
            <a class="navbar-brand" href="{{ route('posts.index') }}">Flux</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('posts.index') }}">Posts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('favorites.index') }}">Favorites</a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-4 flex-grow-1">
        @yield('content')
    </main>

    <footer class="text-center py-3 mt-4 bg-light">
        © {{ date('Y') }} Flux. All rights reserved.
    </footer>

    {{-- Flash message --}}
    @if (session('success'))
        <div id="flash-message" class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- JavaScript for Auto-Dismiss --}}
    <script>
        const flashMessage = document.getElementById('flash-message');

        if (flashMessage) {
            // Wait 5 seconds (5000 milliseconds) before starting fade out
            setTimeout(() => {
                flashMessage.classList.add('fade-out');
            }, 5000);

            // Wait for fade out transition to finish (0.5s) then remove element
            setTimeout(() => {
                if (flashMessage.parentElement) { // Check if it hasn't been manually closed
                    flashMessage.remove();
                }
            }, 5500); // 5000ms delay + 500ms transition
        }
    </script>

</body>

</html>
