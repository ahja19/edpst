@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')

<section class="section container">
    <div class="section-header">
        <h2>Detail Pesanan</h2>
        <a href="{{ route('orders.index') }}" class="link">Kembali</a>
    </div>

    <div class="order-card">
        <div class="order-top">
            <div>
                <div class="order-number">{{ $order->order_number }}</div>
                <div style="font-size:13px; color:#777;">{{ $order->created_at->format('d M Y, H:i') }}</div>
            </div>
            <div style="text-align:right;">
                <span class="order-status status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                <div style="font-weight:700; margin-top:8px;">{{ $order->total_formatted }}</div>
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:24px;" class="detail-grid">
            <div>
                <div style="font-size:11px; letter-spacing:2px; text-transform:uppercase; color:#999; margin-bottom:6px;">Data Penerima</div>
                <div>{{ $order->customer_name }}</div>
                <div>{{ $order->customer_email }}</div>
                <div>{{ $order->phone }}</div>
                <div>{{ $order->address }}</div>
            </div>
            <div>
                <div style="font-size:11px; letter-spacing:2px; text-transform:uppercase; color:#999; margin-bottom:6px;">Pembayaran</div>
                <div>Status: <strong>{{ $order->payment_status_label }}</strong></div>
                @if($order->paid_at)
                    <div style="font-size:13px; color:#666;">Dikonfirmasi {{ $order->paid_at->format('d M Y H:i') }}</div>
                @endif
                @if($order->payment_status !== 'paid')
                    <a href="{{ route('orders.payment', $order->id) }}" style="display:inline-block; margin-top:10px; font-size:13px; text-decoration:underline;">Bayar Sekarang</a>
                @endif
            </div>
        </div>

        @if($order->status === 'cancelled')
            @php $contactPhone = \App\Models\Setting::get('contact_phone'); @endphp
            <div style="margin-bottom:24px; padding:14px 16px; background:#fdf1f1; border:1px solid #f0c8c8; border-radius:8px;">
                <div style="font-size:11px; letter-spacing:2px; text-transform:uppercase; color:#b00000; margin-bottom:6px;">Pesanan Dibatalkan</div>
                @if($order->cancellation_reason)
                    <div style="font-size:13px; color:#8a1c1c; margin-bottom:8px;">Alasan: {{ $order->cancellation_reason }}</div>
                @endif
                <div style="font-size:14px; color:#8a1c1c;">
                    Untuk pengembalian dana (refund), silakan hubungi kami di
                    @if($contactPhone)
                        <strong>{{ $contactPhone }}</strong>
                    @else
                        <strong>admin</strong>
                    @endif
                </div>
            </div>
        @endif

        @if($order->tracking_number)
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:24px;" class="detail-grid">
                <div>
                    <div style="font-size:11px; letter-spacing:2px; text-transform:uppercase; color:#999; margin-bottom:6px;">Kode Resi Pengiriman</div>
                    <div style="font-weight:700;">{{ $order->tracking_number }}</div>
                </div>
                <div>
                    <div style="font-size:11px; letter-spacing:2px; text-transform:uppercase; color:#999; margin-bottom:6px;">Nama Parcel / Kurir</div>
                    <div style="font-weight:700;">{{ $order->shipping_courier }}</div>
                    @if($order->shipped_at)
                        <div style="font-size:13px; color:#666; margin-top:4px;">Dikirim {{ $order->shipped_at->format('d M Y H:i') }}</div>
                    @endif
                </div>
            </div>
        @endif
    </div>

    @include('partials.payment-box', ['order' => $order])

    <div class="order-card">
        <div style="font-size:11px; letter-spacing:2px; text-transform:uppercase; color:#999; margin-bottom:12px;">Item Pesanan</div>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

<style>
    @media (max-width: 800px){
        .detail-grid { grid-template-columns: 1fr !important; }
    }
</style>

@endsection