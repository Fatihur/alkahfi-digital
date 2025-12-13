@extends('layouts.admin')

@section('title', 'Manajemen Pembayaran')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Riwayat Pembayaran</h1>
            <p class="page-subtitle">Lihat riwayat pembayaran SPP santri.</p>
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
                            <td>
                                {{ $p->santri->nama_lengkap }}
                                <br><small class="text-muted">{{ $p->santri->nis }}</small>
                            </td>
                            <td>{{ $p->tagihan->nama_tagihan }}</td>
                            <td>Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $p->metode_pembayaran)) }}</td>
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
                                    @case('expired')
                                        <span class="badge badge-secondary">Expired</span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.pembayaran.show', $p) }}" class="btn btn-sm btn-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if($p->status == 'berhasil')
                                        <a href="{{ route('admin.pembayaran.cetak', $p) }}" class="btn btn-sm btn-primary" target="_blank" title="Cetak">
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
