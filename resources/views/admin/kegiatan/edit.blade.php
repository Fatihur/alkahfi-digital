{{--
================================================================================
FILE        : edit.blade.php
DESKRIPSI   : Halaman form untuk mengedit data kegiatan yang sudah ada.
              Form ini diisi dengan data existing dari database.
LOKASI      : resources/views/admin/kegiatan/edit.blade.php
CONTROLLER  : KegiatanController@edit (GET), KegiatanController@update (PUT)
ROUTE       : GET /admin/kegiatan/{id}/edit, PUT /admin/kegiatan/{id}
================================================================================
--}}

{{-- Memanggil layout utama admin --}}
@extends('layouts.admin')

{{-- Mengisi section title --}}
@section('title', 'Edit Kegiatan')

{{-- Section konten utama --}}
@section('content')
    {{-- Page Header --}}
    <div class="page-header"><div><h1 class="page-title">Edit Kegiatan</h1></div></div>

    {{-- Card Container --}}
    <div class="card">
        <div class="card-body">
            {{--
                Form Edit Kegiatan
                route('admin.kegiatan.update', $kegiatan) - mengirim parameter kegiatan
                method="POST" dengan @method('PUT') - Laravel method spoofing
            --}}
            <form action="{{ route('admin.kegiatan.update', $kegiatan) }}" method="POST" enctype="multipart/form-data">
                {{-- CSRF Token --}}
                @csrf
                {{-- Method Spoofing untuk PUT request --}}
                @method('PUT')

                {{-- Input Nama Kegiatan dengan old() helper --}}
                <div class="form-group">
                    <label class="form-label">Nama Kegiatan <span class="text-danger">*</span></label>
                    {{--
                        old('nama_kegiatan', $kegiatan->nama_kegiatan)
                        old() helper: mengembalikan nilai input sebelumnya jika ada error validasi
                        parameter kedua: default value dari database jika tidak ada old value
                    --}}
                    <input type="text" name="nama_kegiatan" class="form-control" value="{{ old('nama_kegiatan', $kegiatan->nama_kegiatan) }}" required>
                </div>

                {{-- Input Deskripsi --}}
                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $kegiatan->deskripsi) }}</textarea>
                </div>

                {{-- Row untuk Tanggal dan Lokasi --}}
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Tanggal Pelaksanaan <span class="text-danger">*</span></label>
                            {{--
                                format('Y-m-d') - format untuk input type="date"
                                HTML5 date input memerlukan format YYYY-MM-DD
                            --}}
                            <input type="date" name="tanggal_pelaksanaan" class="form-control" value="{{ old('tanggal_pelaksanaan', $kegiatan->tanggal_pelaksanaan->format('Y-m-d')) }}" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi', $kegiatan->lokasi) }}">
                        </div>
                    </div>
                </div>

                {{-- Row untuk Status dan Gambar --}}
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control form-select" required>
                                {{--
                                    Conditional selected attribute
                                    $kegiatan->status == 'value' ? 'selected' : ''
                                    Menandai option yang sesuai dengan data di database
                                --}}
                                <option value="akan_datang" {{ $kegiatan->status == 'akan_datang' ? 'selected' : '' }}>Akan Datang</option>
                                <option value="berlangsung" {{ $kegiatan->status == 'berlangsung' ? 'selected' : '' }}>Berlangsung</option>
                                <option value="selesai" {{ $kegiatan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="dibatalkan" {{ $kegiatan->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Gambar</label>
                            <input type="file" name="gambar" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>

                {{-- Checkbox Published --}}
                <div class="form-group">
                    <label class="form-check form-switch">
                        {{--
                            {{ $kegiatan->is_published ? 'checked' : '' }}
                            Menandai checkbox jika kegiatan sudah dipublikasikan
                        --}}
                        <input type="checkbox" name="is_published" class="form-check-input" value="1" {{ $kegiatan->is_published ? 'checked' : '' }}>
                        <span>Published</span>
                    </label>
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check"></i> Simpan</button>
                    <a href="{{ route('admin.kegiatan.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
