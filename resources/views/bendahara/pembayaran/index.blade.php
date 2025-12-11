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
        <div class="card-body">
            <table class="table" id="dataTable" style="width:100%">
                <thead>
                    <tr>
                        <th>No. Transaksi</th>
                        <th>Santri</th>
                        <th>Tagihan</th>
                        <th>Jumlah</th>
                        <th>Metode</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th width="80">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pembayaran as $p)
                        <tr>
                            <td><code>{{ $p->nomor_transaksi }}</code></td>
                            <td>{{ $p->santri->nama_lengkap }}</td>
                            <td>{{ $p->tagihan->nama_tagihan }}</td>
                            <td>Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                            <td>{{ ucfirst($p->metode_pembayaran) }}</td>
                            <td data-order="{{ $p->tanggal_bayar?->format('Y-m-d H:i:s') ?? '' }}">
                                {{ $p->tanggal_bayar?->format('d/m/Y H:i') ?? '-' }}
                            </td>
                            <td>
                                @switch($p->status)
                                    @case('berhasil')
                                        <span class="badge badge-success">Berhasil</span>
                                        @break
                                    @case('pending')
                                        <span class="badge badge-warning">Pending</span>
                                        @break
                                    @case('gagal')
                                        <span class="badge badge-danger">Gagal</span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('bendahara.pembayaran.show', $p) }}" class="btn btn-sm btn-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if($p->status === 'berhasil')
                                        <a href="{{ route('bendahara.pembayaran.cetak', $p) }}" class="btn btn-sm btn-secondary" target="_blank" title="Cetak">
                                            <i class="bi bi-printer"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            order: [[5, 'desc']],
            columnDefs: [
                { orderable: false, targets: -1 }
            ]
        });
    });
</script>
@endpush
