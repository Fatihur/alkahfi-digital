@extends('layouts.admin')

@section('title', 'Edit Kelas')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Kelas</h1>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.kelas.update', $kelas) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                    <input type="text" name="nama_kelas" class="form-control" value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Tingkat</label>
                    <input type="text" name="tingkat" class="form-control" value="{{ old('tingkat', $kelas->tingkat) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $kelas->keterangan) }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-check form-switch">
                        <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ old('is_active', $kelas->is_active) ? 'checked' : '' }}>
                        <span>Aktif</span>
                    </label>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check"></i> Simpan</button>
                    <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
