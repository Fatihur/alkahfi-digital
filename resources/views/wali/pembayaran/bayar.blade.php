@extends('layouts.wali')

@section('title', 'Bayar Tagihan')

@section('content')
    <div class="page-header"><div><h1 class="page-title">Bayar Tagihan</h1></div></div>

    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Detail Tagihan</h3></div>
                <div class="card-body">
                    <table class="table">
                        <tr><td><strong>Santri</strong></td><td>{{ $tagihan->santri->nama_lengkap }}</td></tr>
                        <tr><td><strong>NIS</strong></td><td>{{ $tagihan->santri->nis }}</td></tr>
                        <tr><td><strong>Tagihan</strong></td><td>{{ $tagihan->nama_tagihan }}</td></tr>
                        <tr><td><strong>Periode</strong></td><td>{{ $tagihan->periode ?? '-' }}</td></tr>
                        <tr><td><strong>Nominal</strong></td><td>Rp {{ number_format($tagihan->nominal, 0, ',', '.') }}</td></tr>
                        @if($tagihan->diskon > 0)
                        <tr><td><strong>Diskon</strong></td><td class="text-success">- Rp {{ number_format($tagihan->diskon, 0, ',', '.') }}</td></tr>
                        @endif
                        @if($tagihan->denda > 0)
                        <tr><td><strong>Denda</strong></td><td class="text-danger">+ Rp {{ number_format($tagihan->denda, 0, ',', '.') }}</td></tr>
                        @endif
                    </table>
                    <div style="background: var(--primary-subtle); padding: 20px; border-radius: 8px; text-align: center; margin-top: 20px;">
                        <div style="font-size: 0.875rem; color: var(--text-muted);">Total Pembayaran</div>
                        <div style="font-size: 2rem; font-weight: 700; color: var(--primary-color);">Rp {{ number_format($tagihan->total_bayar, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Pilih Metode Pembayaran</h3></div>
                <div class="card-body">
                    <form action="{{ route('wali.pembayaran.proses', $tagihan) }}" method="POST" id="paymentForm">
                        @csrf
                        
                        <div style="background: var(--bg-body); padding: 16px; border-radius: 8px; margin-bottom: 20px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 40px; height: 40px; background: var(--primary-subtle); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-shield-check" style="color: var(--primary-color); font-size: 1.25rem;"></i>
                                </div>
                                <div>
                                    <div style="font-weight: 600;">Duitku Payment Gateway</div>
                                    <div style="font-size: 0.8rem; color: var(--text-muted);">Pembayaran aman & terenkripsi</div>
                                </div>
                            </div>
                        </div>

                        <div class="payment-methods" style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px;">
                            <div class="payment-group">
                                <div style="font-weight: 600; font-size: 0.875rem; margin-bottom: 8px; color: var(--text-muted);">Virtual Account</div>
                                <div style="display: flex; flex-direction: column; gap: 8px;">
                                    <label class="payment-option">
                                        <input type="radio" name="payment_method" value="BC" required>
                                        <span class="payment-label"><i class="bi bi-bank"></i> BCA Virtual Account</span>
                                    </label>
                                    <label class="payment-option">
                                        <input type="radio" name="payment_method" value="M2">
                                        <span class="payment-label"><i class="bi bi-bank"></i> Mandiri Virtual Account</span>
                                    </label>
                                    <label class="payment-option">
                                        <input type="radio" name="payment_method" value="I1">
                                        <span class="payment-label"><i class="bi bi-bank"></i> BNI Virtual Account</span>
                                    </label>
                                    <label class="payment-option">
                                        <input type="radio" name="payment_method" value="BR">
                                        <span class="payment-label"><i class="bi bi-bank"></i> BRI Virtual Account</span>
                                    </label>
                                    <label class="payment-option">
                                        <input type="radio" name="payment_method" value="BT">
                                        <span class="payment-label"><i class="bi bi-bank"></i> Permata Virtual Account</span>
                                    </label>
                                </div>
                            </div>

                            <div class="payment-group" style="margin-top: 12px;">
                                <div style="font-weight: 600; font-size: 0.875rem; margin-bottom: 8px; color: var(--text-muted);">E-Wallet</div>
                                <div style="display: flex; flex-direction: column; gap: 8px;">
                                    <label class="payment-option">
                                        <input type="radio" name="payment_method" value="OV">
                                        <span class="payment-label"><i class="bi bi-wallet2"></i> OVO</span>
                                    </label>
                                    <label class="payment-option">
                                        <input type="radio" name="payment_method" value="DA">
                                        <span class="payment-label"><i class="bi bi-wallet2"></i> DANA</span>
                                    </label>
                                    <label class="payment-option">
                                        <input type="radio" name="payment_method" value="SA">
                                        <span class="payment-label"><i class="bi bi-wallet2"></i> ShopeePay</span>
                                    </label>
                                    <label class="payment-option">
                                        <input type="radio" name="payment_method" value="LF">
                                        <span class="payment-label"><i class="bi bi-wallet2"></i> LinkAja</span>
                                    </label>
                                </div>
                            </div>

                            <div class="payment-group" style="margin-top: 12px;">
                                <div style="font-weight: 600; font-size: 0.875rem; margin-bottom: 8px; color: var(--text-muted);">Retail</div>
                                <div style="display: flex; flex-direction: column; gap: 8px;">
                                    <label class="payment-option">
                                        <input type="radio" name="payment_method" value="IR">
                                        <span class="payment-label"><i class="bi bi-shop"></i> Indomaret</span>
                                    </label>
                                    <label class="payment-option">
                                        <input type="radio" name="payment_method" value="A1">
                                        <span class="payment-label"><i class="bi bi-shop"></i> Alfamart</span>
                                    </label>
                                </div>
                            </div>

                            <div class="payment-group" style="margin-top: 12px;">
                                <div style="font-weight: 600; font-size: 0.875rem; margin-bottom: 8px; color: var(--text-muted);">QRIS</div>
                                <div style="display: flex; flex-direction: column; gap: 8px;">
                                    <label class="payment-option">
                                        <input type="radio" name="payment_method" value="SP">
                                        <span class="payment-label"><i class="bi bi-qr-code"></i> QRIS (Semua Aplikasi)</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100" style="padding: 14px;" id="submitBtn">
                            <i class="bi bi-lock"></i> Lanjutkan ke Pembayaran
                        </button>
                    </form>
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('wali.tagihan.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Batal
                        </a>
                    </div>

                    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--border-color); text-align: center;">
                        <p class="text-muted" style="font-size: 0.75rem; margin: 0;">
                            <i class="bi bi-shield-lock"></i> Transaksi dilindungi oleh sistem keamanan Duitku
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .payment-option {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            background: var(--bg-body);
            border: 2px solid var(--border-color);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .payment-option:hover {
            border-color: var(--primary-color);
            background: var(--primary-subtle);
        }
        .payment-option input[type="radio"] {
            margin-right: 12px;
            accent-color: var(--primary-color);
        }
        .payment-option input[type="radio"]:checked + .payment-label {
            color: var(--primary-color);
            font-weight: 600;
        }
        .payment-option:has(input:checked) {
            border-color: var(--primary-color);
            background: var(--primary-subtle);
        }
        .payment-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
        }
        .payment-label i {
            font-size: 1.1rem;
        }
    </style>

    <script>
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            const selected = document.querySelector('input[name="payment_method"]:checked');
            if (!selected) {
                e.preventDefault();
                alert('Silakan pilih metode pembayaran');
                return false;
            }
            document.getElementById('submitBtn').disabled = true;
            document.getElementById('submitBtn').innerHTML = '<i class="bi bi-hourglass-split"></i> Memproses...';
        });
    </script>
@endsection
