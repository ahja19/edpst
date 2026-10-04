@extends('layouts.app')

@section('title', $product->name . ' — EDPstore')

@section('content')

<section class="container product-detail">
    <div class="media">
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width:100%;height:100%;object-fit:cover;">
        @else
            <div class="product-placeholder" style="height:100%;">EDP</div>
        @endif
    </div>
    <div class="info">
        @if($product->brand)
            <div class="brand-line">{{ $product->brand }}</div>
        @endif
        <h1>{{ $product->name }}</h1>
        @if($product->size)
            <div class="brand-line" style="margin-bottom:14px;">Ukuran: {{ $product->size }}</div>
        @endif
        <div class="price-line">{{ $product->formatted_price }}</div>
        <p class="detail-desc">{{ $product->description }}</p>

        <div class="meta-row">
            <div>
                <b>Stok</b>
                @if($product->stock > 0) {{ $product->stock }} botol tersedia @else Habis @endif
            </div>
            @if($product->brand)
                <div><b>Brand</b>{{ $product->brand }}</div>
            @endif
        </div>

        @if($product->stock > 0)
            <form method="POST" action="{{ route('cart.add', $product->id) }}">
                @csrf
                <div class="qty-row">
                    <label for="quantity" class="form-label" style="margin:0;">Jumlah</label>
                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}">
                </div>
                <button type="submit" class="btn btn-dark">Tambah ke Keranjang</button>
            </form>
            <p class="stock-note" style="margin-top:14px;">Dapat langsung dibeli melalui keranjang.</p>
        @else
            <button class="btn" disabled style="opacity:.5; cursor:not-allowed;">Stok Habis</button>
        @endif
    </div>
</section>

@if($related->isNotEmpty())
<section class="section container">
    <div class="section-header">
        <h2>Produk Serupa</h2>
        <a href="{{ route('shop.index') }}" class="link">Lihat Semua</a>
    </div>
    <div class="product-grid">
        @foreach($related as $rel)
            @include('partials.product-card', ['product' => $rel])
        @endforeach
    </div>
</section>
@endif

@endsection