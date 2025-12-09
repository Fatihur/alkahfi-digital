@extends('layouts.admin')

@section('title', 'Manajemen Jadwal')

@section('content')
    <div class="page-header">
        <div><h1 class="page-title">Manajemen Jadwal</h1></div>
        <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Tambah</a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead><tr><th>Judul</th><th>Jenis</th><th>Tanggal</th><th>Lokasi</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($jadwal as $j)
                        <tr>
                            <td>{{ $j->judul }}</td>
                            <td><span class="badge badge-info">{{ ucfirst($j->jenis) }}</span></td>
                            <td>{{ $j->tanggal_mulai->format('d/m/Y') }} {{ $j->tanggal_selesai ? '- '.$j->tanggal_selesai->format('d/m/Y') : '' }}</td>
                            <td>{{ $j->lokasi ?? '-' }}</td>
                            <td><span class="badge badge-{{ $j->is_published ? 'success' : 'warning' }}">{{ $j->is_published ? 'Published' : 'Draft' }}</span></td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.jadwal.edit', $j) }}" class="btn btn-sm btn-secondary"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('admin.jadwal.destroy', $j) }}" method="POST" onsubmit="return confirm('Yakin?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button></form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($jadwal->hasPages())
            <div class="card-footer">
                {{ $jadwal->links() }}
            </div>
        @endif
    </div>
@endsection
