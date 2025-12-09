@extends('layouts.admin')

@section('title', 'Detail Pembayaran')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Pembayaran</h1>
            <p class="page-subtitle">{{ $pembayaran->nomor_transaksi }}</p>
        </div>
        <div class="d-flex gap-2">
            @if($pembayaran->status == 'berhasil')
                <a href="{{ route('admin.pembayaran.cetak', $pembayaran) }}" class="btn btn-primary" target="_blank">
                    <i class="bi bi-printer"></i> Cetak Bukti
                </a>
            @endif
            <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Informasi Pembayaran</h3></div>
                <div class="card-body">
                    <table class="table">
                        <tr><td><strong>No. Transaksi</strong></td><td><code>{{ $pembayaran->nomor_transaksi }}</code></td></tr>
                        <tr><td><strong>Tagihan</strong></td><td>{{ $pembayaran->tagihan->nama_tagihan }}</td></tr>
                        <tr><td><strong>Jumlah Bayar</strong></td><td><strong>Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</strong></td></tr>
                        <tr><td><strong>Metode</strong></td><td>{{ ucfirst(str_replace('_', ' ', $pembayaran->metode_pembayaran)) }}</td></tr>
                        <tr><td><strong>Channel</strong></td><td>{{ $pembayaran->channel_pembayaran ?? '-' }}</td></tr>
                        <tr><td><strong>Tanggal Bayar</strong></td><td>{{ $pembayaran->tanggal_bayar?->format('d/m/Y H:i') ?? '-' }}</td></tr>
                        <tr><td><strong>Status</strong></td><td>
                            @switch($pembayaran->status)
                                @case('berhasil') <span class="badge badge-success">Berhasil</span> @break
                                @case('pending') <span class="badge badge-warning">Pending</span> @break
                                @case('gagal') <span class="badge badge-danger">Gagal</span> @break
                            @endswitch
                        </td></tr>
                        <tr><td><strong>Catatan</strong></td><td>{{ $pembayaran->catatan ?? '-' }}</td></tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Informasi Santri</h3></div>
                <div class="card-body">
                    <table class="table">
                        <tr><td><strong>NIS</strong></td><td>{{ $pembayaran->santri->nis }}</td></tr>
                        <tr><td><strong>Nama</strong></td><td>{{ $pembayaran->santri->nama_lengkap }}</td></tr>
                        <tr><td><strong>Kelas</strong></td><td>{{ $pembayaran->santri->kelas->nama_kelas ?? '-' }}</td></tr>
                    </table>
                </div>
            </div>
            @if($pembayaran->verifiedBy)
            <div class="card">
                <div class="card-header"><h3 class="card-title">Verifikasi</h3></div>
                <div class="card-body">
                    <table class="table">
                        <tr><td><strong>Diverifikasi Oleh</strong></td><td>{{ $pembayaran->verifiedBy->name }}</td></tr>
                        <tr><td><strong>Waktu Verifikasi</strong></td><td>{{ $pembayaran->verified_at?->format('d/m/Y H:i') }}</td></tr>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
