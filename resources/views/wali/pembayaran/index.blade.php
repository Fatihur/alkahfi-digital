@extends('layouts.wali')

@section('title', 'Riwayat Pembayaran')

@section('content')
    <div class="page-header"><div><h1 class="page-title">Riwayat Pembayaran</h1><p class="page-subtitle">Daftar pembayaran yang telah dilakukan.</p></div></div>

    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead><tr><th>No. Transaksi</th><th>Santri</th><th>Tagihan</th><th>Jumlah</th><th>Tanggal</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($pembayaran as $p)
                        <tr>
                            <td><code>{{ $p->nomor_transaksi }}</code></td>
                            <td>{{ $p->santri->nama_lengkap }}</td>
                            <td>{{ $p->tagihan->nama_tagihan }}</td>
                            <td>Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                            <td>{{ $p->tanggal_bayar?->format('d/m/Y H:i') ?? '-' }}</td>
                            <td><span class="badge badge-{{ $p->status == 'berhasil' ? 'success' : 'warning' }}">{{ ucfirst($p->status) }}</span></td>
                            <td>
                                @if($p->status == 'berhasil')
                                    <a href="{{ route('wali.pembayaran.cetak', $p) }}" class="btn btn-sm btn-primary" target="_blank"><i class="bi bi-printer"></i></a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted">Belum ada pembayaran</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($pembayaran->hasPages())
            <div class="card-footer">
                {{ $pembayaran->links() }}
            </div>
        @endif
    </div>
@endsection
