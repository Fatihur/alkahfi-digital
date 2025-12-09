@extends('layouts.wali')

@section('title', $kegiatan->nama_kegiatan)

@section('content')
    <div class="page-header"><div><h1 class="page-title">{{ $kegiatan->nama_kegiatan }}</h1></div><a href="{{ route('wali.kegiatan.index') }}" class="btn btn-secondary">Kembali</a></div>

    <div class="card">
        <div class="card-body">
            @if($kegiatan->gambar)
                <img src="{{ Storage::url($kegiatan->gambar) }}" style="max-width: 100%; border-radius: 8px; margin-bottom: 20px;">
            @endif
            <table class="table" style="margin-bottom: 20px;">
                <tr><td style="width: 150px;"><strong>Tanggal</strong></td><td>{{ $kegiatan->tanggal_pelaksanaan->format('d M Y') }}</td></tr>
                <tr><td><strong>Waktu</strong></td><td>{{ $kegiatan->waktu_mulai ?? '-' }} {{ $kegiatan->waktu_selesai ? '- '.$kegiatan->waktu_selesai : '' }}</td></tr>
                <tr><td><strong>Lokasi</strong></td><td>{{ $kegiatan->lokasi ?? '-' }}</td></tr>
                <tr><td><strong>Status</strong></td><td><span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $kegiatan->status)) }}</span></td></tr>
            </table>
            @if($kegiatan->deskripsi)
                <h4>Deskripsi</h4>
                <div style="line-height: 1.8;">{!! nl2br(e($kegiatan->deskripsi)) !!}</div>
            @endif
        </div>
    </div>
@endsection
