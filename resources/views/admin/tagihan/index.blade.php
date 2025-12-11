@extends('layouts.admin')

@section('title', 'Manajemen Tagihan')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Tagihan</h1>
            <p class="page-subtitle">Kelola tagihan SPP santri.</p>
        </div>
        <div>
            <a href="{{ route('admin.tagihan.create') }}" class="btn btn-primary">
                <i class="bi bi-plus"></i> Buat Tagihan
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table" id="dataTable" style="width:100%">
                <thead>
                    <tr>
                        <th>Santri</th>
                        <th>Tagihan</th>
                        <th>Total</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tagihan as $t)
                        <tr>
                            <td>
                                <strong>{{ $t->santri->nama_lengkap }}</strong>
                                <br><small class="text-muted">{{ $t->santri->nis }}</small>
                            </td>
                            <td>
                                {{ $t->nama_tagihan }}
                                <br><small class="text-muted">{{ $t->periode ?? '-' }}</small>
                            </td>
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
                                    @case('pending')
                                        <span class="badge badge-info">Pending</span>
                                        @break
                                    @case('jatuh_tempo')
                                        <span class="badge badge-danger">Jatuh Tempo</span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.tagihan.show', $t) }}" class="btn btn-sm btn-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if($t->status !== 'lunas')
                                        <a href="{{ route('admin.tagihan.edit', $t) }}" class="btn btn-sm btn-secondary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.tagihan.destroy', $t) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
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
            order: [[3, 'desc']],
            columnDefs: [
                { orderable: false, targets: -1 }
            ]
        });
    });
</script>
@endpush
