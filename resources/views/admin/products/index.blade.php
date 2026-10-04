@extends('layouts.admin')

@section('title', 'Produk')

@section('content')

<div class="page-head">
    <h1>Kelola Produk</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-dark">+ Tambah Produk</a>
</div>

<form method="GET" action="{{ route('admin.products.index') }}" style="display:flex; gap:10px; margin-bottom:20px;">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..." class="form-input" style="max-width:300px;">
    <button type="submit" class="btn btn-sm">Cari</button>
</form>

<table class="admin-table">
    <thead>
        <tr>
            <th>Gambar</th>
            <th>Nama</th>
            <th>Brand</th>
            <th>Ukuran</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($products as $product)
            <tr>
                <td>
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="" class="thumb">
                    @else
                        <div class="thumb" style="border:1px solid #ddd;"></div>
                    @endif
                </td>
                <td><strong>{{ $product->name }}</strong></td>
                <td>{{ $product->brand }}</td>
                <td>{{ $product->size }}</td>
                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td>{{ $product->stock }}</td>
                <td>
                    <div style="display:flex; gap:8px;">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm">Edit</a>
                        <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}" onsubmit="return confirm('Hapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" style="text-align:center; color:#999; padding:30px;">Belum ada produk.</td></tr>
        @endforelse
    </tbody>
</table>

<div style="margin-top:24px;">{{ $products->links() }}</div>

@endsection