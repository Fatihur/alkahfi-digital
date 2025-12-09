@extends('layouts.wali')

@section('title', 'Konfirmasi Pembayaran')

@section('content')
    <div style="max-width: 500px; margin: 50px auto; text-align: center;">
        <div class="card">
            <div class="card-body" style="padding: 40px;">
                <div style="width: 80px; height: 80px; background: rgba(245,158,11,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                    <i class="bi bi-hourglass-split" style="font-size: 2rem; color: #f59e0b;"></i>
                </div>
                <h2 style="margin-bottom: 10px;">Menunggu Pembayaran</h2>
                <p class="text-muted">Silakan selesaikan pembayaran Anda melalui channel yang dipilih.</p>
                
                <div style="background: var(--bg-body); padding: 20px; border-radius: 8px; margin: 20px 0;">
                    <div style="font-size: 0.875rem; color: var(--text-muted);">Total Pembayaran</div>
                    <div style="font-size: 1.5rem; font-weight: 700;">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</div>
                </div>
                
                <table class="table" style="text-align: left; margin-bottom: 20px;">
                    <tr><td>No. Transaksi</td><td><code>{{ $pembayaran->nomor_transaksi }}</code></td></tr>
                    <tr><td>Tagihan</td><td>{{ $pembayaran->tagihan->nama_tagihan }}</td></tr>
                    <tr><td>Metode</td><td>{{ ucfirst(str_replace('_', ' ', $pembayaran->channel_pembayaran)) }}</td></tr>
                </table>

                <p class="text-muted" style="font-size: 0.875rem;">
                    <i class="bi bi-info-circle"></i>
                    Status pembayaran akan diperbarui secara otomatis setelah pembayaran berhasil.
                </p>
                
                <a href="{{ route('wali.pembayaran.index') }}" class="btn btn-primary">
                    <i class="bi bi-clock-history"></i> Cek Status Pembayaran
                </a>
            </div>
        </div>
    </div>
@endsection
