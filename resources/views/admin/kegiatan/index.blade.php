@extends('layouts.admin')

@section('title', 'Manajemen Kegiatan')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Kegiatan</h1>
            <p class="page-subtitle">Kelola kegiatan sekolah.</p>
        </div>
        <a href="{{ route('admin.kegiatan.create') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i> Tambah Kegiatan
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table" id="dataTable" style="width:100%">
                <thead>
                    <tr>
                        <th>Nama Kegiatan</th>
                        <th>Tanggal</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Published</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kegiatan as $k)
                        <tr>
                            <td>{{ $k->nama_kegiatan }}</td>
                            <td data-order="{{ $k->tanggal_pelaksanaan->format('Y-m-d') }}">
                                {{ $k->tanggal_pelaksanaan->format('d/m/Y') }}
                            </td>
                            <td>{{ $k->lokasi ?? '-' }}</td>
                            <td>
                                <span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $k->status)) }}</span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $k->is_published ? 'success' : 'warning' }}">
                                    {{ $k->is_published ? 'Ya' : 'Tidak' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.kegiatan.edit', $k) }}" class="btn btn-sm btn-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.kegiatan.destroy', $k) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin?')">
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
            order: [[1, 'desc']],
            columnDefs: [
                { orderable: false, targets: -1 }
            ]
        });
    });
</script>
@endpush
