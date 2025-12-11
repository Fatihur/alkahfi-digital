@extends('layouts.admin')

@section('title', 'Kelola Berita')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Kelola Berita</h1>
            <p class="page-subtitle">Kelola berita dan artikel untuk landing page.</p>
        </div>
        <a href="{{ route('admin.landing.berita.create') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i> Tambah Berita
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table" id="dataTable" style="width:100%">
                <thead>
                    <tr>
                        <th width="80">Gambar</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Views</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($berita as $item)
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
                            <td data-order="{{ $item->tanggal_publikasi?->format('Y-m-d') ?? '' }}">
                                {{ $item->tanggal_publikasi?->format('d/m/Y') ?? '-' }}
                            </td>
                            <td>
                                <div class="btn-group">
                                    @if($item->is_published)
                                        <a href="{{ route('landing.berita.detail', $item->slug) }}" target="_blank" class="btn btn-sm btn-info" title="Lihat">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.landing.berita.edit', $item) }}" class="btn btn-sm btn-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.landing.berita.destroy', $item) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin hapus?')">
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
            order: [[5, 'desc']],
            columnDefs: [
                { orderable: false, targets: [0, -1] }
            ]
        });
    });
</script>
@endpush
