@extends('layouts.admin')

@section('title', 'Kelola Berita')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Kelola Berita</h1>
            <p class="page-subtitle">Kelola berita dan artikel untuk landing page.</p>
        </div>
        <a href="{{ route('admin.landing.berita.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Tambah</a>
    </div>

    <div class="card">
        <div class="card-header">
            <form action="{{ route('admin.landing.berita.index') }}" method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control" placeholder="Cari judul..." value="{{ request('search') }}" style="width: 200px;">
                <select name="kategori" class="form-control form-select" style="width: 150px;">
                    <option value="">Semua Kategori</option>
                    <option value="umum" {{ request('kategori') == 'umum' ? 'selected' : '' }}>Umum</option>
                    <option value="akademik" {{ request('kategori') == 'akademik' ? 'selected' : '' }}>Akademik</option>
                    <option value="kegiatan" {{ request('kategori') == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
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
                        <th>Views</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($berita as $item)
                    <tr>
                        <td>
                            @if($item->gambar)
                                <img src="{{ Storage::url($item->gambar) }}" alt="" style="width: 50px; height: 40px; object-fit: cover; border-radius: 4px;">
                            @else
                                <div style="width: 50px; height: 40px; background: var(--bg-body); border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ Str::limit($item->judul, 40) }}</strong>
                            <br><small class="text-muted">{{ Str::limit(strip_tags($item->konten), 50) }}</small>
                        </td>
                        <td><span class="badge badge-info">{{ ucfirst($item->kategori) }}</span></td>
                        <td>{{ $item->views }}</td>
                        <td>
                            <span class="badge badge-{{ $item->is_published ? 'success' : 'warning' }}">
                                {{ $item->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </td>
                        <td>{{ $item->tanggal_publikasi?->format('d/m/Y') ?? '-' }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                @if($item->is_published)
                                    <a href="{{ route('landing.berita.detail', $item->slug) }}" target="_blank" class="btn btn-sm btn-secondary" title="Lihat"><i class="bi bi-eye"></i></a>
                                @endif
                                <a href="{{ route('admin.landing.berita.edit', $item) }}" class="btn btn-sm btn-secondary" title="Edit"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.landing.berita.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($berita->hasPages())
            <div class="card-footer">
                {{ $berita->links() }}
            </div>
        @endif
    </div>
@endsection
