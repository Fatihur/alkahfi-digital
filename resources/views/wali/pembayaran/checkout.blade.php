<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - {{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @if(config('midtrans.is_production'))
        <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
    @else
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
    @endif
</head>
<body style="background: var(--bg-body);">
    <div style="max-width: 500px; margin: 50px auto; padding: 20px;">
        <div class="card">
            <div class="card-body" style="padding: 40px; text-align: center;">
                <div style="width: 80px; height: 80px; background: var(--primary-subtle); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                    <i class="bi bi-credit-card" style="font-size: 2rem; color: var(--primary-color);"></i>
                </div>
                
                <h2 style="margin-bottom: 10px;">Pembayaran SPP</h2>
                <p class="text-muted">{{ $pembayaran->tagihan->nama_tagihan }}</p>
                
                <div style="background: var(--bg-body); padding: 20px; border-radius: 8px; margin: 20px 0;">
                    <table class="table" style="margin: 0; text-align: left;">
                        <tr>
                            <td>Santri</td>
                            <td style="text-align: right;"><strong>{{ $pembayaran->santri->nama_lengkap }}</strong></td>
                        </tr>
                        <tr>
                            <td>NIS</td>
                            <td style="text-align: right;">{{ $pembayaran->santri->nis }}</td>
                        </tr>
                        <tr>
                            <td>No. Transaksi</td>
                            <td style="text-align: right;"><code>{{ $pembayaran->nomor_transaksi }}</code></td>
                        </tr>
                    </table>
                </div>

                <div style="background: var(--primary-subtle); padding: 20px; border-radius: 8px; margin: 20px 0;">
                    <div style="font-size: 0.875rem; color: var(--text-muted);">Total Pembayaran</div>
                    <div style="font-size: 2rem; font-weight: 700; color: var(--primary-color);">
                        Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}
                    </div>
                </div>

                @if($snapToken)
                    <button id="pay-button" class="btn btn-primary btn-lg w-100" style="padding: 16px;">
                        <i class="bi bi-shield-check"></i> Bayar Sekarang
                    </button>
                @else
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-circle"></i>
                        Token pembayaran tidak valid. Silakan coba lagi.
                    </div>
                    <a href="{{ route('wali.tagihan.index') }}" class="btn btn-secondary">Kembali</a>
                @endif

                <div style="margin-top: 20px;">
                    <a href="{{ route('wali.pembayaran.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

                <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid var(--border-color);">
                    <p class="text-muted" style="font-size: 0.8rem;">
                        <i class="bi bi-shield-lock"></i>
                        Pembayaran diproses dengan aman oleh Midtrans
                    </p>
                    <div style="display: flex; justify-content: center; gap: 10px; margin-top: 10px;">
                        <img src="https://midtrans.com/assets/images/logo/logo-mastercard.svg" alt="Mastercard" style="height: 24px;">
                        <img src="https://midtrans.com/assets/images/logo/logo-visa.svg" alt="Visa" style="height: 24px;">
                        <img src="https://midtrans.com/assets/images/logo/logo-gopay.svg" alt="GoPay" style="height: 24px;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($snapToken)
    <script>
        document.getElementById('pay-button').addEventListener('click', function() {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    fetch('{{ route("wali.pembayaran.verify", $pembayaran->id) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        window.location.href = '{{ route("wali.pembayaran.index") }}?status=success';
                    })
                    .catch(error => {
                        window.location.href = '{{ route("wali.pembayaran.index") }}?status=success';
                    });
                },
                onPending: function(result) {
                    window.location.href = '{{ route("wali.pembayaran.index") }}?status=pending';
                },
                onError: function(result) {
                    window.location.href = '{{ route("wali.pembayaran.index") }}?status=error';
                },
                onClose: function() {
                    console.log('Payment popup closed');
                }
            });
        });
    </script>
    @endif
</body>
</html>
