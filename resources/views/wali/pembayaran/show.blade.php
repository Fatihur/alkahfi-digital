{{--
================================================================================
FILE        : show.blade.php
DESKRIPSI   : Halaman detail pembayaran. Menampilkan informasi lengkap tentang
              suatu pembayaran termasuk nomor transaksi, jumlah, metode,
              status, dan informasi tagihan terkait.
LOKASI      : resources/views/wali/pembayaran/show.blade.php
CONTROLLER  : Wali\PembayaranController@show
ROUTE       : wali.pembayaran.show (GET /wali/pembayaran/{pembayaran})
================================================================================
--}}

{{-- Menggunakan layout wali sebagai kerangka halaman --}}
@extends('layouts.wali')

{{-- Judul halaman --}}
@section('title', 'Detail Pembayaran')

{{-- Konten utama --}}
@section('content')
    {{-- 
    ============================================================================
    PAGE HEADER DENGAN TOMBOL AKSI
    ============================================================================
    --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Pembayaran</h1>
        </div>
        {{-- d-flex gap-2: Flexbox dengan gap antar elemen --}}
        <div class="d-flex gap-2">
            {{-- Tombol cetak hanya jika pembayaran berhasil --}}
            @if($pembayaran->status == 'berhasil')
                <a href="{{ route('wali.pembayaran.cetak', $pembayaran) }}" 
                   class="btn btn-primary" 
                   target="_blank">
                    <i class="bi bi-printer"></i> Cetak
                </a>
            @endif
            <a href="{{ route('wali.pembayaran.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    {{-- 
    ============================================================================
    GRID LAYOUT 2 KOLOM
    ============================================================================
    --}}
    <div class="row">
        {{-- KOLOM KIRI: Informasi Pembayaran --}}
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Pembayaran</h3>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <td><strong>No. Transaksi</strong></td>
                            <td><code>{{ $pembayaran->nomor_transaksi }}</code></td>
                        </tr>
                        <tr>
                            <td><strong>Jumlah Bayar</strong></td>
                            <td><strong>Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Metode</strong></td>
                            <td>
                                {{-- 
                                ============================================================================
                                FORMAT METODE PEMBAYARAN
                                ============================================================================
                                str_replace('_', ' ', ...): Mengganti underscore dengan spasi
                                ucfirst(): Kapitalisasi huruf pertama
                                Contoh: "virtual_account" menjadi "Virtual account"
                                --}}
                                {{ ucfirst(str_replace('_', ' ', $pembayaran->metode_pembayaran)) }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal</strong></td>
                            <td>{{ $pembayaran->tanggal_bayar?->format('d/m/Y H:i') ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>
                                <span class="badge badge-{{ $pembayaran->status == 'berhasil' ? 'success' : 'warning' }}">
                                    {{ ucfirst($pembayaran->status) }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: Informasi Tagihan --}}
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Tagihan</h3>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <td><strong>Tagihan</strong></td>
                            {{-- Mengakses relasi tagihan --}}
                            <td>{{ $pembayaran->tagihan->nama_tagihan }}</td>
                        </tr>
                        <tr>
                            <td><strong>Santri</strong></td>
                            <td>{{ $pembayaran->santri->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <td><strong>NIS</strong></td>
                            <td>{{ $pembayaran->santri->nis }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

{{--
================================================================================
CONTOH MODIFIKASI STYLING
================================================================================

1. Timeline status pembayaran:
   <div class="timeline">
       <div class="step active">
           <i class="bi bi-1-circle-fill"></i>
           <span>Pending</span>
       </div>
       <div class="step {{ $pembayaran->status == 'berhasil' ? 'active' : '' }}">
           <i class="bi bi-2-circle-fill"></i>
           <span>Berhasil</span>
       </div>
   </div>

2. Card dengan border status:
   <div class="card {{ $pembayaran->status == 'berhasil' ? 'border-success' : 'border-warning' }}">

3. Payment method icon:
   @php
       $icons = [
           'virtual_account' => 'bi-bank',
           'e_wallet' => 'bi-wallet2',
           'retail' => 'bi-shop'
       ];
   @endphp
   <i class="bi {{ $icons[$pembayaran->metode_pembayaran] ?? 'bi-cash' }}"></i>

4. Copy to clipboard untuk nomor transaksi:
   <button onclick="navigator.clipboard.writeText('{{ $pembayaran->nomor_transaksi }}')">
       <i class="bi bi-clipboard"></i>
   </button>
================================================================================
--}}
