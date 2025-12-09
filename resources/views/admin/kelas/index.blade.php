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
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Kelas</th>
                        <th>Tingkat</th>
                        <th>Jumlah Santri</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kelas as $k)
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
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.kelas.edit', $k) }}" class="btn btn-sm btn-secondary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.kelas.destroy', $k) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Tidak ada data kelas</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($kelas->hasPages())
            <div class="card-footer">
                {{ $kelas->links() }}
            </div>
        @endif
    </div>
@endsection
