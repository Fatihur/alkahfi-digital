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
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tahun Angkatan</th>
                        <th>Nama Angkatan</th>
                        <th>Jumlah Santri</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($angkatan as $a)
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
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.angkatan.edit', $a) }}" class="btn btn-sm btn-secondary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.angkatan.destroy', $a) }}" method="POST" onsubmit="return confirm('Yakin?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted">Tidak ada data angkatan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($angkatan->hasPages())
            <div class="card-footer">
                {{ $angkatan->links() }}
            </div>
        @endif
    </div>
@endsection
