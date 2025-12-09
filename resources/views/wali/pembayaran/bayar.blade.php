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
                <div class="card-header"><h3 class="card-title">Metode Pembayaran</h3></div>
                <div class="card-body">
                    <form action="{{ route('wali.pembayaran.proses', $tagihan) }}" method="POST">
                        @csrf
                        
                        <div style="background: var(--bg-body); padding: 16px; border-radius: 8px; margin-bottom: 20px;">
                            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                                <div style="width: 40px; height: 40px; background: var(--primary-subtle); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-shield-check" style="color: var(--primary-color); font-size: 1.25rem;"></i>
                                </div>
                                <div>
                                    <div style="font-weight: 600;">Midtrans Payment Gateway</div>
                                    <div style="font-size: 0.8rem; color: var(--text-muted);">Pembayaran aman & terenkripsi</div>
                                </div>
                            </div>
                            <p style="font-size: 0.875rem; color: var(--text-muted); margin: 0;">
                                Pilih metode pembayaran favorit Anda di halaman checkout. Tersedia berbagai pilihan:
                            </p>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-bottom: 20px;">
                            <div style="background: var(--bg-body); padding: 12px; border-radius: 8px; text-align: center;">
                                <i class="bi bi-qr-code" style="font-size: 1.5rem; color: var(--primary-color);"></i>
                                <div style="font-size: 0.8rem; margin-top: 4px;">QRIS</div>
                            </div>
                            <div style="background: var(--bg-body); padding: 12px; border-radius: 8px; text-align: center;">
                                <i class="bi bi-bank" style="font-size: 1.5rem; color: var(--primary-color);"></i>
                                <div style="font-size: 0.8rem; margin-top: 4px;">Bank Transfer</div>
                            </div>
                            <div style="background: var(--bg-body); padding: 12px; border-radius: 8px; text-align: center;">
                                <i class="bi bi-wallet2" style="font-size: 1.5rem; color: var(--primary-color);"></i>
                                <div style="font-size: 0.8rem; margin-top: 4px;">E-Wallet</div>
                            </div>
                            <div style="background: var(--bg-body); padding: 12px; border-radius: 8px; text-align: center;">
                                <i class="bi bi-credit-card" style="font-size: 1.5rem; color: var(--primary-color);"></i>
                                <div style="font-size: 0.8rem; margin-top: 4px;">Kartu Kredit</div>
                            </div>
                        </div>

                        <input type="hidden" name="channel" value="snap">

                        <button type="submit" class="btn btn-primary w-100" style="padding: 14px;">
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
                            <i class="bi bi-shield-lock"></i> Transaksi dilindungi oleh sistem keamanan Midtrans
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
