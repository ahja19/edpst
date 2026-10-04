@extends('layouts.admin')

@section('title', 'Pengguna')

@section('content')

<div class="page-head">
    <h1>Daftar Pengguna</h1>
    @if(auth()->user()->isSuperAdmin())
    <a href="{{ route('admin.users.create') }}" class="btn btn-dark">+ Tambah Pengguna</a>
    @endif
</div>

<form method="GET" action="{{ route('admin.users.index') }}" style="display:flex; gap:10px; margin-bottom:20px; flex-wrap:wrap;">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="form-input" style="max-width:280px;">
    <select name="role" class="form-select" style="max-width:160px;">
        <option value="">Semua Role</option>
        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="subadmin" {{ request('role') === 'subadmin' ? 'selected' : '' }}>Sub Admin</option>
        <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
    </select>
    <button type="submit" class="btn btn-sm">Filter</button>
</form>

<table class="admin-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Bergabung</th>
            @if(auth()->user()->isSuperAdmin())
            <th>Aksi</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @forelse($users as $user)
            <tr>
                <td>{{ $users->firstItem() + $loop->index }}</td>
                <td><strong>{{ $user->name }}</strong></td>
                <td>{{ $user->email }}</td>
                <td>
                    @if($user->role === 'admin')
                        <span class="order-status status-completed">Admin</span>
                    @elseif($user->role === 'subadmin')
                        <span class="order-status status-confirmed">Sub Admin</span>
                    @else
                        <span class="order-status status-pending">User</span>
                    @endif
                </td>
                <td>{{ $user->created_at->format('d M Y') }}</td>
                @if(auth()->user()->isSuperAdmin())
                <td>
                    <div style="display:flex; gap:8px;">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm">Edit</a>
                        <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" onsubmit="return confirm('Hapus pengguna ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </div>
                </td>
                @endif
            </tr>
        @empty
            <tr><td colspan="6" style="text-align:center; color:#999; padding:30px;">Tidak ada pengguna ditemukan.</td></tr>
        @endforelse
    </tbody>
</table>

<div style="margin-top:24px;">{{ $users->links() }}</div>

@endsection