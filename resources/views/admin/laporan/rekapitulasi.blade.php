@extends('layouts.admin')

@section('title', 'Rekapitulasi Bulanan')

@section('content')
    <div class="page-header">
        <div><h1 class="page-title">Rekapitulasi Bulanan</h1><p class="page-subtitle">Tahun {{ $tahun }}</p></div>
        <form action="" method="GET" class="d-flex gap-2">
            <select name="tahun" class="form-control form-select" style="width: 120px;" onchange="this.form.submit()">
                @for($y = date('Y'); $y >= 2020; $y--)
                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </form>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Bulan</th>
                        <th>Total Tagihan</th>
                        <th>Total Pembayaran</th>
                        <th>Selisih</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rekapBulanan as $rekap)
                        <tr>
                            <td>{{ $rekap['nama_bulan'] }}</td>
                            <td>Rp {{ number_format($rekap['total_tagihan'], 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($rekap['total_pembayaran'], 0, ',', '.') }}</td>
                            <td class="{{ $rekap['selisih'] > 0 ? 'text-danger' : 'text-success' }}">
                                Rp {{ number_format($rekap['selisih'], 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
