@php
    $qr = \App\Models\Setting::get('payment_qr');
    $bankName = \App\Models\Setting::get('bank_name');
    $accountName = \App\Models\Setting::get('account_name');
    $accountNumber = \App\Models\Setting::get('account_number');
    $instructions = \App\Models\Setting::get('instructions');
    $contactPhone = \App\Models\Setting::get('contact_phone');

    $paid = $order->payment_status === 'paid';
    $pending = $order->payment_status === 'pending';
@endphp

<div class="payment-box">
    <div class="pay-steps">
        <div class="pay-step {{ $paid || $pending ? 'done' : 'active' }}">
            <span class="dot">{{ $paid || $pending ? '✓' : '1' }}</span>
            <span>Bayar</span>
            <span class="line"></span>
        </div>
        <div class="pay-step {{ $paid || $pending ? 'done' : '' }}">
            <span class="dot">{{ $paid || $pending ? '✓' : '2' }}</span>
            <span>Kirim Foto</span>
            <span class="line"></span>
        </div>
        <div class="pay-step {{ $paid ? 'done' : ($pending ? 'active' : '') }}">
            <span class="dot">{{ $paid ? '✓' : '3' }}</span>
            <span>{{ $paid ? 'Selesai' : 'Tunggu' }}</span>
        </div>
    </div>

    @if($paid)
        <div class="pay-note">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
            <span>Pembayaran sudah diterima. Terima kasih!</span>
        </div>
        @if($order->payment_proof)
            <div class="payment-proof"><img src="{{ asset('storage/' . $order->payment_proof) }}" alt="Bukti Pembayaran"></div>
        @endif
    @else
        <div class="pay-amount">
            <div class="lbl">Silakan bayar sebesar</div>
            <div class="val">{{ $order->total_formatted }}</div>
        </div>

        <div class="payment-methods">
            <div class="payment-qr">
                @if($qr)
                    <img src="{{ asset('storage/' . $qr) }}" alt="Kode Pembayaran">
                @else
                    <p style="font-size:13px; color:#999; padding:40px; text-align:center;">Kode pembayaran belum tersedia.</p>
                @endif
            </div>
            <div class="payment-info">
                <div class="pay-info-head">Scan / foto kode ini pakai HP untuk membayar.</div>
                <ol class="pay-steps-list">
                    <li>Buka aplikasi HP: <b>GoPay, OVO, DANA, ShopeePay, atau m-banking</b>.</li>
                    <li>Pilih menu <b>"Scan"</b> atau <b>"QRIS"</b>.</li>
                    <li>Arahkan kamera ke kode di samping.</li>
                    <li>Cek jumlahnya sudah <b>{{ $order->total_formatted }}</b>, lalu bayar.</li>
                    <li>Simpan / foto bukti pembayarannya.</li>
                </ol>
                @if($instructions)
                    <div class="pay-info-note">{{ $instructions }}</div>
                @endif
            </div>
        </div>

        @if($pending)
            <div class="pay-note waiting">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                <span>Foto bukti sudah dikirim. Admin sedang memeriksa.</span>
            </div>
            <div class="payment-proof"><img src="{{ asset('storage/' . $order->payment_proof) }}" alt="Bukti Pembayaran"></div>
            <form method="POST" action="{{ route('orders.payment.upload', $order->id) }}" enctype="multipart/form-data" class="pay-replace">
                @csrf
                <span style="font-size:13px; color:#666;">Salah kirim foto? Kirim ulang di sini.</span>
                <input type="file" id="payment_proof_replace" name="payment_proof" class="form-input" accept="image/*" required style="margin-top:8px;">
                <button type="submit" class="btn btn-sm" style="margin-top:10px;">Kirim Ulang</button>
            </form>
        @else
            <div class="pay-upload-wrap">
                <div class="pay-upload-title">Sudah bayar? Kirim foto buktinya di sini.</div>
                <form method="POST" action="{{ route('orders.payment.upload', $order->id) }}" enctype="multipart/form-data" class="pay-upload-form">
                    @csrf
                    <label class="pay-upload" for="payment_proof">
                        <img id="proofPreview" src="" alt="" style="display:none;">
                        <div class="hint"><b>Pilih Foto Bukti</b><br>Klik untuk pilih foto dari galeri HP</div>
                    </label>
                    <input type="file" id="payment_proof" name="payment_proof" class="form-input" accept="image/*" required style="display:none;">
                    <button type="submit" class="btn btn-dark" style="margin-top:14px; width:100%;">Kirim Foto Bukti</button>
                </form>
            </div>
        @endif

        @if($contactPhone)
            <div class="pay-help">Butuh bantuan? Hubungi <b>{{ $contactPhone }}</b></div>
        @endif
    @endif
</div>

@push('scripts')
<script>
    var proofInput = document.getElementById('payment_proof');
    if (proofInput) {
        proofInput.addEventListener('change', function (e) {
            var file = e.target.files[0];
            if (!file) return;
            var reader = new FileReader();
            reader.onload = function (ev) {
                var img = document.getElementById('proofPreview');
                var hint = document.querySelector('.pay-upload .hint');
                img.src = ev.target.result;
                img.style.display = 'block';
                if (hint) hint.style.display = 'none';
            };
            reader.readAsDataURL(file);
        });
    }
</script>
@endpush
