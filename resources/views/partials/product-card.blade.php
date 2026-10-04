<a href="{{ route('product.show', $product->slug) }}" class="product-card">
    <div class="product-media">
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
        @else
            <div class="product-placeholder">EDP</div>
        @endif
    </div>
    @if($product->brand)
        <span class="product-brand">{{ $product->brand }}</span>
    @endif
    <h3 class="product-name">{{ $product->name }}</h3>
    <div class="product-price">{{ $product->formatted_price }}</div>
    <div class="product-meta">
        @if($product->size){{ $product->size }} &middot; @endif
        @if($product->stock > 0) Stok {{ $product->stock }} @else Habis @endif
    </div>
</a>