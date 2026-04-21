{{--
================================================================================
FILE        : show.blade.php
DESKRIPSI   : Halaman detail tagihan SPP. Menampilkan informasi lengkap
              tentang tagihan tertentu termasuk rincian nominal, diskon,
              denda, dan informasi santri terkait.
LOKASI      : resources/views/wali/tagihan/show.blade.php
CONTROLLER  : Wali\TagihanController@show
ROUTE       : wali.tagihan.show (GET /wali/tagihan/{tagihan})
================================================================================
--}}

{{-- Menggunakan layout wali sebagai kerangka halaman --}}
@extends('layouts.wali')

{{-- Judul halaman --}}
@section('title', 'Detail Tagihan')

{{-- Konten utama --}}
@section('content')
    {{-- 
    ============================================================================
    PAGE HEADER DENGAN TOMBOL KEMBALI
    ============================================================================
    --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Tagihan</h1>
        </div>
        {{-- Tombol kembali ke daftar tagihan --}}
        <a href="{{ route('wali.tagihan.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    {{-- 
    ============================================================================
    GRID LAYOUT 2 KOLOM
    ============================================================================
    col-6 = 50% lebar untuk setiap kolom
    --}}
    <div class="row">
        {{-- KOLOM KIRI: Informasi Tagihan --}}
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Tagihan</h3>
                </div>
                <div class="card-body">
                    {{-- Tabel detail tagihan --}}
                    <table class="table">
                        <tr>
                            <td><strong>Nama Tagihan</strong></td>
                            <td>{{ $tagihan->nama_tagihan }}</td>
                        </tr>
                        <tr>
                            <td><strong>Periode</strong></td>
                            <td>{{ $tagihan->periode ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Nominal</strong></td>
                            <td>Rp {{ number_format($tagihan->nominal, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Diskon</strong></td>
                            <td>Rp {{ number_format($tagihan->diskon, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Denda</strong></td>
                            <td>Rp {{ number_format($tagihan->denda, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Total Bayar</strong></td>
                            {{-- Total ditampilkan tebal untuk penekanan --}}
                            <td><strong>Rp {{ number_format($tagihan->total_bayar, 0, ',', '.') }}</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Jatuh Tempo</strong></td>
                            <td>{{ $tagihan->tanggal_jatuh_tempo->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>
                                {{-- 
                                ============================================================================
                                STATUS BADGE
 ============================================================================
                                @switch: Menampilkan badge berbeda berdasarkan status tagihan
                                --}}
                                @switch($tagihan->status)
                                    @case('lunas') 
                                        <span class="badge badge-success">Lunas</span> 
                                        @break
                                    @case('belum_bayar') 
                                        <span class="badge badge-warning">Belum Bayar</span> 
                                        @break
                                    @case('jatuh_tempo') 
                                        <span class="badge badge-danger">Jatuh Tempo</span> 
                                        @break
                                @endswitch
                            </td>
                        </tr>
                    </table>

                    {{-- 
                    ============================================================================
                    TOMBOL BAYAR
                    ============================================================================
                    Hanya muncul jika tagihan belum lunas
                    Menggunakan class w-100 untuk lebar penuh
                    --}}
                    @if($tagihan->status != 'lunas')
                        <a href="{{ route('wali.pembayaran.bayar', $tagihan) }}" class="btn btn-primary w-100">
                            <i class="bi bi-credit-card"></i> Bayar Sekarang
                        </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: Informasi Santri --}}
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Santri</h3>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <td><strong>NIS</strong></td>
                            {{-- Mengakses relasi santri --}}
                            <td>{{ $tagihan->santri->nis }}</td>
                        </tr>
                        <tr>
                            <td><strong>Nama</strong></td>
                            <td>{{ $tagihan->santri->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <td><strong>Kelas</strong></td>
                            <td>
                                {{-- 
                                Nested relation: santri->kelas
                                Null coalescing (??) untuk handle jika relasi null
                                --}}
                                {{ $tagihan->santri->kelas->nama_kelas ?? '-' }}
                            </td>
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

1. Highlight card jatuh tempo:
   @if($tagihan->status == 'jatuh_tempo') 
       <div class="card" style="border: 2px solid #dc3545;">
   @endif

2. Progress bar pembayaran:
   <div class="progress">
       <div class="progress-bar" style="width: {{ $persentasi }}%"></div>
   </div>

3. Timeline pembayaran:
   <div class="timeline">
       <div class="timeline-item {{ $tagihan->status == 'lunas' ? 'completed' : '' }}">
           <span>Dibuat</span>
       </div>
       <div class="timeline-item {{ $tagihan->status == 'lunas' ? 'completed' : '' }}">
           <span>Dibayar</span>
       </div>
   </div>

4. Card dengan icon:
   <div class="card">
       <div class="card-body d-flex align-items-center">
           <i class="bi bi-person-circle fs-1 me-3"></i>
           <div>
               <h5>{{ $tagihan->santri->nama_lengkap }}</h5>
               <p class="mb-0 text-muted">{{ $tagihan->santri->nis }}</p>
           </div>
       </div>
   </div>
================================================================================
--}}
