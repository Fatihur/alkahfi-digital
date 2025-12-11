@extends('layouts.bendahara')

@section('title', 'Laporan Transaksi')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Laporan Transaksi</h1>
            <p class="page-subtitle">Total: <strong>Rp {{ number_format($totalPembayaran, 0, ',', '.') }}</strong></p>
        </div>
        <div class="btn-group">
            <a href="{{ route('bendahara.laporan.transaksi', array_merge(request()->query(), ['export' => 'excel'])) }}" class="btn btn-primary">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </a>
            <a href="{{ route('bendahara.laporan.transaksi', array_merge(request()->query(), ['export' => 'pdf'])) }}" class="btn btn-danger">
                <i class="bi bi-file-earmark-pdf"></i> Export PDF
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <form action="" method="GET" class="d-flex gap-2">
                <input type="date" name="tanggal_dari" class="form-control" value="{{ request('tanggal_dari') }}" style="width:150px;">
                <input type="date" name="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}" style="width:150px;">
                <button type="submit" class="btn btn-secondary">Filter</button>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No. Transaksi</th>
                        <th>Santri</th>
                        <th>Tagihan</th>
                        <th>Jumlah</th>
                        <th>Metode</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembayaran as $i => $p)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td><code>{{ $p->nomor_transaksi }}</code></td>
                            <td>{{ $p->santri->nama_lengkap }}</td>
                            <td>{{ $p->tagihan->nama_tagihan }}</td>
                            <td>Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                            <td>{{ ucfirst($p->metode_pembayaran) }}</td>
                            <td>{{ $p->tanggal_bayar?->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted">Tidak ada data transaksi</td></tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" style="text-align:right;"><strong>Total</strong></td>
                        <td colspan="3"><strong>Rp {{ number_format($totalPembayaran, 0, ',', '.') }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
