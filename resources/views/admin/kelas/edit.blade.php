{{-- ===================================================== --}}
{{-- FILE: edit.blade.php (Kelas) --}}
{{-- DESKRIPSI: Form untuk mengedit data kelas --}}
{{-- LOKASI: resources/views/admin/kelas/edit.blade.php --}}
{{-- CONTROLLER: Admin/KelasController@edit, @update --}}
{{-- ROUTE: GET /admin/kelas/{kelas}/edit, PUT /admin/kelas/{kelas} --}}
{{-- ===================================================== --}}

@extends('layouts.admin')

@section('title', 'Edit Kelas')

@section('content')
    {{-- Header halaman --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Kelas</h1>
        </div>
    </div>

    {{-- Card form --}}
    <div class="card">
        <div class="card-body">
            {{-- Form update kelas --}}
            <form action="{{ route('admin.kelas.update', $kelas) }}" method="POST">
                @csrf
                @method('PUT')
                
                {{-- Input Nama Kelas --}}
                <div class="form-group">
                    <label class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                    <input type="text" name="nama_kelas" class="form-control" value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required>
                </div>
                
                {{-- Input Tingkat --}}
                <div class="form-group">
                    <label class="form-label">Tingkat</label>
                    <input type="text" name="tingkat" class="form-control" value="{{ old('tingkat', $kelas->tingkat) }}">
                </div>
                
                {{-- Textarea Keterangan --}}
                <div class="form-group">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $kelas->keterangan) }}</textarea>
                </div>
                
                {{-- Switch Toggle Status Aktif --}}
                <div class="form-group">
                    {{-- form-check form-switch: Styling switch toggle Bootstrap --}}
                    <label class="form-check form-switch">
                        {{-- type="checkbox": Input boolean (true/false) --}}
                        {{-- value="1": Nilai yang dikirim jika dicentang --}}
                        {{-- {{ old('is_active', $kelas->is_active) ? 'checked' : '' }}: Centang jika aktif --}}
                        <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ old('is_active', $kelas->is_active) ? 'checked' : '' }}>
                        <span>Aktif</span>
                    </label>
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
