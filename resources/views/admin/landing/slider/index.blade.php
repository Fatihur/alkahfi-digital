@extends('layouts.admin')

@section('title', 'Kelola Slider')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Kelola Slider</h1>
            <p class="page-subtitle">Kelola slider/banner untuk landing page.</p>
        </div>
        <a href="{{ route('admin.landing.slider.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Tambah</a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Urutan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sliders as $slider)
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
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.landing.slider.edit', $slider) }}" class="btn btn-sm btn-secondary"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.landing.slider.destroy', $slider) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
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
        @if($sliders->hasPages())
            <div class="card-footer">
                {{ $sliders->links() }}
            </div>
        @endif
    </div>
@endsection
