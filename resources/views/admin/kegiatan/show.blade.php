@extends('layouts.admin')

@section('title', 'Detail Kegiatan')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Kegiatan</h1>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.kegiatan.edit', $kegiatan) }}" class="btn btn-secondary">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('admin.kegiatan.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h2 class="mb-2">{{ $kegiatan->nama_kegiatan }}</h2>
                            <div class="d-flex gap-2 mb-3">
                                <span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $kegiatan->status)) }}</span>
                                <span class="badge badge-{{ $kegiatan->is_published ? 'success' : 'warning' }}">
                                    {{ $kegiatan->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    @if($kegiatan->gambar)
                        <div class="mb-4">
                            <img src="{{ asset('storage/' . $kegiatan->gambar) }}" 
                                 alt="{{ $kegiatan->nama_kegiatan }}" 
                                 class="img-fluid rounded" 
                                 style="max-height: 400px; width: 100%; object-fit: cover;">
                        </div>
                    @endif

                    @if($kegiatan->deskripsi)
                        <div class="content">
                            <h4>Deskripsi</h4>
                            {!! nl2br(e($kegiatan->deskripsi)) !!}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Kegiatan</h3>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Tanggal</strong></td>
                            <td>{{ $kegiatan->tanggal_pelaksanaan->format('d/m/Y') }}</td>
                        </tr>
                        @if($kegiatan->waktu_mulai)
                            <tr>
                                <td><strong>Waktu Mulai</strong></td>
                                <td>{{ $kegiatan->waktu_mulai }}</td>
                            </tr>
                        @endif
                        @if($kegiatan->waktu_selesai)
                            <tr>
                                <td><strong>Waktu Selesai</strong></td>
                                <td>{{ $kegiatan->waktu_selesai }}</td>
                            </tr>
                        @endif
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
                            <td>{{ $kegiatan->createdBy->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Dibuat</strong></td>
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