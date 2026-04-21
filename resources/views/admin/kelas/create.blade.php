{{-- ===================================================== --}}
{{-- FILE: create.blade.php (Kelas) --}}
{{-- DESKRIPSI: Form untuk menambah kelas baru --}}
{{-- LOKASI: resources/views/admin/kelas/create.blade.php --}}
{{-- CONTROLLER: Admin/KelasController@create, @store --}}
{{-- ROUTE: GET /admin/kelas/create, POST /admin/kelas --}}
{{-- ===================================================== --}}

@extends('layouts.admin')

@section('title', 'Tambah Kelas')

@section('content')
    {{-- Header halaman --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Kelas</h1>
        </div>
    </div>

    {{-- Card form --}}
    <div class="card">
        <div class="card-body">
            {{-- Form create kelas --}}
            {{-- Tidak perlu enctype karena tidak ada upload file --}}
            <form action="{{ route('admin.kelas.store') }}" method="POST">
                @csrf
                
                {{-- Input Nama Kelas --}}
                <div class="form-group">
                    <label class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                    <input type="text" name="nama_kelas" class="form-control" value="{{ old('nama_kelas') }}" required>
                </div>
                
                {{-- Input Tingkat --}}
                <div class="form-group">
                    <label class="form-label">Tingkat</label>
                    {{-- placeholder: Contoh nilai yang diharapkan --}}
                    <input type="text" name="tingkat" class="form-control" value="{{ old('tingkat') }}" placeholder="Contoh: VII, VIII, IX">
                </div>
                
                {{-- Textarea Keterangan --}}
                <div class="form-group">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan') }}</textarea>
                </div>
                
                {{-- Tombol aksi --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check"></i> Simpan</button>
                    <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
