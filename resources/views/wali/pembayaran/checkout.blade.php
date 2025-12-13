@extends('layouts.wali')

@section('title', 'Detail Pembayaran')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Pembayaran</h1>
            <p class="page-subtitle">Informasi pembayaran Anda</p>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="card">
                <div     class="card-header"><h3 class="card-title">Informasi Transaksi</h3></div>
                <div class="card-body">
                    <table class="table">
                        <tr><td><strong>No. Transaksi</strong></td><td><code>{{ $pembayaran->nomor_transaksi }}</code></td></tr>
                        <tr><td><strong>Santri</strong></td><td>{{ $pembayaran->santri->nama_lengkap }}</td></tr>
                        <tr><td><strong>NIS</strong></td><td>{{ $pembayaran->santri->nis }}</td></tr>
                        <tr><td><strong>Tagihan</strong></td><td>{{ $pembayaran->tagihan->nama_tagihan }}</td></tr>
                        <tr><td><strong>Metode</strong></td><td>{{ \App\Services\DuitkuService::getPaymentMethodName($pembayaran->channel_pembayaran) }}</td></tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>
                                @switch($pembayaran->status)
                                    @case('berhasil')
                                        <span class="badge badge-success">Berhasil</span>
                                        @break
                                    @case('pending')
                                        <span class="badge badge-warning">Menunggu Pembayaran</span>
                                        @break
                                    @case('gagal')
                                        <span class="badge badge-danger">Gagal</span>
                                        @break
                                    @case('expired')
                                        <span class="badge badge-secondary">Kadaluarsa</span>
                                        @break
                                @endswitch
                            </td>
                        </tr>
                    </table>

                    <div style="background: var(--primary-subtle); padding: 20px; border-radius: 8px; text-align: center; margin-top: 20px;">
                        <div style="font-size: 0.875rem; color: var(--text-muted);">Total Pembayaran</div>
                        <div style="font-size: 2rem; font-weight: 700; color: var(--primary-color);">
                            Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Instruksi Pembayaran</h3></div>
                <div class="card-body">
                    @if($pembayaran->status === 'pending')
                        @if(!empty($gatewayResponse['paymentUrl']))
                            <div style="text-align: center; margin-bottom: 20px;">
                                <p class="text-muted">Klik tombol di bawah untuk melanjutkan pembayaran:</p>
                                <a href="{{ $gatewayResponse['paymentUrl'] }}" class="btn btn-primary btn-lg" target="_blank">
                                    <i class="bi bi-credit-card"></i> Bayar Sekarang
                                </a>
                            </div>
                        @endif

                        @if(!empty($gatewayResponse['vaNumber']))
                            <div style="background: var(--bg-body); padding: 20px; border-radius: 8px; margin-bottom: 20px;">
                                <div style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 8px;">Nomor Virtual Account</div>
                                <div style="font-size: 1.5rem; font-weight: 700; font-family: monospace; letter-spacing: 2px;">
                                    {{ $gatewayResponse['vaNumber'] }}
                                </div>
                                <button onclick="copyToClipboard('{{ $gatewayResponse['vaNumber'] }}')" class="btn btn-sm btn-secondary mt-2">
                                    <i class="bi bi-clipboard"></i> Salin
                                </button>
                            </div>
                        @endif

                        @if(!empty($gatewayResponse['qrString']))
                            <div style="text-align: center; margin-bottom: 20px;">
                                <div style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 8px;">Scan QR Code</div>
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($gatewayResponse['qrString']) }}" alt="QR Code" style="max-width: 200px;">
                            </div>
                        @endif

                        <div class="alert alert-warning">
                            <i class="bi bi-clock"></i>
                            <span>Selesaikan pembayaran sebelum batas waktu berakhir.</span>
                        </div>

                        <div style="margin-top: 20px;">
                            <button onclick="checkStatus()" class="btn btn-secondary w-100" id="checkBtn">
                                <i class="bi bi-arrow-clockwise"></i> Cek Status Pembayaran
                            </button>
                        </div>
                    @elseif($pembayaran->status === 'berhasil')
                        <div style="text-align: center;">
                            <div style="width: 80px; height: 80px; background: rgba(16, 185, 129, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                                <i class="bi bi-check-circle" style="font-size: 2.5rem; color: var(--success-color);"></i>
                            </div>
                            <h3 style="color: var(--success-color);">Pembayaran Berhasil!</h3>
                            <p class="text-muted">Terima kasih, pembayaran Anda telah diterima.</p>
                            
                            <a href="{{ route('wali.pembayaran.cetak', $pembayaran) }}" class="btn btn-primary mt-3" target="_blank">
                                <i class="bi bi-printer"></i> Cetak Bukti Pembayaran
                            </a>
                        </div>
                    @else
                        <div style="text-align: center;">
                            <div style="width: 80px; height: 80px; background: rgba(239, 68, 68, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                                <i class="bi bi-x-circle" style="font-size: 2.5rem; color: var(--danger-color);"></i>
                            </div>
                            <h3 style="color: var(--danger-color);">Pembayaran {{ $pembayaran->status === 'expired' ? 'Kadaluarsa' : 'Gagal' }}</h3>
                            <p class="text-muted">Silakan coba lagi dengan membuat pembayaran baru.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="text-center mt-3">
                <a href="{{ route('wali.pembayaran.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali ke Riwayat Pembayaran
                </a>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('Nomor VA berhasil disalin!');
            });
        }

        function checkStatus(showAlert = true) {
            const btn = document.getElementById('checkBtn');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Mengecek...';
            }

            fetch('{{ route("wali.pembayaran.verify", $pembayaran->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data.pembayaran_status === 'berhasil') {
                    window.location.reload();
                } else {
                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="bi bi-arrow-clockwise"></i> Cek Status Pembayaran';
                    }
                    if (showAlert) {
                        alert('Status pembayaran: ' + (data.data?.pembayaran_status || 'pending'));
                    }
                }
            })
            .catch(error => {
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="bi bi-arrow-clockwise"></i> Cek Status Pembayaran';
                }
                if (showAlert) {
                    alert('Gagal mengecek status pembayaran');
                }
            });
        }

        // Auto-check status saat halaman dimuat (jika status masih pending)
        @if($pembayaran->status === 'pending')
        document.addEventListener('DOMContentLoaded', function() {
            // Cek status otomatis tanpa alert
            checkStatus(false);
        });
        @endif
    </script>
@endsection
