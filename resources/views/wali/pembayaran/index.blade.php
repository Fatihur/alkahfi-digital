@extends('layouts.wali')

@section('title', 'Riwayat Pembayaran')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Riwayat Pembayaran</h1>
            <p class="page-subtitle">Daftar pembayaran yang telah dilakukan.</p>
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
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th width="60">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pembayaran as $p)
                        <tr>
                            <td><code>{{ $p->nomor_transaksi }}</code></td>
                            <td>{{ $p->santri->nama_lengkap }}</td>
                            <td>{{ $p->tagihan->nama_tagihan }}</td>
                            <td>Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                            <td data-order="{{ $p->tanggal_bayar?->format('Y-m-d H:i:s') ?? '' }}">
                                {{ $p->tanggal_bayar?->format('d/m/Y H:i') ?? '-' }}
                            </td>
                            <td>
                                <span class="badge badge-{{ $p->status == 'berhasil' ? 'success' : 'warning' }}">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                            <td>
                                @if($p->status == 'berhasil')
                                    <a href="{{ route('wali.pembayaran.cetak', $p) }}" class="btn btn-sm btn-primary" target="_blank" title="Cetak Bukti">
                                        <i class="bi bi-printer"></i>
                                    </a>
                                @endif
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
            order: [[4, 'desc']],
            columnDefs: [
                { orderable: false, targets: -1 }
            ]
        });
    });
</script>
@endpush
