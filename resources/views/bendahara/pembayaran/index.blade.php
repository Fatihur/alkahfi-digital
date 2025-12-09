@extends('layouts.bendahara')

@section('title', 'Manajemen Pembayaran')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Pembayaran</h1>
            <p class="page-subtitle">Kelola pembayaran SPP santri.</p>
        </div>
        <div>
            <a href="{{ route('bendahara.pembayaran.create') }}" class="btn btn-primary">
                <i class="bi bi-plus"></i> Pembayaran Manual
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <form action="" method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control" placeholder="Cari transaksi/nama..." value="{{ request('search') }}" style="width: 200px;">
                <select name="status" class="form-control form-select" style="width: 130px;">
                    <option value="">Semua Status</option>
                    <option value="berhasil" {{ request('status') == 'berhasil' ? 'selected' : '' }}>Berhasil</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="gagal" {{ request('status') == 'gagal' ? 'selected' : '' }}>Gagal</option>
                </select>
                <input type="date" name="tanggal_dari" class="form-control" value="{{ request('tanggal_dari') }}" style="width: 150px;">
                <input type="date" name="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}" style="width: 150px;">
                <button type="submit" class="btn btn-secondary">Filter</button>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No. Transaksi</th>
                        <th>Santri</th>
                        <th>Tagihan</th>
                        <th>Jumlah</th>
                        <th>Metode</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembayaran as $p)
                        <tr>
                            <td><code>{{ $p->nomor_transaksi }}</code></td>
                            <td>{{ $p->santri->nama_lengkap }}</td>
                            <td>{{ $p->tagihan->nama_tagihan }}</td>
                            <td>Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                            <td>{{ ucfirst($p->metode_pembayaran) }}</td>
                            <td>{{ $p->tanggal_bayar?->format('d/m/Y H:i') ?? '-' }}</td>
                            <td>
                                @switch($p->status)
                                    @case('berhasil') <span class="badge badge-success">Berhasil</span> @break
                                    @case('pending') <span class="badge badge-warning">Pending</span> @break
                                    @case('gagal') <span class="badge badge-danger">Gagal</span> @break
                                @endswitch
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('bendahara.pembayaran.show', $p) }}" class="btn btn-sm btn-secondary"><i class="bi bi-eye"></i></a>
                                    @if($p->status === 'berhasil')
                                        <a href="{{ route('bendahara.pembayaran.cetak', $p) }}" class="btn btn-sm btn-secondary" target="_blank"><i class="bi bi-printer"></i></a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted">Tidak ada data pembayaran</td></tr>
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
