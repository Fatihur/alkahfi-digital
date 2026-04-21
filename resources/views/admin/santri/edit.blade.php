{{-- ===================================================== --}}
{{-- FILE: edit.blade.php (Santri) --}}
{{-- DESKRIPSI: Form untuk mengedit data santri yang sudah ada --}}
{{--          Mirip dengan create, tapi dengan data yang sudah terisi --}}
{{-- LOKASI: resources/views/admin/santri/edit.blade.php --}}
{{-- CONTROLLER: Admin/SantriController@edit, @update --}}
{{-- ROUTE: GET /admin/santri/{santri}/edit, PUT /admin/santri/{santri} --}}
{{-- ===================================================== --}}

@extends('layouts.admin')

@section('title', 'Edit Santri')

@section('content')
    {{-- Header dengan nama santri yang sedang diedit --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Santri</h1>
            {{-- Menampilkan nama santri dari object $santri --}}
            <p class="page-subtitle">Ubah data: {{ $santri->nama_lengkap }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            {{-- ================================================= --}}
            {{-- FORM EDIT SANTRI --}}
            {{-- ================================================= --}}
            {{-- route dengan parameter: Kirim $santri untuk update --}}
            <form action="{{ route('admin.santri.update', $santri) }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- @method('PUT'): Spoofing method HTTP untuk update --}}
                {{-- HTML form hanya support GET dan POST --}}
                {{-- Laravel akan mengenali ini sebagai request PUT --}}
                @method('PUT')
                
                {{-- ------------------------------------------------ --}}
                {{-- BARIS 1: NIS dan Nama --}}
                {{-- ------------------------------------------------ --}}
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">NIS <span class="text-danger">*</span></label>
                            {{-- old('nis', $santri->nis): Prioritaskan old value, fallback ke data DB --}}
                            <input type="text" name="nis" class="form-control" value="{{ old('nis', $santri->nis) }}" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $santri->nama_lengkap) }}" required>
                        </div>
                    </div>
                </div>

                {{-- ------------------------------------------------ --}}
                {{-- BARIS 2: Jenis Kelamin dan Tempat Lahir --}}
                {{-- ------------------------------------------------ --}}
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" class="form-control form-select" required>
                                {{-- Cek dengan data dari database ($santri->jenis_kelamin) --}}
                                <option value="L" {{ old('jenis_kelamin', $santri->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin', $santri->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $santri->tempat_lahir) }}">
                        </div>
                    </div>
                </div>

                {{-- ------------------------------------------------ --}}
                {{-- BARIS 3: Tanggal Lahir dan Tanggal Masuk --}}
                {{-- ------------------------------------------------ --}}
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Tanggal Lahir</label>
                            {{-- $santri->tanggal_lahir?->format('Y-m-d'): Format tanggal untuk input date --}}
                            {{-- ?->: Null safe operator (tidak error jika null) --}}
                            {{-- 'Y-m-d': Format 2024-03-15 --}}
                            <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $santri->tanggal_lahir?->format('Y-m-d')) }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Tanggal Masuk</label>
                            <input type="date" name="tanggal_masuk" class="form-control" value="{{ old('tanggal_masuk', $santri->tanggal_masuk?->format('Y-m-d')) }}">
                        </div>
                    </div>
                </div>

                {{-- ------------------------------------------------ --}}
                {{-- BARIS 4: Kelas dan Jurusan --}}
                {{-- ------------------------------------------------ --}}
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Kelas <span class="text-danger">*</span></label>
                            <select name="kelas_id" class="form-control form-select" required>
                                {{-- Loop dan pilih yang sesuai dengan data santri --}}
                                @foreach($kelasList as $kelas)
                                    <option value="{{ $kelas->id }}" {{ old('kelas_id', $santri->kelas_id) == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Jurusan</label>
                            <select name="jurusan_id" class="form-control form-select">
                                <option value="">Pilih Jurusan</option>
                                @foreach($jurusanList as $jurusan)
                                    <option value="{{ $jurusan->id }}" {{ old('jurusan_id', $santri->jurusan_id) == $jurusan->id ? 'selected' : '' }}>{{ $jurusan->nama_jurusan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- ------------------------------------------------ --}}
                {{-- BARIS 5: Alamat --}}
                {{-- ------------------------------------------------ --}}
                <div class="form-group">
                    <label class="form-label">Alamat</label>
                    {{-- old('alamat', $santri->alamat): Data dari DB sebagai default --}}
                    <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $santri->alamat) }}</textarea>
                </div>

                {{-- ------------------------------------------------ --}}
                {{-- BARIS 6: Status dan Foto --}}
                {{-- ------------------------------------------------ --}}
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control form-select" required>
                                <option value="aktif" {{ old('status', $santri->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status', $santri->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                <option value="lulus" {{ old('status', $santri->status) == 'lulus' ? 'selected' : '' }}>Lulus</option>
                                <option value="pindah" {{ old('status', $santri->status) == 'pindah' ? 'selected' : '' }}>Pindah</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Foto</label>
                            <input type="file" name="foto" class="form-control" accept="image/*">
                            {{-- Tampilkan nama file foto saat ini jika ada --}}
                            @if($santri->foto)
                                <small class="text-muted">Foto saat ini: {{ $santri->foto }}</small>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- ------------------------------------------------ --}}
                {{-- TOMBOL AKSI --}}
                {{-- ------------------------------------------------ --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.santri.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
