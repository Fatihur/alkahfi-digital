@extends('layouts.wali')

@section('title', 'Kegiatan')

@section('content')
    <div class="page-header"><div><h1 class="page-title">Kegiatan</h1><p class="page-subtitle">Daftar kegiatan sekolah.</p></div></div>

    <div class="row">
        @forelse($kegiatan as $k)
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <span class="badge badge-{{ $k->status == 'akan_datang' ? 'info' : ($k->status == 'berlangsung' ? 'success' : 'secondary') }}" style="margin-bottom: 10px;">{{ ucfirst(str_replace('_', ' ', $k->status)) }}</span>
                        <h3 style="font-size: 1.1rem; margin-bottom: 8px;">{{ $k->nama_kegiatan }}</h3>
                        <p class="text-muted" style="font-size: 0.8rem;"><i class="bi bi-calendar"></i> {{ $k->tanggal_pelaksanaan->format('d M Y') }} @if($k->lokasi) | <i class="bi bi-geo-alt"></i> {{ $k->lokasi }} @endif</p>
                        @if($k->deskripsi)<p style="margin-top: 10px;">{{ Str::limit($k->deskripsi, 100) }}</p>@endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12"><div class="card"><div class="card-body text-center text-muted">Tidak ada kegiatan</div></div></div>
        @endforelse
    </div>
    @if($kegiatan->hasPages())
        <div style="margin-top: 20px;">
            {{ $kegiatan->links() }}
        </div>
    @endif
@endsection
