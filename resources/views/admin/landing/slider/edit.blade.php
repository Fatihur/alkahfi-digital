@extends('layouts.admin')

@section('title', 'Edit Slider')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Slider</h1>
            <p class="page-subtitle">Edit slider/banner.</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.landing.slider.update', $slider) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label">Judul</label>
                    <input type="text" name="judul" class="form-control" value="{{ old('judul', $slider->judul) }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="2">{{ old('deskripsi', $slider->deskripsi) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Gambar</label>
                            <div class="mb-2">
                                <img src="{{ Storage::url($slider->gambar) }}" alt="" style="max-height: 100px; border-radius: 4px;">
                            </div>
                            <input type="file" name="gambar" class="form-control" accept="image/*">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Urutan</label>
                            <input type="number" name="urutan" class="form-control" value="{{ old('urutan', $slider->urutan) }}" min="0">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-check form-switch">
                        <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ old('is_active', $slider->is_active) ? 'checked' : '' }}>
                        <span>Aktif</span>
                    </label>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check"></i> Simpan</button>
                    <a href="{{ route('admin.landing.slider.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
