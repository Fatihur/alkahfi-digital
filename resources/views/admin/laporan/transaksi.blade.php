@extends('layouts.admin')

@section('title', 'Laporan Transaksi')

@section('content')
    <div class="page-header">
        <div><h1 class="page-title">Laporan Transaksi</h1></div>
        <div class="btn-group">
            <a href="{{ route('admin.laporan.transaksi', array_merge(request()->all(), ['export' => 'excel'])) }}" class="btn btn-primary"><i class="bi bi-file-earmark-excel"></i> Export Excel</a>
            <a href="{{ route('admin.laporan.transaksi', array_merge(request()->all(), ['export' => 'pdf'])) }}" class="btn btn-danger"><i class="bi bi-file-earmark-pdf"></i> Export PDF</a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <form action="" method="GET" class="d-flex gap-2">
                <input type="date" name="tanggal_dari" class="form-control" value="{{ request('tanggal_dari') }}" style="width: 150px;">
                <input type="date" name="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}" style="width: 150px;">
                <button type="submit" class="btn btn-secondary">Filter</button>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead><tr><th>No. Transaksi</th><th>Santri</th><th>Tagihan</th><th>Jumlah</th><th>Metode</th><th>Tanggal</th></tr></thead>
                <tbody>
                    @forelse($pembayaran as $p)
                        <tr>
                            <td><code>{{ $p->nomor_transaksi }}</code></td>
                            <td>{{ $p->santri->nama_lengkap }}</td>
                            <td>{{ $p->tagihan->nama_tagihan }}</td>
                            <td>Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                            <td>{{ ucfirst($p->metode_pembayaran) }}</td>
                            <td>{{ $p->tanggal_bayar->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr style="font-weight: bold; background: var(--bg-body);">
                        <td colspan="3">Total</td>
                        <td colspan="3">Rp {{ number_format($totalPembayaran, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
