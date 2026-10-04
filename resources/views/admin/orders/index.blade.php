@extends('layouts.admin')

@section('title', 'Pesanan')

@section('content')

<div class="page-head">
    <h1>Kelola Pesanan</h1>
</div>

<form method="GET" action="{{ route('admin.orders.index') }}" style="display:flex; gap:10px; margin-bottom:20px;">
    <select name="status" class="form-select" style="max-width:220px;">
        <option value="">Semua Status</option>
        @foreach(['pending', 'confirmed', 'shipped', 'completed', 'cancelled'] as $st)
            <option value="{{ $st }}" {{ request('status') === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-sm">Filter</button>
</form>

<table class="admin-table">
    <thead>
        <tr>
            <th>No. Pesanan</th>
            <th>Pemesan</th>
            <th>Total</th>
            <th>Status</th>
            <th>Pembayaran</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($orders as $order)
            <tr>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->customer_name }}<br><small style="color:#999;">{{ $order->phone }}</small></td>
                <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                <td><span class="order-status status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                <td><span class="order-status status-{{ $order->payment_status_css }}">{{ $order->payment_status_label }}</span></td>
                <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                <td><a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm">Detail</a></td>
            </tr>
        @empty
            <tr><td colspan="7" style="text-align:center; color:#999; padding:30px;">Belum ada pesanan.</td></tr>
        @endforelse
    </tbody>
</table>

<div style="margin-top:24px;">{{ $orders->links() }}</div>

@endsection