<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Perpustakaan</title>

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Optional Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #e0eafc, #cfdef3);
            color: #f8f9fa; /* Teks terang untuk kontras */
        }

        .navbar {
            background: linear-gradient(135deg, #3F5EFB, #4f46e5); /* Navbar gelap */
        }

        .navbar-brand {
            font-weight: 600;
            color: #ff4d4f !important; /* Accent merah terang */
        }

        .navbar .nav-link {
            color: #f8f9fa;
        }

        .navbar .nav-link.active {
            font-weight: 600;
            color: #ff4d4f;
        }

        .main-content {
            padding: 30px 0;
        }

        .btn-outline-danger {
            border-color: #ff4d4f;
            color: #ff4d4f;
        }

        .btn-outline-danger:hover {
            background-color: #ff4d4f;
            color: #1e0b0b;
        }
    </style>
</head>
<body>

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
    <div class="container">

        <a class="navbar-brand" href="{{ route('books.index') }}">
            📚 Perpustakaan
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">

            {{-- Left Menu --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('books.*') ? 'active' : '' }}"
                       href="{{ route('books.index') }}">
                       Data Buku
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}"
                       href="{{ route('transactions.index') }}">
                        Transaksi
                    </a>
                </li>

                @auth
                    @if (Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"
                               href="{{ route('users.index') }}">
                                Kelola Anggota
                            </a>
                        </li>
                    @endif
                @endauth

            </ul>

            {{-- Right Menu --}}
            <ul class="navbar-nav ms-auto align-items-lg-center">

                @auth
                    <li class="nav-item me-3 text-end">
                        <div class="fw-semibold text-light">
                            {{ Auth::user()->name }}
                        </div>
                        <div class="small">
                            {{ Auth::user()->role == 'admin'
                                ? 'Administrator'
                                : Auth::user()->major . ' - ' . Auth::user()->class }}
                        </div>
                    </li>

                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                Logout
                            </button>
                        </form>
                    </li>
                @endauth

            </ul>

        </div>
    </div>
</nav>

{{-- Content --}}
<div class="main-content">
    <div class="container">
        @yield('content')
    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>