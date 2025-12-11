@extends('layouts.admin')

@section('title', 'Manajemen Jadwal')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Jadwal</h1>
            <p class="page-subtitle">Kelola jadwal kegiatan sekolah.</p>
        </div>
        <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i> Tambah Jadwal
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table" id="dataTable" style="width:100%">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Jenis</th>
                        <th>Tanggal</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jadwal as $j)
                        <tr>
                            <td>{{ $j->judul }}</td>
                            <td><span class="badge badge-info">{{ ucfirst($j->jenis) }}</span></td>
                            <td data-order="{{ $j->tanggal_mulai->format('Y-m-d') }}">
                                {{ $j->tanggal_mulai->format('d/m/Y') }}
                                {{ $j->tanggal_selesai ? '- '.$j->tanggal_selesai->format('d/m/Y') : '' }}
                            </td>
                            <td>{{ $j->lokasi ?? '-' }}</td>
                            <td>
                                <span class="badge badge-{{ $j->is_published ? 'success' : 'warning' }}">
                                    {{ $j->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.jadwal.edit', $j) }}" class="btn btn-sm btn-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.jadwal.destroy', $j) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin?')">
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
            order: [[2, 'desc']],
            columnDefs: [
                { orderable: false, targets: -1 }
            ]
        });
    });
</script>
@endpush
