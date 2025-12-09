@extends('layouts.admin')

@section('title', 'Tambah Angkatan')

@section('content')
    <div class="page-header">
        <div><h1 class="page-title">Tambah Angkatan</h1></div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.angkatan.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Tahun Angkatan <span class="text-danger">*</span></label>
                    <input type="text" name="tahun_angkatan" class="form-control" value="{{ old('tahun_angkatan') }}" placeholder="Contoh: 2024/2025" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Angkatan</label>
                    <input type="text" name="nama_angkatan" class="form-control" value="{{ old('nama_angkatan') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan') }}</textarea>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check"></i> Simpan</button>
                    <a href="{{ route('admin.angkatan.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
