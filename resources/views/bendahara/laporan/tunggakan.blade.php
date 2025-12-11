@extends('layouts.bendahara')

@section('title', 'Laporan Tunggakan')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Laporan Tunggakan</h1>
            <p class="page-subtitle">Total Tunggakan: <strong class="text-danger">Rp {{ number_format($totalTunggakan, 0, ',', '.') }}</strong></p>
        </div>
        <a href="{{ route('bendahara.laporan.tunggakan', array_merge(request()->query(), ['export' => 'pdf'])) }}" class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf"></i> Export PDF
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <form action="" method="GET" class="d-flex gap-2">
                <select name="bulan" class="form-control form-select" style="width:130px;">
                    <option value="">Semua Bulan</option>
                    @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $bulan)
                        <option value="{{ $i+1 }}" {{ request('bulan') == $i+1 ? 'selected' : '' }}>{{ $bulan }}</option>
                    @endforeach
                </select>
                <select name="tahun" class="form-control form-select" style="width:100px;">
                    @for($y = date('Y'); $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ request('tahun', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
                <button type="submit" class="btn btn-secondary">Filter</button>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Santri</th>
                        <th>Kelas</th>
                        <th>Tagihan</th>
                        <th>Total</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tagihan as $i => $t)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $t->santri->nama_lengkap }}<br><small class="text-muted">{{ $t->santri->nis }}</small></td>
                            <td>{{ $t->santri->kelas->nama_kelas ?? '-' }}</td>
                            <td>{{ $t->nama_tagihan }}</td>
                            <td>Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</td>
                            <td>{{ $t->tanggal_jatuh_tempo->format('d/m/Y') }}</td>
                            <td>
                                @if($t->status === 'jatuh_tempo')
                                    <span class="badge badge-danger">Jatuh Tempo</span>
                                @else
                                    <span class="badge badge-warning">Belum Bayar</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted">Tidak ada tunggakan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
