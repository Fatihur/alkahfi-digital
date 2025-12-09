@extends('layouts.admin')

@section('title', 'Edit Galeri')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Galeri</h1>
            <p class="page-subtitle">Edit foto galeri.</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.landing.galeri.update', $galeri) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Judul <span class="text-danger">*</span></label>
                            <input type="text" name="judul" class="form-control" value="{{ old('judul', $galeri->judul) }}" required>
                            @error('judul')
                                <div class="text-danger" style="font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select name="kategori" class="form-control form-select" required>
                                <option value="umum" {{ old('kategori', $galeri->kategori) == 'umum' ? 'selected' : '' }}>Umum</option>
                                <option value="kegiatan" {{ old('kategori', $galeri->kategori) == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                                <option value="fasilitas" {{ old('kategori', $galeri->kategori) == 'fasilitas' ? 'selected' : '' }}>Fasilitas</option>
                                <option value="prestasi" {{ old('kategori', $galeri->kategori) == 'prestasi' ? 'selected' : '' }}>Prestasi</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="2">{{ old('deskripsi', $galeri->deskripsi) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Gambar</label>
                            <div class="mb-2">
                                <img src="{{ Storage::url($galeri->gambar) }}" alt="" style="max-height: 120px; border-radius: 4px;">
                            </div>
                            <input type="file" name="gambar" class="form-control" accept="image/*">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Urutan</label>
                            <input type="number" name="urutan" class="form-control" value="{{ old('urutan', $galeri->urutan) }}" min="0">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-check form-switch">
                        <input type="checkbox" name="is_published" class="form-check-input" value="1" {{ old('is_published', $galeri->is_published) ? 'checked' : '' }}>
                        <span>Publikasikan</span>
                    </label>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check"></i> Simpan</button>
                    <a href="{{ route('admin.landing.galeri.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
