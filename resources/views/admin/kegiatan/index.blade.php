@extends('layouts.admin')

@section('title', 'Manajemen Kegiatan')

@section('content')
    <div class="page-header">
        <div><h1 class="page-title">Manajemen Kegiatan</h1></div>
        <a href="{{ route('admin.kegiatan.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Tambah</a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead><tr><th>Nama Kegiatan</th><th>Tanggal</th><th>Lokasi</th><th>Status</th><th>Published</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($kegiatan as $k)
                        <tr>
                            <td>{{ $k->nama_kegiatan }}</td>
                            <td>{{ $k->tanggal_pelaksanaan->format('d/m/Y') }}</td>
                            <td>{{ $k->lokasi ?? '-' }}</td>
                            <td><span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $k->status)) }}</span></td>
                            <td><span class="badge badge-{{ $k->is_published ? 'success' : 'warning' }}">{{ $k->is_published ? 'Ya' : 'Tidak' }}</span></td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.kegiatan.edit', $k) }}" class="btn btn-sm btn-secondary"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('admin.kegiatan.destroy', $k) }}" method="POST" onsubmit="return confirm('Yakin?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button></form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($kegiatan->hasPages())
            <div class="card-footer">
                {{ $kegiatan->links() }}
            </div>
        @endif
    </div>
@endsection
