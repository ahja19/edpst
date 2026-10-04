<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'EDPstore')</title>
    <link rel="stylesheet" href="{{ asset('css/edpstore.css') }}">
    @stack('styles')
</head>
<body>

<header class="site-header">
    <div class="container nav-bar">
        <a href="{{ route('home') }}" class="brand">EDP<em>store</em></a>
        <nav class="nav-links">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
            <a href="{{ route('shop.index') }}" class="{{ request()->routeIs('shop.*') ? 'active' : '' }}">Koleksi</a>
            @auth
                <a href="{{ route('orders.index') }}" class="{{ request()->routeIs('orders.*') ? 'active' : '' }}">Pesanan Saya</a>
            @endauth
        </nav>
        <div class="nav-actions">
            @auth
                @php $cartCount = auth()->user()->cart()->whereHas('product')->sum('quantity'); @endphp
                <a href="{{ route('cart.index') }}" class="cart-link" title="Keranjang">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                    @if($cartCount > 0)
                        <span class="cart-count">{{ $cartCount }}</span>
                    @endif
                </a>
                <form method="POST" action="{{ route('logout') }}" class="nav-actions" style="gap:0">
                    @csrf
                    <button type="submit" class="btn btn-sm">Keluar</button>
                </form>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-dark">Admin</a>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn btn-sm">Masuk</a>
                <a href="{{ route('register') }}" class="btn btn-sm btn-dark">Daftar</a>
            @endauth
        </div>
    </div>
</header>

<main>
    @if(session('success'))
        <div class="container" style="margin-top:24px"><div class="flash flash-success">{{ session('success') }}</div></div>
    @endif
    @if(session('error'))
        <div class="container" style="margin-top:24px"><div class="flash flash-error">{{ session('error') }}</div></div>
    @endif

    @yield('content')
</main>

<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <h4>EDPstore</h4>
                <p>Koleksi parfum pilihan dengan aroma yang abadi. Elegansi dalam setiap semprotan.</p>
            </div>
            <div>
                <h4>Navigasi</h4>
                <a href="{{ route('home') }}">Beranda</a>
                <a href="{{ route('shop.index') }}">Koleksi</a>
                @auth
                    <a href="{{ route('orders.index') }}">Pesanan Saya</a>
                @endauth
            </div>
            <div>
                <h4>Kontak</h4>
                <p>Jl. Manggis 2 no 2</p>
                <p>+62 838-9651-7522</p>
                <p>koomerlon@gmail.com</p>
            </div>
        </div>
        <div class="footer-bottom">&copy; {{ date('Y') }} EDPstore. All rights reserved.</div>
    </div>
</footer>

@stack('scripts')
</body>
</html>