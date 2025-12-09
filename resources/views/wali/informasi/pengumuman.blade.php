@extends('layouts.wali')

@section('title', 'Pengumuman')

@section('content')
    <div class="page-header"><div><h1 class="page-title">Pengumuman</h1><p class="page-subtitle">Informasi terbaru dari sekolah.</p></div></div>

    <div class="row">
        @forelse($pengumuman as $p)
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <span class="badge badge-{{ $p->prioritas == 'tinggi' ? 'danger' : ($p->prioritas == 'normal' ? 'info' : 'secondary') }}" style="margin-bottom: 10px;">{{ ucfirst($p->prioritas) }}</span>
                        <h3 style="font-size: 1.1rem; margin-bottom: 8px;">{{ $p->judul }}</h3>
                        <p class="text-muted" style="font-size: 0.8rem;">{{ $p->created_at->format('d M Y') }}</p>
                        <p style="margin-top: 10px;">{{ Str::limit($p->isi, 150) }}</p>
                        <a href="{{ route('wali.pengumuman.show', $p) }}" class="btn btn-sm btn-secondary">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12"><div class="card"><div class="card-body text-center text-muted">Tidak ada pengumuman</div></div></div>
        @endforelse
    </div>
    @if($pengumuman->hasPages())
        <div style="margin-top: 20px;">
            {{ $pengumuman->links() }}
        </div>
    @endif
@endsection
