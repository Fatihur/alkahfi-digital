@extends('layouts.admin')

@section('title', 'Kelola Slider')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Kelola Slider</h1>
            <p class="page-subtitle">Kelola slider/banner untuk landing page.</p>
        </div>
        <a href="{{ route('admin.landing.slider.create') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i> Tambah Slider
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table" id="dataTable" style="width:100%">
                <thead>
                    <tr>
                        <th width="120">Gambar</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Urutan</th>
                        <th>Status</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sliders as $slider)
                        <tr>
                            <td>
                                <img src="{{ Storage::url($slider->gambar) }}" alt="" style="width: 100px; height: 50px; object-fit: cover; border-radius: 4px;">
                            </td>
                            <td><strong>{{ $slider->judul ?? '-' }}</strong></td>
                            <td><small class="text-muted">{{ Str::limit($slider->deskripsi, 50) ?? '-' }}</small></td>
                            <td>{{ $slider->urutan }}</td>
                            <td>
                                <span class="badge badge-{{ $slider->is_active ? 'success' : 'secondary' }}">
                                    {{ $slider->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.landing.slider.edit', $slider) }}" class="btn btn-sm btn-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.landing.slider.destroy', $slider) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin hapus?')">
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
