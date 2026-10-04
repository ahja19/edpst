@extends('layouts.app')

@section('title', 'Pesanan Berhasil')

@section('content')

<section class="section container">
    <div class="empty-state">
        <div style="font-family:'Playfair Display',serif; font-size:56px; line-height:1; margin-bottom:16px;">✓</div>
        <h2>Terima Kasih!</h2>
        <p>Pesanan Anda berhasil dibuat dengan nomor <strong style="color:black;">{{ $order->order_number }}</strong>.<br>
        Total pembayaran: <strong style="color:black;">{{ $order->total_formatted }}</strong></p>
        <p style="font-size:13px; color:#777;">Lakukan pembayaran dan kirim buktinya di bagian bawah halaman ini.</p>
        <div style="display:flex; gap:12px; justify-content:center;">
            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-dark">Lihat Pesanan</a>
            <a href="{{ route('shop.index') }}" class="btn">Lanjut Belanja</a>
        </div>
    </div>

    <div class="container" style="max-width:720px; margin:0 auto;">
        @include('partials.payment-box', ['order' => $order])
    </div>
</section>

@endsection