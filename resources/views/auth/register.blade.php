@extends('layouts.app')

@section('title', 'Daftar — EDPstore')

@section('content')

<section class="container">
    <fieldset class="auth-box">
        <legend>Daftar</legend>

        @if($errors->any())
            <div class="form-error-message">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label class="form-label" for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" required autofocus>
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <div style="position:relative;">
                    <input type="password" id="password" name="password" class="form-input" style="padding-right:70px;" required>
                    <button type="button" data-toggle-password="password" style="position:absolute; top:50%; right:10px; transform:translateY(-50%); background:none; border:none; color:#888; font-size:12px; cursor:pointer; text-transform:uppercase; letter-spacing:1px;">Tampil</button>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                <div style="position:relative;">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" style="padding-right:70px;" required>
                    <button type="button" data-toggle-password="password_confirmation" style="position:absolute; top:50%; right:10px; transform:translateY(-50%); background:none; border:none; color:#888; font-size:12px; cursor:pointer; text-transform:uppercase; letter-spacing:1px;">Tampil</button>
                </div>
            </div>

            <button type="submit" class="btn btn-dark" style="width:100%;">Daftar</button>
        </form>

        <div class="auth-alt">Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></div>
    </fieldset>
</section>

@endsection

@push('scripts')
<script>
    document.querySelectorAll('[data-toggle-password]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var input = document.getElementById(this.getAttribute('data-toggle-password'));
            if (!input) return;
            var showing = input.type === 'text';
            input.type = showing ? 'password' : 'text';
            this.textContent = showing ? 'Tampil' : 'Sembunyi';
        });
    });
</script>
@endpush