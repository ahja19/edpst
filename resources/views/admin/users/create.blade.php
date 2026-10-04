@extends('layouts.admin')

@section('title', 'Tambah Pengguna')

@section('content')

<div class="page-head">
    <h1>Tambah Pengguna</h1>
    <a href="{{ route('admin.users.index') }}" class="btn btn-sm">← Kembali</a>
</div>

<div class="admin-form">
    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div class="form-group">
            <label class="form-label">Nama</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-input" required>
            @error('name') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-input" required>
            @error('email') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-input" required>
            @error('password') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Role</label>
            <select name="role" class="form-select" required>
                <option value="">-- Pilih Role --</option>
                <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User (Pelanggan)</option>
                <option value="subadmin" {{ old('role') === 'subadmin' ? 'selected' : '' }}>Sub Admin</option>
                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            @error('role') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-dark">Simpan</button>
    </form>
</div>

@endsection