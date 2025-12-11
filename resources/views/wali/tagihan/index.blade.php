@extends('layouts.wali')

@section('title', 'Tagihan SPP')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Tagihan SPP</h1>
            <p class="page-subtitle">Daftar tagihan SPP anak Anda.</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table" id="dataTable" style="width:100%">
                <thead>
                    <tr>
                        <th>Santri</th>
                        <th>Tagihan</th>
                        <th>Periode</th>
                        <th>Total</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                        <th width="80">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tagihan as $t)
                        <tr>
                            <td>{{ $t->santri->nama_lengkap }}</td>
                            <td>{{ $t->nama_tagihan }}</td>
                            <td>{{ $t->periode ?? '-' }}</td>
                            <td>Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</td>
                            <td data-order="{{ $t->tanggal_jatuh_tempo->format('Y-m-d') }}">
                                {{ $t->tanggal_jatuh_tempo->format('d/m/Y') }}
                            </td>
                            <td>
                                @switch($t->status)
                                    @case('lunas')
                                        <span class="badge badge-success">Lunas</span>
                                        @break
                                    @case('belum_bayar')
                                        <span class="badge badge-warning">Belum Bayar</span>
                                        @break
                                    @case('jatuh_tempo')
                                        <span class="badge badge-danger">Jatuh Tempo</span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                @if($t->status != 'lunas')
                                    <a href="{{ route('wali.pembayaran.bayar', $t) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-credit-card"></i> Bayar
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
            order: [[4, 'asc']],
            columnDefs: [
                { orderable: false, targets: -1 }
            ]
        });
    });
</script>
@endpush
