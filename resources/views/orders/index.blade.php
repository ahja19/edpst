@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')

<section class="section container">
    <div class="section-header">
        <h2>Pesanan Saya</h2>
    </div>

    @if($orders->isEmpty())
        <div class="empty-state">
            <h2>Belum Ada Pesanan</h2>
            <p>Anda belum melakukan pembelian. Mulai dari koleksi kami.</p>
            <a href="{{ route('shop.index') }}" class="btn btn-dark">Belanja Sekarang</a>
        </div>
    @else
        @foreach($orders as $order)
            <div class="order-card">
                <div class="order-top">
                    <div>
                        <div class="order-number">{{ $order->order_number }}</div>
                        <div style="font-size:13px; color:#777;">{{ $order->created_at->format('d M Y, H:i') }}</div>
                    </div>
                    <div style="text-align:right;">
                        <span class="order-status status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
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
                <a href="{{ route('orders.show', $order->id) }}" style="display:inline-block; margin-top:14px; font-size:13px; text-decoration:underline;">Detail Pesanan</a>
            </div>
        @endforeach
    @endif
</section>

@endsection