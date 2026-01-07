@extends('layouts.wali')

@section('title', $kegiatan->nama_kegiatan)

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">{{ $kegiatan->nama_kegiatan }}</h1>
            <p class="page-subtitle">
                <i class="bi bi-calendar-event"></i> {{ $kegiatan->tanggal_pelaksanaan->format('d M Y') }}
                <span class="badge badge-info ms-2">{{ ucfirst(str_replace('_', ' ', $kegiatan->status)) }}</span>
            </p>
        </div>
        <a href="{{ route('wali.kegiatan.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    @if($kegiatan->gambar)
                        <div class="mb-4">
                            <img src="{{ asset('storage/' . $kegiatan->gambar) }}" 
                                 alt="{{ $kegiatan->nama_kegiatan }}"
                                 class="img-fluid rounded" 
                                 style="max-width: 100%; max-height: 400px; object-fit: cover;">
                        </div>
                    @endif
                    
                    @if($kegiatan->deskripsi)
                        <div class="content" style="line-height: 1.8; font-size: 1.1rem;">
                            <h4>Deskripsi Kegiatan</h4>
                            {!! nl2br(e($kegiatan->deskripsi)) !!}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="bi bi-info-circle"></i> Detail Kegiatan</h3>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><i class="bi bi-calendar3"></i> <strong>Tanggal</strong></td>
                            <td>{{ $kegiatan->tanggal_pelaksanaan->format('d M Y') }}</td>
                        </tr>
                        @if($kegiatan->waktu_mulai)
                            <tr>
                                <td><i class="bi bi-clock"></i> <strong>Waktu Mulai</strong></td>
                                <td>{{ $kegiatan->waktu_mulai }}</td>
                            </tr>
                        @endif
                        @if($kegiatan->waktu_selesai)
                            <tr>
                                <td><i class="bi bi-clock-fill"></i> <strong>Waktu Selesai</strong></td>
                                <td>{{ $kegiatan->waktu_selesai }}</td>
                            </tr>
                        @endif
                        @if($kegiatan->lokasi)
                            <tr>
                                <td><i class="bi bi-geo-alt"></i> <strong>Lokasi</strong></td>
                                <td>{{ $kegiatan->lokasi }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td><i class="bi bi-flag"></i> <strong>Status</strong></td>
                            <td>
                                <span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $kegiatan->status)) }}</span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
