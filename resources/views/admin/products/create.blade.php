@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')

<div class="page-head">
    <h1>Tambah Produk</h1>
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

<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="admin-form">
    @csrf

    <div class="form-group">
        <label class="form-label">Nama Produk</label>
        <input type="text" name="name" class="form-input" value="{{ old('name') }}" required>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
        <div class="form-group">
            <label class="form-label">Brand</label>
            <input type="text" name="brand" class="form-input" value="{{ old('brand') }}">
        </div>
        <div class="form-group">
            <label class="form-label">Ukuran (ml)</label>
            <input type="text" name="size" class="form-input" value="{{ old('size') }}" placeholder="100 ml">
        </div>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
        <div class="form-group">
            <label class="form-label">Harga (Rp)</label>
            <input type="number" name="price" class="form-input" value="{{ old('price') }}" min="0" step="0.01" required>
        </div>
        <div class="form-group">
            <label class="form-label">Stok</label>
            <input type="number" name="stock" class="form-input" value="{{ old('stock', 0) }}" min="0" required>
        </div>
    </div>

    <div class="form-group">
        <label class="form-label">Deskripsi</label>
        <textarea name="description" class="form-textarea" required>{{ old('description') }}</textarea>
    </div>

    <div class="form-group">
        <label class="form-label">Gambar Produk</label>
        <input type="file" name="image" class="form-input" accept="image/*">
        <p style="font-size:12px; color:#999; margin-top:6px;">Format: JPG/PNG/WebP, maks 2MB.</p>
    </div>

    <button type="submit" class="btn btn-dark">Simpan Produk</button>
</form>

@endsection