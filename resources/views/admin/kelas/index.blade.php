@extends('layouts.admin')

@section('title', 'Manajemen Kelas')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Kelas</h1>
            <p class="page-subtitle">Kelola data kelas.</p>
        </div>
        <div>
            <a href="{{ route('admin.kelas.create') }}" class="btn btn-primary">
                <i class="bi bi-plus"></i> Tambah Kelas
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table" id="dataTable" style="width:100%">
                <thead>
                    <tr>
                        <th>Nama Kelas</th>
                        <th>Tingkat</th>
                        <th>Jumlah Santri</th>
                        <th>Status</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kelas as $k)
                        <tr>
                            <td>{{ $k->nama_kelas }}</td>
                            <td>{{ $k->tingkat ?? '-' }}</td>
                            <td>{{ $k->santri_count }} santri</td>
                            <td>
                                @if($k->is_active)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.kelas.edit', $k) }}" class="btn btn-sm btn-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.kelas.destroy', $k) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
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
            order: [[0, 'asc']],
            columnDefs: [
                { orderable: false, targets: -1 }
            ]
        });
    });
</script>
@endpush
