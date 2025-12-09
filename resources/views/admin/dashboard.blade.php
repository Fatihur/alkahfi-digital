@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Dashboard</h1>
            <p class="page-subtitle">Ringkasan data sistem pembayaran SPP.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-3">
            <div class="card stat-card">
                <div class="stat-header">
                    <div class="stat-icon primary">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
                <div class="stat-value">{{ number_format($totalSantri) }}</div>
                <div class="stat-label">Total Santri Aktif</div>
            </div>
        </div>
        <div class="col-3">
            <div class="card stat-card">
                <div class="stat-header">
                    <div class="stat-icon success">
                        <i class="bi bi-person-check"></i>
                    </div>
                </div>
                <div class="stat-value">{{ number_format($totalWali) }}</div>
                <div class="stat-label">Total Wali Santri</div>
            </div>
        </div>
        <div class="col-3">
            <div class="card stat-card">
                <div class="stat-header">
                    <div class="stat-icon warning">
                        <i class="bi bi-receipt"></i>
                    </div>
                </div>
                <div class="stat-value">Rp {{ number_format($totalTagihan, 0, ',', '.') }}</div>
                <div class="stat-label">Total Tagihan Belum Bayar</div>
            </div>
        </div>
        <div class="col-3">
            <div class="card stat-card">
                <div class="stat-header">
                    <div class="stat-icon info">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                </div>
                <div class="stat-value">Rp {{ number_format($totalPembayaran, 0, ',', '.') }}</div>
                <div class="stat-label">Total Pembayaran Masuk</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <div class="card stat-card">
                <div class="stat-header">
                    <div class="stat-icon warning">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                </div>
                <div class="stat-value">{{ number_format($tagihanBelumBayar) }}</div>
                <div class="stat-label">Tagihan Belum Bayar</div>
            </div>
        </div>
        <div class="col-4">
            <div class="card stat-card">
                <div class="stat-header">
                    <div class="stat-icon success">
                        <i class="bi bi-check-circle"></i>
                    </div>
                </div>
                <div class="stat-value">{{ number_format($tagihanLunas) }}</div>
                <div class="stat-label">Tagihan Lunas</div>
            </div>
        </div>
        <div class="col-4">
            <div class="card stat-card">
                <div class="stat-header">
                    <div class="stat-icon" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                </div>
                <div class="stat-value">{{ number_format($tagihanJatuhTempo) }}</div>
                <div class="stat-label">Tagihan Jatuh Tempo</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pembayaran Terbaru</h3>
                    <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-sm btn-secondary">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Santri</th>
                                <th>Tagihan</th>
                                <th>Jumlah</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pembayaranTerbaru as $p)
                                <tr>
                                    <td>{{ $p->santri->nama_lengkap }}</td>
                                    <td>{{ $p->tagihan->nama_tagihan }}</td>
                                    <td>Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                                    <td>{{ $p->tanggal_bayar->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada pembayaran</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tagihan Mendekati Jatuh Tempo</h3>
                    <a href="{{ route('admin.tagihan.index') }}" class="btn btn-sm btn-secondary">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Santri</th>
                                <th>Tagihan</th>
                                <th>Total</th>
                                <th>Jatuh Tempo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tagihanTerbaru as $t)
                                <tr>
                                    <td>{{ $t->santri->nama_lengkap }}</td>
                                    <td>{{ $t->nama_tagihan }}</td>
                                    <td>Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</td>
                                    <td>{{ $t->tanggal_jatuh_tempo->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Tidak ada tagihan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
