@extends('layouts.admin')

@section('title', 'Laporan Tunggakan')

@section('content')
    <div class="page-header">
        <div><h1 class="page-title">Laporan Tunggakan</h1><p class="page-subtitle">Daftar santri dengan tagihan belum dibayar.</p></div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead><tr><th>NIS</th><th>Nama Santri</th><th>Kelas</th><th>Tagihan</th><th>Total</th><th>Jatuh Tempo</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($tagihan as $t)
                        <tr>
                            <td>{{ $t->santri->nis }}</td>
                            <td>{{ $t->santri->nama_lengkap }}</td>
                            <td>{{ $t->santri->kelas->nama_kelas ?? '-' }}</td>
                            <td>{{ $t->nama_tagihan }}</td>
                            <td>Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</td>
                            <td>{{ $t->tanggal_jatuh_tempo->format('d/m/Y') }}</td>
                            <td>
                                @if($t->status == 'jatuh_tempo')
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
                <tfoot>
                    <tr style="font-weight: bold; background: var(--bg-body);">
                        <td colspan="4">Total Tunggakan</td>
                        <td colspan="3">Rp {{ number_format($totalTunggakan, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
