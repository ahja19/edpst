@extends('layouts.admin')

@section('title', 'Pembayaran')

@section('content')

<div class="page-head">
    <h1>Pengaturan Pembayaran</h1>
</div>

@php
    $qr = \App\Models\Setting::get('payment_qr');
    $bankName = \App\Models\Setting::get('bank_name');
    $accountName = \App\Models\Setting::get('account_name');
    $accountNumber = \App\Models\Setting::get('account_number');
    $instructions = \App\Models\Setting::get('instructions');
    $contactPhone = \App\Models\Setting::get('contact_phone');
@endphp

<form method="POST" action="{{ route('admin.payment.update') }}" enctype="multipart/form-data" class="admin-form" style="max-width:560px;">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label class="form-label" for="qr_code">QR Code Pembayaran</label>
        @if($qr)
            <div style="margin-bottom:10px;">
                <img src="{{ asset('storage/' . $qr) }}" alt="QR Saat Ini" style="max-width:160px; border:1px solid #ddd; border-radius:8px;">
            </div>
        @endif
        <input type="file" id="qr_code" name="qr_code" class="form-input" accept="image/*">
        <small style="color:#999;">Kosongkan jika tidak ingin mengganti QR.</small>
    </div>

    <div class="form-group">
        <label class="form-label" for="bank_name">Nama Bank</label>
        <input type="text" id="bank_name" name="bank_name" class="form-input" value="{{ old('bank_name', $bankName) }}">
    </div>

    <div class="form-group">
        <label class="form-label" for="account_name">Atas Nama</label>
        <input type="text" id="account_name" name="account_name" class="form-input" value="{{ old('account_name', $accountName) }}">
    </div>

    <div class="form-group">
        <label class="form-label" for="account_number">No. Rekening</label>
        <input type="text" id="account_number" name="account_number" class="form-input" value="{{ old('account_number', $accountNumber) }}">
    </div>

    <div class="form-group">
        <label class="form-label" for="instructions">Instruksi Pembayaran</label>
        <textarea id="instructions" name="instructions" class="form-textarea" rows="4">{{ old('instructions', $instructions) }}</textarea>
    </div>

    <div class="form-group">
        <label class="form-label" for="contact_phone">No. Kontak (untuk Refund)</label>
        <input type="text" id="contact_phone" name="contact_phone" class="form-input" value="{{ old('contact_phone', $contactPhone) }}" placeholder="cth: 0812-3456-7890">
        <small style="color:#999;">Nomor ini otomatis ditampilkan ke pembeli saat pesanan dibatalkan untuk keperluan refund.</small>
    </div>

    <button type="submit" class="btn btn-dark">Simpan Pengaturan</button>
</form>

@endsection
