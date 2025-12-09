@extends('layouts.wali')

@section('title', $pengumuman->judul)

@section('content')
    <div class="page-header"><div><h1 class="page-title">{{ $pengumuman->judul }}</h1><p class="page-subtitle">{{ $pengumuman->created_at->format('d M Y') }}</p></div><a href="{{ route('wali.pengumuman.index') }}" class="btn btn-secondary">Kembali</a></div>

    <div class="card">
        <div class="card-body">
            @if($pengumuman->gambar)
                <img src="{{ Storage::url($pengumuman->gambar) }}" style="max-width: 100%; border-radius: 8px; margin-bottom: 20px;">
            @endif
            <div style="line-height: 1.8;">{!! nl2br(e($pengumuman->isi)) !!}</div>
        </div>
    </div>
@endsection
