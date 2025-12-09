@extends('layouts.admin')

@section('title', 'Laporan')

@section('content')
    <div class="page-header"><div><h1 class="page-title">Laporan</h1><p class="page-subtitle">Pilih jenis laporan yang ingin dilihat.</p></div></div>

    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-body" style="text-align: center; padding: 40px;">
                    <div class="stat-icon primary" style="margin: 0 auto 20px; width: 60px; height: 60px; font-size: 1.5rem;">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <h4>Laporan Transaksi</h4>
                    <p class="text-muted">Lihat riwayat semua transaksi pembayaran.</p>
                    <a href="{{ route('admin.laporan.transaksi') }}" class="btn btn-primary">Lihat Laporan</a>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-body" style="text-align: center; padding: 40px;">
                    <div class="stat-icon warning" style="margin: 0 auto 20px; width: 60px; height: 60px; font-size: 1.5rem;">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <h4>Laporan Tunggakan</h4>
                    <p class="text-muted">Lihat daftar santri dengan tagihan belum bayar.</p>
                    <a href="{{ route('admin.laporan.tunggakan') }}" class="btn btn-primary">Lihat Laporan</a>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-body" style="text-align: center; padding: 40px;">
                    <div class="stat-icon info" style="margin: 0 auto 20px; width: 60px; height: 60px; font-size: 1.5rem;">
                        <i class="bi bi-bar-chart"></i>
                    </div>
                    <h4>Rekapitulasi Bulanan</h4>
                    <p class="text-muted">Lihat rekapitulasi tagihan dan pembayaran per bulan.</p>
                    <a href="{{ route('admin.laporan.rekapitulasi') }}" class="btn btn-primary">Lihat Laporan</a>
                </div>
            </div>
        </div>
    </div>
@endsection
