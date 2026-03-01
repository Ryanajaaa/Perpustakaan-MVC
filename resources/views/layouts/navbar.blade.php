<style>
    body {
        background-color: #f8f9fa; /* light mode */
    }

    .main-content {
        padding: 30px 0;
    }
</style>

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">

        <a class="navbar-brand fw-bold" href="#">
            📚 Perpustakaan
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">

            {{-- Menu --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('books.*') ? 'active fw-semibold' : '' }}"
                       href="{{ route('books.index') }}">
                        Buku
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('transactions.*') ? 'active fw-semibold' : '' }}"
                       href="{{ route('transactions.index') }}">
                        Transaksi
                    </a>
                </li>

                @if (Auth::user()->role == 'admin')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('users.*') ? 'active fw-semibold' : '' }}"
                           href="{{ route('users.index') }}">
                            Kelola Anggota
                        </a>
                    </li>
                @endif

            </ul>

            {{-- User Info --}}
            <ul class="navbar-nav ms-auto align-items-lg-center">

                <li class="nav-item me-3  small">
                    <div class="fw-semibold text-light">
                        {{ Auth::user()->name }}
                    </div>
                    <div class="fw-semibold text-dark"><p class="text-light">
                        {{ Auth::user()->role == 'admin'
                            ? 'Administrator'
                            : Auth::user()->major . ' - ' . Auth::user()->class }}</p>
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