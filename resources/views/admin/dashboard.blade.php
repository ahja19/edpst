@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="admin-topbar">
    <h1>Dashboard</h1>
    <span style="font-size:13px; color:#777;">Selamat datang, Admin EDPstore</span>
</div>

<div class="stat-grid">
    <div class="stat-card">
        <div class="num">{{ $totalProducts }}</div>
        <div class="lbl">Total Produk</div>
    </div>
    <div class="stat-card">
        <div class="num">{{ $totalOrders }}</div>
        <div class="lbl">Total Pesanan</div>
    </div>
    <div class="stat-card">
        <div class="num">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        <div class="lbl">Total Pendapatan</div>
        @if(auth()->user()->isSuperAdmin())
        <form method="POST" action="{{ route('admin.revenue.reset') }}" onsubmit="return confirm('Yakin ingin mereset pendapatan menjadi Rp 0?');" style="margin-top:10px;">
            @csrf
            <button type="submit" class="btn btn-sm" style="border:1px solid #ddd; background:#fff; color:#111;">Reset Pendapatan</button>
        </form>
        @endif
    </div>
    <div class="stat-card">
        <a href="{{ route('admin.users.index') }}" style="text-decoration:none; color:inherit;">
            <div class="num">{{ $totalUsers }}</div>
            <div class="lbl">Total Pengguna</div>
        </a>
    </div>
</div>

@if($pendingOrders > 0)
    <div class="admin-card" style="background:#fafafa;">
        <strong>{{ $pendingOrders }}</strong> pesanan menunggu diproses. <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" style="text-decoration:underline;">Lihat</a>
    </div>
@endif

<div class="page-head">
    <h1>Pesanan Terbaru</h1>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm">Semua Pesanan</a>
</div>

<table class="admin-table">
    <thead>
        <tr>
            <th>No. Pesanan</th>
            <th>Pemesan</th>
            <th>Total</th>
            <th>Status</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @forelse($recentOrders as $order)
            <tr>
                <td><a href="{{ route('admin.orders.show', $order->id) }}" style="text-decoration:underline;">{{ $order->order_number }}</a></td>
                <td>{{ $order->customer_name }}</td>
                <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                <td><span class="order-status status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                <td>{{ $order->created_at->format('d M Y H:i') }}</td>
            </tr>
        @empty
            <tr><td colspan="5" style="text-align:center; color:#999; padding:30px;">Belum ada pesanan.</td></tr>
        @endforelse
    </tbody>
</table>

@endsection