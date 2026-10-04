@extends('layouts.app')

@section('title', 'Pembayaran — EDPstore')

@section('content')

<section class="section container">
    <div class="section-header">
        <h2>Pembayaran</h2>
        <a href="{{ route('orders.show', $order->id) }}" class="link">Detail Pesanan</a>
    </div>

    <div class="flash flash-success">Pesanan Anda berhasil dibuat. Silakan selesaikan pembayaran pada halaman ini.</div>

    <div class="order-card">
        <div class="order-top">
            <div>
                <div class="order-number">{{ $order->order_number }}</div>
                <div style="font-size:13px; color:#777;">{{ $order->created_at->format('d M Y, H:i') }}</div>
            </div>
            <div style="text-align:right;">
                <span class="order-status status-{{ $order->payment_status_css }}">{{ $order->payment_status_label }}</span>
                <div style="font-weight:700; margin-top:8px;">{{ $order->total_formatted }}</div>
            </div>
        </div>
        @foreach($order->items as $item)
            <div style="display:flex; justify-content:space-between; font-size:14px; padding:6px 0;">
                <span>{{ $item->product_name }} <small style="color:#999;">× {{ $item->quantity }}</small></span>
                <span>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
            </div>
        @endforeach
    </div>

    @include('partials.payment-box', ['order' => $order])
</section>

@endsection