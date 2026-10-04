@extends('layouts.app')

@section('title', 'Keranjang — EDPstore')

@section('content')

<section class="section container">
    <div class="section-header">
        <h2>Keranjang Belanja</h2>
        <span>{{ $items->count() }} item</span>
    </div>

    @if($items->isEmpty())
        <div class="empty-state">
            <h2>Keranjang Anda Kosong</h2>
            <p>Jelajahi koleksi parfum kami dan temukan aroma favorit Anda.</p>
            <a href="{{ route('shop.index') }}" class="btn btn-dark">Mulai Belanja</a>
        </div>
    @else
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($items as $item)
                    @php
                        $subtotal = $item->product->price * $item->quantity;
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td>
                            <div style="display:flex; align-items:center; gap:14px;">
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="" class="thumb">
                                @else
                                    <div class="thumb" style="border:1px solid #ddd;"></div>
                                @endif
                                <div>
                                    <a href="{{ route('product.show', $item->product->slug) }}" style="font-family:'Playfair Display',serif; font-size:17px;">{{ $item->product->name }}</a>
                                    <div style="font-size:12px; color:#777;">{{ $item->product->size ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $item->product->formatted_price }}</td>
                        <td>
                            <form method="POST" action="{{ route('cart.update', $item->id) }}" class="cart-qty" style="display:flex; gap:8px; align-items:center;">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}">
                                <button type="submit" class="btn btn-sm">Update</button>
                            </form>
                        </td>
                        <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        <td>
                            <form method="POST" action="{{ route('cart.destroy', $item->id) }}" onsubmit="return confirm('Hapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="cart-summary">
            <h3>Ringkasan</h3>
            <div class="sum-row"><span>Subtotal</span><span>Rp {{ number_format($total, 0, ',', '.') }}</span></div>
            <div class="sum-row total"><span>Total</span><span>Rp {{ number_format($total, 0, ',', '.') }}</span></div>
            <a href="{{ route('checkout.create') }}" class="btn btn-dark" style="width:100%; margin-top:20px;">Checkout Sekarang</a>
            <a href="{{ route('shop.index') }}" style="display:block; text-align:center; margin-top:14px; font-size:13px; text-decoration:underline;">Lanjut Belanja</a>
        </div>
    @endif
</section>

@endsection