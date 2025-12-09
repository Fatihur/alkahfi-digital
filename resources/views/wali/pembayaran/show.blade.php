@extends('layouts.wali')

@section('title', 'Detail Pembayaran')

@section('content')
    <div class="page-header">
        <div><h1 class="page-title">Detail Pembayaran</h1></div>
        <div class="d-flex gap-2">
            @if($pembayaran->status == 'berhasil')
                <a href="{{ route('wali.pembayaran.cetak', $pembayaran) }}" class="btn btn-primary" target="_blank"><i class="bi bi-printer"></i> Cetak</a>
            @endif
            <a href="{{ route('wali.pembayaran.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Informasi Pembayaran</h3></div>
                <div class="card-body">
                    <table class="table">
                        <tr><td><strong>No. Transaksi</strong></td><td><code>{{ $pembayaran->nomor_transaksi }}</code></td></tr>
                        <tr><td><strong>Jumlah Bayar</strong></td><td><strong>Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</strong></td></tr>
                        <tr><td><strong>Metode</strong></td><td>{{ ucfirst(str_replace('_', ' ', $pembayaran->metode_pembayaran)) }}</td></tr>
                        <tr><td><strong>Tanggal</strong></td><td>{{ $pembayaran->tanggal_bayar?->format('d/m/Y H:i') ?? '-' }}</td></tr>
                        <tr><td><strong>Status</strong></td><td><span class="badge badge-{{ $pembayaran->status == 'berhasil' ? 'success' : 'warning' }}">{{ ucfirst($pembayaran->status) }}</span></td></tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Informasi Tagihan</h3></div>
                <div class="card-body">
                    <table class="table">
                        <tr><td><strong>Tagihan</strong></td><td>{{ $pembayaran->tagihan->nama_tagihan }}</td></tr>
                        <tr><td><strong>Santri</strong></td><td>{{ $pembayaran->santri->nama_lengkap }}</td></tr>
                        <tr><td><strong>NIS</strong></td><td>{{ $pembayaran->santri->nis }}</td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
