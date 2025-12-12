@extends('layouts.admin')

@section('title', 'Manajemen Santri')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Santri</h1>
            <p class="page-subtitle">Kelola data santri.</p>
        </div>
        <div>
            <a href="{{ route('admin.santri.create') }}" class="btn btn-primary">
                <i class="bi bi-plus"></i> Tambah Santri
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table" id="dataTable" style="width:100%">
                <thead>
                    <tr>
                        <th>NIS</th>
                        <th>Nama Lengkap</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($santri as $s)
                        <tr>
                            <td>{{ $s->nis }}</td>
                            <td>{{ $s->nama_lengkap }}</td>
                            <td>{{ $s->kelas->nama_kelas }}</td>
                            <td>{{ $s->jurusan->nama_jurusan ?? '-' }}</td>
                            <td>
                                @switch($s->status)
                                    @case('aktif')
                                        <span class="badge badge-success">Aktif</span>
                                        @break
                                    @case('nonaktif')
                                        <span class="badge badge-warning">Nonaktif</span>
                                        @break
                                    @case('lulus')
                                        <span class="badge badge-info">Lulus</span>
                                        @break
                                    @case('pindah')
                                        <span class="badge badge-secondary">Pindah</span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.santri.show', $s) }}" class="btn btn-sm btn-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.santri.edit', $s) }}" class="btn btn-sm btn-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.santri.destroy', $s) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin ingin menghapus santri ini?')">
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
            order: [[1, 'asc']],
            columnDefs: [
                { orderable: false, targets: -1 }
            ]
        });
    });
</script>
@endpush
