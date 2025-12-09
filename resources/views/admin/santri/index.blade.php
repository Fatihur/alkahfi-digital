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
        <div class="card-header">
            <form action="" method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control" placeholder="Cari nama/NIS..." value="{{ request('search') }}" style="width: 200px;">
                <select name="kelas_id" class="form-control form-select" style="width: 150px;">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                    @endforeach
                </select>
                <select name="status" class="form-control form-select" style="width: 120px;">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    <option value="lulus" {{ request('status') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                    <option value="pindah" {{ request('status') == 'pindah' ? 'selected' : '' }}>Pindah</option>
                </select>
                <button type="submit" class="btn btn-secondary">Filter</button>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>NIS</th>
                        <th>Nama Lengkap</th>
                        <th>Kelas</th>
                        <th>Angkatan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($santri as $s)
                        <tr>
                            <td>{{ $s->nis }}</td>
                            <td>{{ $s->nama_lengkap }}</td>
                            <td>{{ $s->kelas->nama_kelas }}</td>
                            <td>{{ $s->angkatan->tahun_angkatan }}</td>
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
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.santri.show', $s) }}" class="btn btn-sm btn-secondary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.santri.edit', $s) }}" class="btn btn-sm btn-secondary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.santri.destroy', $s) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus santri ini?')">
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
                            <td colspan="6" class="text-center text-muted">Tidak ada data santri</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($santri->hasPages())
            <div class="card-footer">
                {{ $santri->links() }}
            </div>
        @endif
    </div>
@endsection
