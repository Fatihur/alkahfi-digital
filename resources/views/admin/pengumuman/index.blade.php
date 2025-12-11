@extends('layouts.admin')

@section('title', 'Manajemen Pengumuman')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Pengumuman</h1>
            <p class="page-subtitle">Kelola pengumuman untuk wali santri.</p>
        </div>
        <a href="{{ route('admin.pengumuman.create') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i> Tambah Pengumuman
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table" id="dataTable" style="width:100%">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Prioritas</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pengumuman as $p)
                        <tr>
                            <td>{{ $p->judul }}</td>
                            <td>
                                <span class="badge badge-{{ $p->prioritas == 'tinggi' ? 'danger' : ($p->prioritas == 'normal' ? 'info' : 'secondary') }}">
                                    {{ ucfirst($p->prioritas) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $p->is_published ? 'success' : 'warning' }}">
                                    {{ $p->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                            <td data-order="{{ $p->created_at->format('Y-m-d') }}">
                                {{ $p->created_at->format('d/m/Y') }}
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.pengumuman.edit', $p) }}" class="btn btn-sm btn-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.pengumuman.destroy', $p) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" title="Hapus">
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
            order: [[3, 'desc']],
            columnDefs: [
                { orderable: false, targets: -1 }
            ]
        });
    });
</script>
@endpush
