<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin — @yield('title', 'Dashboard') | EDPstore</title>
    <link rel="stylesheet" href="{{ secure_asset('css/edpstore.css') }}">
    @stack('styles')
</head>
<body class="admin-body">

<div class="admin-wrap">
    <aside class="admin-sidebar">
        <div class="admin-brand">EDPstore</div>
        <nav>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">Produk</a>
            <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">Pesanan</a>
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Pengguna</a>
            @if(auth()->user()->isSuperAdmin())
            <a href="{{ route('admin.payment.edit') }}" class="{{ request()->routeIs('admin.payment.*') ? 'active' : '' }}">Pembayaran</a>
            @endif
            <div style="border-top:1px solid rgba(255,255,255,.15); margin-top:14px; padding-top:6px;">
                <a href="{{ route('shop.index') }}" style="display:block; font-size:12.5px; letter-spacing:1.5px; text-transform:uppercase; color:rgba(255,255,255,.7); padding:12px 16px;">Lihat Toko</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" style="background:none; border:none; color:rgba(255,255,255,.7); font-size:12.5px; letter-spacing:1.5px; text-transform:uppercase; cursor:pointer; width:100%; text-align:left; padding:12px 16px;">Keluar</button>
                </form>
            </div>
        </nav>
    </aside>

    <main class="admin-main">
        @if(session('success'))
            <div class="flash flash-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="flash flash-error">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="flash flash-error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @yield('content')
    </main>
</div>

@stack('scripts')
</body>
</html>