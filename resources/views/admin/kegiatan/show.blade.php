{{--
================================================================================
FILE        : show.blade.php
DESKRIPSI   : Halaman detail untuk menampilkan informasi lengkap kegiatan.
              Menampilkan data dalam layout two-column (8:4 ratio).
LOKASI      : resources/views/admin/kegiatan/show.blade.php
CONTROLLER  : KegiatanController@show
ROUTE       : GET /admin/kegiatan/{id}
================================================================================
--}}

{{-- Memanggil layout utama admin --}}
@extends('layouts.admin')

{{-- Mengisi section title dengan nama kegiatan --}}
@section('title', 'Detail Kegiatan')

{{-- Section konten utama --}}
@section('content')
    {{-- Page Header dengan tombol navigasi --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Kegiatan</h1>
        </div>
        {{-- d-flex gap-2: flexbox dengan gap antar tombol --}}
        <div class="d-flex gap-2">
            {{-- Tombol Edit - Mengarahkan ke halaman edit --}}
            <a href="{{ route('admin.kegiatan.edit', $kegiatan) }}" class="btn btn-secondary">
                <i class="bi bi-pencil"></i> Edit
            </a>
            {{-- Tombol Kembali - Mengarahkan ke halaman index --}}
            <a href="{{ route('admin.kegiatan.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    {{--
        Row dengan 2 kolom
        col-8: konten utama (lebar 66.67%)
        col-4: sidebar informasi (lebar 33.33%)
    --}}
    <div class="row">
        {{-- Kolom Konten Utama --}}
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    {{--
                        Header konten dengan judul dan badges
                        d-flex justify-content-between: flexbox dengan distribusi ruang
                        align-items-start: alignment ke atas
                    --}}
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            {{-- Judul kegiatan dari database --}}
                            <h2 class="mb-2">{{ $kegiatan->nama_kegiatan }}</h2>
                            {{-- Badge group untuk status dan published --}}
                            <div class="d-flex gap-2 mb-3">
                                {{-- Badge Status --}}
                                <span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $kegiatan->status)) }}</span>
                                {{-- Badge Published dengan conditional coloring --}}
                                <span class="badge badge-{{ $kegiatan->is_published ? 'success' : 'warning' }}">
                                    {{ $kegiatan->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- @if($kegiatan->gambar) - Kondisional: hanya tampil jika ada gambar --}}
                    @if($kegiatan->gambar)
                        <div class="mb-4">
                            {{--
                                Gambar kegiatan
                                asset('storage/' . $kegiatan->gambar) - URL ke storage/app/public
                                img-fluid: responsive image Bootstrap
                                rounded: border radius
                                object-fit: cover: memastikan gambar tetap proporsional
                            --}}
                            <img src="{{ asset('storage/' . $kegiatan->gambar) }}"
                                 alt="{{ $kegiatan->nama_kegiatan }}"
                                 class="img-fluid rounded"
                                 style="max-height: 400px; width: 100%; object-fit: cover;">
                        </div>
                    @endif

                    {{-- Kondisional: hanya tampil jika ada deskripsi --}}
                    @if($kegiatan->deskripsi)
                        <div class="content">
                            <h4>Deskripsi</h4>
                            {{--
                                nl2br(e($kegiatan->deskripsi))
                                e() - Laravel helper untuk htmlspecialchars (escape XSS)
                                nl2br() - PHP function untuk mengubah newline jadi <br>
                                {!! !!} - Blade syntax untuk output HTML (raw)
                            --}}
                            {!! nl2br(e($kegiatan->deskripsi)) !!}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Kolom Sidebar Informasi --}}
        <div class="col-4">
            <div class="card">
                {{-- Card Header untuk judul sidebar --}}
                <div class="card-header">
                    <h3 class="card-title">Informasi Kegiatan</h3>
                </div>
                <div class="card-body">
                    {{-- table-borderless: tabel tanpa border --}}
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Tanggal</strong></td>
                            <td>{{ $kegiatan->tanggal_pelaksanaan->format('d/m/Y') }}</td>
                        </tr>
                        {{-- Kondisional untuk waktu mulai --}}
                        @if($kegiatan->waktu_mulai)
                            <tr>
                                <td><strong>Waktu Mulai</strong></td>
                                <td>{{ $kegiatan->waktu_mulai }}</td>
                            </tr>
                        @endif
                        {{-- Kondisional untuk waktu selesai --}}
                        @if($kegiatan->waktu_selesai)
                            <tr>
                                <td><strong>Waktu Selesai</strong></td>
                                <td>{{ $kegiatan->waktu_selesai }}</td>
                            </tr>
                        @endif
                        {{-- Kondisional untuk lokasi --}}
                        @if($kegiatan->lokasi)
                            <tr>
                                <td><strong>Lokasi</strong></td>
                                <td>{{ $kegiatan->lokasi }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>
                                <span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $kegiatan->status)) }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Published</strong></td>
                            <td>
                                <span class="badge badge-{{ $kegiatan->is_published ? 'success' : 'warning' }}">
                                    {{ $kegiatan->is_published ? 'Ya' : 'Tidak' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Dibuat Oleh</strong></td>
                            {{-- $kegiatan->createdBy->name - relasi ke model User --}}
                            <td>{{ $kegiatan->createdBy->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Dibuat</strong></td>
                            {{-- format('d/m/Y H:i') - format tanggal dengan jam --}}
                            <td>{{ $kegiatan->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Terakhir Update</strong></td>
                            <td>{{ $kegiatan->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
