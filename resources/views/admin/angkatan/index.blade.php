@extends('layouts.admin')

@section('title', 'Manajemen Angkatan')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Angkatan</h1>
            <p class="page-subtitle">Kelola data angkatan.</p>
        </div>
        <div>
            <a href="{{ route('admin.angkatan.create') }}" class="btn btn-primary">
                <i class="bi bi-plus"></i> Tambah Angkatan
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table" id="dataTable" style="width:100%">
                <thead>
                    <tr>
                        <th>Tahun Angkatan</th>
                        <th>Nama Angkatan</th>
                        <th>Jumlah Santri</th>
                        <th>Status</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($angkatan as $a)
                        <tr>
                            <td>{{ $a->tahun_angkatan }}</td>
                            <td>{{ $a->nama_angkatan ?? '-' }}</td>
                            <td>{{ $a->santri_count }} santri</td>
                            <td>
                                @if($a->is_active)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.angkatan.edit', $a) }}" class="btn btn-sm btn-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.angkatan.destroy', $a) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
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
            order: [[0, 'desc']],
            columnDefs: [
                { orderable: false, targets: -1 }
            ]
        });
    });
</script>
@endpush
