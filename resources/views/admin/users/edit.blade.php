@extends('layouts.admin')

@section('title', 'Edit Pengguna')

@section('content')

<div class="page-head">
    <h1>Edit Pengguna</h1>
    <a href="{{ route('admin.users.index') }}" class="btn btn-sm">← Kembali</a>
</div>

<div class="admin-form">
    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-input" required>
            @error('name') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-input" required>
            @error('email') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Password <span style="font-weight:400; color:#999;">(kosongkan jika tidak diubah)</span></label>
            <input type="password" name="password" class="form-input">
            @error('password') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Role</label>
            <select name="role" class="form-select" required>
                <option value="">-- Pilih Role --</option>
                <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User (Pelanggan)</option>
                <option value="subadmin" {{ old('role', $user->role) === 'subadmin' ? 'selected' : '' }}>Sub Admin</option>
                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            @error('role') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-dark">Perbarui</button>
    </form>
</div>

@endsection