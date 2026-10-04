@extends('layouts.app')

@section('title', 'Checkout — EDPstore')

@section('content')

<section class="section container">
    <div class="section-header">
        <h2>Checkout</h2>
    </div>

    @if($errors->any())
        <div class="flash flash-error">
            <ul style="margin-left:18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="display:grid; grid-template-columns: 1.4fr 1fr; gap:40px; align-items:start;" class="checkout-grid">
        <form method="POST" action="{{ route('checkout.store') }}">
            @csrf
            <h3 style="font-family:'Playfair Display',serif; font-size:20px; margin-bottom:24px; text-transform:uppercase; letter-spacing:2px;">Data Penerima</h3>

            <div class="form-group">
                <label class="form-label" for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" class="form-input" value="{{ old('name', auth()->user()->name) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" name="email" class="form-input" value="{{ old('email', auth()->user()->email) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="phone">No. HP / WA</label>
                <input type="text" id="phone" name="phone" class="form-input" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="address">Alamat Pengiriman</label>
                <textarea id="address" name="address" class="form-textarea" required>{{ old('address') }}</textarea>
            </div>

            <button type="submit" class="btn btn-dark" style="width:100%;">Buat Pesanan — Rp {{ number_format($total, 0, ',', '.') }}</button>
        </form>

        <div class="cart-summary" style="margin:0;">
            <h3>Pesanan Anda</h3>
            @foreach($items as $item)
                <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #eee; font-size:14px;">
                    <span>{{ $item->product->name }} <small style="color:#999;">× {{ $item->quantity }}</small></span>
                    <span>Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                </div>
            @endforeach
            <div class="sum-row total"><span>Total</span><span>Rp {{ number_format($total, 0, ',', '.') }}</span></div>
            <p style="font-size:12px; color:#999; margin-top:12px;">Silakan transfer ke rekening yang diinformasikan setelah pesanan dibuat.</p>
        </div>
    </div>
</section>

<style>
    @media (max-width: 800px){
        .checkout-grid { grid-template-columns: 1fr !important; }
    }
</style>

@endsection