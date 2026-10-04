@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')

<div class="page-head">
    <h1>Edit Produk</h1>
    <a href="{{ route('admin.products.index') }}" class="btn btn-sm">Kembali</a>
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

<form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data" class="admin-form">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label class="form-label">Nama Produk</label>
        <input type="text" name="name" class="form-input" value="{{ old('name', $product->name) }}" required>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
        <div class="form-group">
            <label class="form-label">Brand</label>
            <input type="text" name="brand" class="form-input" value="{{ old('brand', $product->brand) }}">
        </div>
        <div class="form-group">
            <label class="form-label">Ukuran (ml)</label>
            <input type="text" name="size" class="form-input" value="{{ old('size', $product->size) }}" placeholder="100 ml">
        </div>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
        <div class="form-group">
            <label class="form-label">Harga (Rp)</label>
            <input type="number" name="price" class="form-input" value="{{ old('price', $product->price) }}" min="0" step="0.01" required>
        </div>
        <div class="form-group">
            <label class="form-label">Stok</label>
            <input type="number" name="stock" class="form-input" value="{{ old('stock', $product->stock) }}" min="0" required>
        </div>
    </div>

    <div class="form-group">
        <label class="form-label">Deskripsi</label>
        <textarea name="description" class="form-textarea" required>{{ old('description', $product->description) }}</textarea>
    </div>

    <div class="form-group">
        <label class="form-label">Gambar Produk</label>
        @if($product->image)
            <div style="margin-bottom:10px;">
                <img src="{{ asset('storage/' . $product->image) }}" alt="" style="width:100px; height:100px; object-fit:cover; border:1px solid #ddd;">
            </div>
        @endif
        <input type="file" name="image" class="form-input" accept="image/*">
        <p style="font-size:12px; color:#999; margin-top:6px;">Kosongkan jika tidak ingin mengganti gambar.</p>
    </div>

    <button type="submit" class="btn btn-dark">Perbarui Produk</button>
</form>

@endsection