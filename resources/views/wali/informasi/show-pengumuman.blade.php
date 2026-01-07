@extends('layouts.wali')

@section('title', $pengumuman->judul)

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">{{ $pengumuman->judul }}</h1>
            <p class="page-subtitle">
                <i class="bi bi-calendar"></i> {{ $pengumuman->created_at->format('d M Y') }}
                @if($pengumuman->prioritas == 'tinggi')
                    <span class="badge badge-danger ms-2">Prioritas Tinggi</span>
                @endif
            </p>
        </div>
        <a href="{{ route('wali.pengumuman.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            @if($pengumuman->gambar)
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $pengumuman->gambar) }}" 
                         alt="{{ $pengumuman->judul }}"
                         class="img-fluid rounded" 
                         style="max-width: 100%; max-height: 400px; object-fit: cover;">
                </div>
            @endif
            
            <div class="content" style="line-height: 1.8; font-size: 1.1rem;">
                {!! nl2br(e($pengumuman->isi)) !!}
            </div>

            @if($pengumuman->tanggal_mulai || $pengumuman->tanggal_selesai)
                <div class="mt-4 p-3" style="background: var(--bg-body); border-radius: 8px;">
                    <h5><i class="bi bi-info-circle"></i> Informasi Periode</h5>
                    @if($pengumuman->tanggal_mulai)
                        <p class="mb-1"><strong>Mulai:</strong> {{ $pengumuman->tanggal_mulai->format('d M Y') }}</p>
                    @endif
                    @if($pengumuman->tanggal_selesai)
                        <p class="mb-0"><strong>Selesai:</strong> {{ $pengumuman->tanggal_selesai->format('d M Y') }}</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endsection
