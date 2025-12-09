@extends('layouts.bendahara')

@section('title', 'Rekapitulasi')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Rekapitulasi Bulanan</h1>
            <p class="page-subtitle">Tahun {{ $tahun }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <form action="" method="GET" class="d-flex gap-2">
                <select name="tahun" class="form-control form-select" style="width:100px;">
                    @for($y = date('Y'); $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
                <button type="submit" class="btn btn-secondary">Tampilkan</button>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Bulan</th>
                        <th>Total Tagihan</th>
                        <th>Total Pembayaran</th>
                        <th>Selisih</th>
                        <th>Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    @php $grandTagihan = 0; $grandPembayaran = 0; @endphp
                    @foreach($rekapBulanan as $rekap)
                        @php
                            $grandTagihan += $rekap['total_tagihan'];
                            $grandPembayaran += $rekap['total_pembayaran'];
                            $persen = $rekap['total_tagihan'] > 0 ? ($rekap['total_pembayaran'] / $rekap['total_tagihan']) * 100 : 0;
                        @endphp
                        <tr>
                            <td>{{ $rekap['nama_bulan'] }}</td>
                            <td>Rp {{ number_format($rekap['total_tagihan'], 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($rekap['total_pembayaran'], 0, ',', '.') }}</td>
                            <td class="{{ $rekap['selisih'] > 0 ? 'text-danger' : 'text-success' }}">
                                Rp {{ number_format($rekap['selisih'], 0, ',', '.') }}
                            </td>
                            <td>
                                <div style="display:flex;align-items:center;gap:8px;">
                                    <div style="flex:1;height:8px;background:#e5e7eb;border-radius:4px;overflow:hidden;">
                                        <div style="height:100%;width:{{ min($persen, 100) }}%;background:{{ $persen >= 100 ? '#10b981' : '#f59e0b' }};"></div>
                                    </div>
                                    <span style="font-size:0.8rem;">{{ number_format($persen, 1) }}%</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    @php $grandPersen = $grandTagihan > 0 ? ($grandPembayaran / $grandTagihan) * 100 : 0; @endphp
                    <tr style="font-weight:bold;">
                        <td>Total</td>
                        <td>Rp {{ number_format($grandTagihan, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($grandPembayaran, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($grandTagihan - $grandPembayaran, 0, ',', '.') }}</td>
                        <td>{{ number_format($grandPersen, 1) }}%</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
