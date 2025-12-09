@extends('layouts.admin')

@section('title', 'Manajemen Pengumuman')

@section('content')
    <div class="page-header">
        <div><h1 class="page-title">Manajemen Pengumuman</h1></div>
        <a href="{{ route('admin.pengumuman.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Tambah</a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead><tr><th>Judul</th><th>Prioritas</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($pengumuman as $p)
                        <tr>
                            <td>{{ $p->judul }}</td>
                            <td><span class="badge badge-{{ $p->prioritas == 'tinggi' ? 'danger' : ($p->prioritas == 'normal' ? 'info' : 'secondary') }}">{{ ucfirst($p->prioritas) }}</span></td>
                            <td><span class="badge badge-{{ $p->is_published ? 'success' : 'warning' }}">{{ $p->is_published ? 'Published' : 'Draft' }}</span></td>
                            <td>{{ $p->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.pengumuman.edit', $p) }}" class="btn btn-sm btn-secondary"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('admin.pengumuman.destroy', $p) }}" method="POST" onsubmit="return confirm('Yakin?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button></form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($pengumuman->hasPages())
            <div class="card-footer">
                {{ $pengumuman->links() }}
            </div>
        @endif
    </div>
@endsection
