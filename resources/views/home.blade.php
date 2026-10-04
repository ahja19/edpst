@extends('layouts.app')

@section('title', 'EDPstore')

@section('content')

<section class="hero">
    <h1>EDPSTORE</h1>
    <p>Koleksi Parfum Premium untuk Momen Anda</p>
    <a href="{{ route('shop.index') }}" class="btn btn-outline-light">Jelajahi Koleksi</a>
</section>

<section class="section container">
    <div class="section-header">
        <h2>Produk Unggulan</h2>
        <a href="{{ route('shop.index') }}" class="link">Lihat Semua</a>
    </div>

    @if($products->isEmpty())
        <div class="empty-state">
            <h2>Belum Ada Produk</h2>
            <p>Koleksi akan segera hadir.</p>
        </div>
    @else
        <div class="product-grid">
            @foreach($products as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    @endif
</section>

@endsection