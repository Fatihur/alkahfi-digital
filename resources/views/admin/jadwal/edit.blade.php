@extends('layouts.admin')

@section('title', 'Edit Jadwal')

@section('content')
    <div class="page-header"><div><h1 class="page-title">Edit Jadwal</h1></div></div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.jadwal.update', $jadwal) }}" method="POST">
                @csrf @method('PUT')
                <div class="form-group">
                    <label class="form-label">Judul <span class="text-danger">*</span></label>
                    <input type="text" name="judul" class="form-control" value="{{ old('judul', $jadwal->judul) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $jadwal->deskripsi) }}</textarea>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai', $jadwal->tanggal_mulai->format('Y-m-d')) }}" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" class="form-control" value="{{ old('tanggal_selesai', $jadwal->tanggal_selesai?->format('Y-m-d')) }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi', $jadwal->lokasi) }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Jenis <span class="text-danger">*</span></label>
                            <select name="jenis" class="form-control form-select" required>
                                <option value="ujian" {{ $jadwal->jenis == 'ujian' ? 'selected' : '' }}>Ujian</option>
                                <option value="libur" {{ $jadwal->jenis == 'libur' ? 'selected' : '' }}>Libur</option>
                                <option value="kegiatan" {{ $jadwal->jenis == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                                <option value="lainnya" {{ $jadwal->jenis == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-check form-switch">
                        <input type="checkbox" name="is_published" class="form-check-input" value="1" {{ $jadwal->is_published ? 'checked' : '' }}>
                        <span>Published</span>
                    </label>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check"></i> Simpan</button>
                    <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
