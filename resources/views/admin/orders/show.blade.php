@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')

<div class="page-head">
    <h1>Detail Pesanan</h1>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm">Kembali</a>
</div>

<div class="admin-card">
    <div style="display:flex; justify-content:space-between; flex-wrap:wrap; gap:16px; border-bottom:1px solid #eee; padding-bottom:16px; margin-bottom:16px;">
        <div>
            <strong style="font-size:18px;">{{ $order->order_number }}</strong>
            <div style="font-size:13px; color:#777; margin-top:4px;">{{ $order->created_at->format('d M Y, H:i') }}</div>
        </div>
        <div>
            <span class="order-status status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
            <div style="font-size:20px; font-weight:700; margin-top:8px;">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
        </div>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px;">
        <div>
            <div style="font-size:11px; letter-spacing:2px; text-transform:uppercase; color:#999; margin-bottom:6px;">Data Penerima</div>
            <div><strong>{{ $order->customer_name }}</strong></div>
            <div>{{ $order->customer_email }}</div>
            <div>{{ $order->phone }}</div>
            <div>{{ $order->address }}</div>
        </div>
        <div>
            <div style="font-size:11px; letter-spacing:2px; text-transform:uppercase; color:#999; margin-bottom:6px;">Pelanggan</div>
            <div>{{ $order->user->name ?? 'Tanpa akun' }}</div>
            <div>{{ $order->user->email ?? '' }}</div>
        </div>
    </div>
</div>

<div class="admin-card">
    <div style="font-size:11px; letter-spacing:2px; text-transform:uppercase; color:#999; margin-bottom:12px;">Item Pesanan</div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="admin-card">
    <div style="font-size:11px; letter-spacing:2px; text-transform:uppercase; color:#999; margin-bottom:12px;">Pembayaran</div>
    <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
        <span class="order-status status-{{ $order->payment_status_css }}">{{ $order->payment_status_label }}</span>
        @if($order->paid_at)
            <span style="font-size:13px; color:#666;">Dikonfirmasi {{ $order->paid_at->format('d M Y H:i') }}</span>
        @endif
    </div>

    <div style="margin-top:16px;">
        @if($order->payment_proof)
            <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" title="Klik untuk lihat ukuran penuh">
                <img src="{{ asset('storage/' . $order->payment_proof) }}" alt="Bukti Pembayaran" style="max-width:240px; width:100%; border:1px solid #ddd; border-radius:8px;">
            </a>
        @else
            <p style="color:#999; font-size:13px;">Belum ada bukti pembayaran.</p>
        @endif
    </div>

    @if($order->payment_status === 'pending')
        <form method="POST" action="{{ route('admin.orders.payment.confirm', $order->id) }}" style="margin-top:16px;">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-dark btn-sm">Konfirmasi Pembayaran</button>
        </form>
    @endif
</div>

<div class="admin-card">
    <div style="font-size:11px; letter-spacing:2px; text-transform:uppercase; color:#999; margin-bottom:12px;">Status & Pengiriman</div>

    @if($order->tracking_number)
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
            <div>
                <div style="font-size:11px; letter-spacing:2px; text-transform:uppercase; color:#999; margin-bottom:4px;">Kode Resi Pengiriman</div>
                <div style="font-weight:700;">{{ $order->tracking_number }}</div>
            </div>
            <div>
                <div style="font-size:11px; letter-spacing:2px; text-transform:uppercase; color:#999; margin-bottom:4px;">Nama Parcel / Kurir</div>
                <div style="font-weight:700;">{{ $order->shipping_courier }}</div>
            </div>
        </div>
        @if($order->shipped_at)
            <div style="font-size:13px; color:#666; margin-bottom:16px;">Dikirim {{ $order->shipped_at->format('d M Y H:i') }}</div>
        @endif
    @endif

    <form method="POST" action="{{ route('admin.orders.status', $order->id) }}">
        @csrf
        @method('PATCH')

        <div class="form-group">
            <label class="form-label" for="status">Status Pesanan</label>
            <select name="status" id="order-status" class="form-select" style="max-width:220px;">
                @foreach(['pending', 'confirmed', 'shipped', 'completed', 'cancelled'] as $st)
                    <option value="{{ $st }}" {{ $order->status === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                @endforeach
            </select>
        </div>

        <div id="shipping-fields" style="{{ $order->status === 'shipped' ? 'display:grid;' : 'display:none;' }} grid-template-columns:1fr 1fr; gap:12px; margin-top:4px;">
            <div class="form-group">
                <label class="form-label" for="shipping_courier">Nama Parcel / Kurir <small style="color:#999; font-weight:normal;">(opsional)</small></label>
                <input type="text" id="shipping_courier" name="shipping_courier" class="form-input" value="{{ old('shipping_courier', $order->shipping_courier) }}" placeholder="cth: JNE / SiCepat">
            </div>
            <div class="form-group">
                <label class="form-label" for="tracking_number">Kode Resi Pengiriman <small style="color:#999; font-weight:normal;">(opsional)</small></label>
                <input type="text" id="tracking_number" name="tracking_number" class="form-input" value="{{ old('tracking_number', $order->tracking_number) }}" placeholder="Nomor resi / referral">
            </div>
        </div>

        <div id="cancel-fields" style="{{ $order->status === 'cancelled' ? '' : 'display:none;' }}">
            <div class="form-group">
                <label class="form-label" for="cancellation_reason">Alasan Pembatalan <small style="color:#999; font-weight:normal;">(opsional)</small></label>
                <textarea id="cancellation_reason" name="cancellation_reason" class="form-textarea" rows="3" placeholder="Alasan jika pesanan dibatalkan">{{ old('cancellation_reason', $order->cancellation_reason) }}</textarea>
                <small style="color:#999;">Saat disimpan, pembeli otomatis melihat nomor kontak untuk refund: <strong>{{ \App\Models\Setting::get('contact_phone') ?: 'belum diatur (Pembayaran)' }}</strong></small>
            </div>
        </div>

        <button type="submit" class="btn btn-dark btn-sm">Simpan Status</button>
    </form>
</div>

@endsection

@push('scripts')
<script>
    var statusSelect = document.getElementById('order-status');
    var shippingFields = document.getElementById('shipping-fields');
    var cancelFields = document.getElementById('cancel-fields');

    function toggleShippingFields() {
        var isShipped = statusSelect.value === 'shipped';
        var isCancelled = statusSelect.value === 'cancelled';
        shippingFields.style.display = isShipped ? 'grid' : 'none';
        cancelFields.style.display = isCancelled ? 'block' : 'none';
    }

    statusSelect.addEventListener('change', toggleShippingFields);
    toggleShippingFields();
</script>
@endpush