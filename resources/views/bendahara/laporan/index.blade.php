@extends('layouts.bendahara')

@section('title', 'Laporan')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Laporan Keuangan</h1>
            <p class="page-subtitle">Pilih jenis laporan yang ingin dilihat.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <a href="{{ route('bendahara.laporan.transaksi') }}" class="card" style="text-decoration:none;">
                <div class="card-body" style="padding:30px;text-align:center;">
                    <div style="width:60px;height:60px;background:var(--primary-subtle);border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 15px;">
                        <i class="bi bi-receipt" style="font-size:1.5rem;color:var(--primary-color);"></i>
                    </div>
                    <h4>Laporan Transaksi</h4>
                    <p class="text-muted" style="font-size:0.875rem;">Daftar seluruh transaksi pembayaran SPP</p>
                </div>
            </a>
        </div>
        <div class="col-4">
            <a href="{{ route('bendahara.laporan.tunggakan') }}" class="card" style="text-decoration:none;">
                <div class="card-body" style="padding:30px;text-align:center;">
                    <div style="width:60px;height:60px;background:rgba(239,68,68,0.1);border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 15px;">
                        <i class="bi bi-exclamation-triangle" style="font-size:1.5rem;color:#ef4444;"></i>
                    </div>
                    <h4>Laporan Tunggakan</h4>
                    <p class="text-muted" style="font-size:0.875rem;">Daftar tagihan yang belum dibayar</p>
                </div>
            </a>
        </div>
        <div class="col-4">
            <a href="{{ route('bendahara.laporan.rekapitulasi') }}" class="card" style="text-decoration:none;">
                <div class="card-body" style="padding:30px;text-align:center;">
                    <div style="width:60px;height:60px;background:rgba(16,185,129,0.1);border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 15px;">
                        <i class="bi bi-bar-chart" style="font-size:1.5rem;color:#10b981;"></i>
                    </div>
                    <h4>Rekapitulasi</h4>
                    <p class="text-muted" style="font-size:0.875rem;">Rekap bulanan tagihan dan pembayaran</p>
                </div>
            </a>
        </div>
    </div>
@endsection
