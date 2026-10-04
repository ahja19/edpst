@extends('layouts.app')

@section('title', 'Koleksi — EDPstore')

@section('content')

<section class="section container">
    <div class="section-header">
        <h2>Koleksi Parfum</h2>
        <span>{{ $products->total() }} produk</span>
    </div>

    <form method="GET" action="{{ route('shop.index') }}" style="display:flex; gap:12px; flex-wrap:wrap; margin-bottom:36px;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari parfum..." class="form-input" style="max-width:280px;">
        <select name="brand" class="form-select" style="max-width:220px;">
            <option value="all">Semua Brand</option>
            @foreach($brands as $brand)
                <option value="{{ $brand }}" {{ request('brand') === $brand ? 'selected' : '' }}>{{ $brand }}</option>
            @endforeach
        </select>
        <select name="sort" class="form-select" style="max-width:220px;">
            <option value="newest" {{ request('sort', 'newest') === 'newest' ? 'selected' : '' }}>Terbaru</option>
            <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
            <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
        </select>
        <button type="submit" class="btn">Terapkan</button>
    </form>

    @if($products->isEmpty())
        <div class="empty-state">
            <h2>Produk Tidak Ditemukan</h2>
            <p>Coba kata kunci atau filter lainnya.</p>
        </div>
    @else
        <div class="product-grid">
            @foreach($products as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
        <div style="margin-top:40px;">{{ $products->links() }}</div>
    @endif
</section>

@endsection