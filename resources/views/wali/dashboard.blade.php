@extends('layouts.wali')

@section('title', 'Dashboard Wali Santri')

@section('content')
    <div class="page-header"><div><h1 class="page-title">Selamat Datang, {{ auth()->user()->name }}</h1><p class="page-subtitle">Lihat tagihan SPP dan informasi sekolah.</p></div></div>

    @if($totalTagihan > 0)
    <div class="alert alert-warning">
        <i class="bi bi-exclamation-triangle"></i>
        <span>Anda memiliki tagihan yang belum dibayar sebesar <strong>Rp {{ number_format($totalTagihan, 0, ',', '.') }}</strong></span>
    </div>
    @endif

    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Tagihan Belum Dibayar</h3><a href="{{ route('wali.tagihan.index') }}" class="btn btn-sm btn-secondary">Lihat Semua</a></div>
                <div class="table-responsive">
                    <table class="table">
                        <thead><tr><th>Santri</th><th>Tagihan</th><th>Total</th><th>Jatuh Tempo</th><th>Aksi</th></tr></thead>
                        <tbody>
                            @forelse($tagihanBelumBayar as $t)
                                <tr>
                                    <td>{{ $t->santri->nama_lengkap }}</td>
                                    <td>{{ $t->nama_tagihan }}</td>
                                    <td>Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</td>
                                    <td>
                                        {{ $t->tanggal_jatuh_tempo->format('d/m/Y') }}
                                        @if($t->status == 'jatuh_tempo')
                                            <span class="badge badge-danger">Jatuh Tempo</span>
                                        @endif
                                    </td>
                                    <td><a href="{{ route('wali.pembayaran.bayar', $t) }}" class="btn btn-sm btn-primary">Bayar</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted">Tidak ada tagihan</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Pengumuman Terbaru</h3></div>
                <div class="card-body">
                    @forelse($pengumumanTerbaru as $p)
                        <div style="margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid var(--border-color);">
                            <h4 style="font-size: 0.9rem; margin-bottom: 4px;">{{ $p->judul }}</h4>
                            <p class="text-muted" style="font-size: 0.8rem; margin: 0;">{{ $p->created_at->format('d M Y') }}</p>
                        </div>
                    @empty
                        <p class="text-muted text-center">Tidak ada pengumuman</p>
                    @endforelse
                </div>
            </div>
            <div class="card">
                <div class="card-header"><h3 class="card-title">Kegiatan Mendatang</h3></div>
                <div class="card-body">
                    @forelse($kegiatanMendatang as $k)
                        <div style="margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid var(--border-color);">
                            <h4 style="font-size: 0.9rem; margin-bottom: 4px;">{{ $k->nama_kegiatan }}</h4>
                            <p class="text-muted" style="font-size: 0.8rem; margin: 0;">{{ $k->tanggal_pelaksanaan->format('d M Y') }}</p>
                        </div>
                    @empty
                        <p class="text-muted text-center">Tidak ada kegiatan</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
