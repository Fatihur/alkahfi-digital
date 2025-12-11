@extends('layouts.admin')

@section('title', 'Kelola Galeri')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Kelola Galeri</h1>
            <p class="page-subtitle">Kelola galeri foto untuk landing page.</p>
        </div>
        <a href="{{ route('admin.landing.galeri.create') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i> Tambah Galeri
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
                        <th>Urutan</th>
                        <th>Status</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($galeri as $item)
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
                                <div class="btn-group">
                                    <a href="{{ route('admin.landing.galeri.edit', $item) }}" class="btn btn-sm btn-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.landing.galeri.destroy', $item) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin hapus?')">
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
            order: [[3, 'asc']],
            columnDefs: [
                { orderable: false, targets: [0, -1] }
            ]
        });
    });
</script>
@endpush
