@extends('layouts.admin')

@section('title', 'Kelola Galeri')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Kelola Galeri</h1>
            <p class="page-subtitle">Kelola galeri foto untuk landing page.</p>
        </div>
        <a href="{{ route('admin.landing.galeri.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Tambah</a>
    </div>

    <div class="card">
        <div class="card-header">
            <form action="{{ route('admin.landing.galeri.index') }}" method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control" placeholder="Cari..." value="{{ request('search') }}" style="width: 200px;">
                <select name="kategori" class="form-control form-select" style="width: 150px;">
                    <option value="">Semua Kategori</option>
                    <option value="umum" {{ request('kategori') == 'umum' ? 'selected' : '' }}>Umum</option>
                    <option value="kegiatan" {{ request('kategori') == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                    <option value="fasilitas" {{ request('kategori') == 'fasilitas' ? 'selected' : '' }}>Fasilitas</option>
                    <option value="prestasi" {{ request('kategori') == 'prestasi' ? 'selected' : '' }}>Prestasi</option>
                </select>
                <button type="submit" class="btn btn-secondary">Filter</button>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Urutan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($galeri as $item)
                    <tr>
                        <td>
                            <img src="{{ Storage::url($item->gambar) }}" alt="" style="width: 60px; height: 45px; object-fit: cover; border-radius: 4px;">
                        </td>
                        <td>
                            <strong>{{ Str::limit($item->judul, 40) }}</strong>
                            @if($item->deskripsi)
                                <br><small class="text-muted">{{ Str::limit($item->deskripsi, 50) }}</small>
                            @endif
                        </td>
                        <td><span class="badge badge-info">{{ ucfirst($item->kategori) }}</span></td>
                        <td>{{ $item->urutan }}</td>
                        <td>
                            <span class="badge badge-{{ $item->is_published ? 'success' : 'secondary' }}">
                                {{ $item->is_published ? 'Aktif' : 'Draft' }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.landing.galeri.edit', $item) }}" class="btn btn-sm btn-secondary"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.landing.galeri.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($galeri->hasPages())
            <div class="card-footer">
                {{ $galeri->links() }}
            </div>
        @endif
    </div>
@endsection
