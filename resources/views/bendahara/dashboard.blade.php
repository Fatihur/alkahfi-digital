{{--
================================================================================
FILE        : dashboard.blade.php
DESKRIPSI   : Halaman dashboard utama untuk role Bendahara. Menampilkan ringkasan
              data keuangan SPP termasuk total tagihan, pembayaran hari ini,
              pembayaran bulan ini, dan tagihan jatuh tempo. Juga menampilkan
              daftar pembayaran terbaru dalam bentuk tabel.
LOKASI      : resources/views/bendahara/dashboard.blade.php
CONTROLLER  : Bendahara\DashboardController@index
ROUTE       : GET /bendahara/dashboard
================================================================================

CONTOH MODIFIKASI STYLING:
- Ganti warna stat-card: class="stat-icon warning" bisa diganti dengan
  "primary", "success", "danger", "info"
- Tambahkan icon lain dari Bootstrap Icons: https://icons.getbootstrap.com/
- Ubah ukuran kolom: ganti "col-3" menjadi "col-6" untuk tampilan lebih lebar

================================================================================
--}}

{{-- @extends: Directive Blade untuk mewarisi layout utama --}}
{{-- Layout 'layouts.bendahara' berisi struktur HTML dasar, navbar, dan sidebar --}}
@extends('layouts.bendahara')

{{-- @section('title'): Mendefinisikan judul halaman yang akan ditampilkan di tab browser --}}
@section('title', 'Dashboard Bendahara')

{{-- @section('content'): Mendefinisikan konten utama halaman --}}
@section('content')
    
    {{-- PAGE HEADER: Bagian judul dan deskripsi halaman --}}
    {{-- Class "page-header" digunakan untuk styling bagian atas halaman --}}
    <div class="page-header">
        <div>
            {{-- h1.page-title: Judul utama halaman --}}
            <h1 class="page-title">Dashboard Bendahara</h1>
            {{-- p.page-subtitle: Deskripsi singkat halaman --}}
            <p class="page-subtitle">Ringkasan data keuangan SPP.</p>
        </div>
    </div>

    {{-- STATISTIK CARDS: Row berisi 4 kartu statistik --}}
    {{-- Class "row" menggunakan grid system Bootstrap untuk layout --}}
    <div class="row">
        
        {{-- KARTU 1: Total Tagihan Belum Dibayar --}}
        {{-- col-3: Setiap kartu mengambil 3 dari 12 kolom (25% lebar layar) --}}
        <div class="col-3">
            {{-- card stat-card: Komponen kartu khusus untuk statistik --}}
            <div class="card stat-card">
                {{-- stat-header: Bagian header kartu statistik --}}
                <div class="stat-header">
                    {{-- stat-icon warning: Icon dengan background warna kuning/orange --}}
                    <div class="stat-icon warning">
                        {{-- bi bi-receipt: Icon dokumen/struk dari Bootstrap Icons --}}
                        <i class="bi bi-receipt"></i>
                    </div>
                </div>
                {{-- stat-value: Nilai statistik yang ditampilkan --}}
                {{-- number_format(): Fungsi PHP untuk format angka ribuan Indonesia --}}
                {{-- $totalTagihanBelumBayar: Variabel dari controller berisi total nominal --}}
                <div class="stat-value">Rp {{ number_format($totalTagihanBelumBayar, 0, ',', '.') }}</div>
                {{-- stat-label: Label penjelas statistik --}}
                <div class="stat-label">Tagihan Belum Dibayar</div>
            </div>
        </div>

        {{-- KARTU 2: Pembayaran Hari Ini --}}
        <div class="col-3">
            <div class="card stat-card">
                <div class="stat-header">
                    {{-- stat-icon success: Icon dengan background warna hijau --}}
                    <div class="stat-icon success">
                        <i class="bi bi-cash"></i> {{-- Icon uang tunai --}}
                    </div>
                </div>
                {{-- $totalPembayaranHariIni: Total pembayaran yang masuk hari ini --}}
                <div class="stat-value">Rp {{ number_format($totalPembayaranHariIni, 0, ',', '.') }}</div>
                <div class="stat-label">Pembayaran Hari Ini</div>
            </div>
        </div>

        {{-- KARTU 3: Pembayaran Bulan Ini --}}
        <div class="col-3">
            <div class="card stat-card">
                <div class="stat-header">
                    {{-- stat-icon primary: Icon dengan background warna biru utama --}}
                    <div class="stat-icon primary">
                        <i class="bi bi-calendar-check"></i> {{-- Icon kalender ceklis --}}
                    </div>
                </div>
                {{-- $totalPembayaranBulanIni: Total pembayaran bulan berjalan --}}
                <div class="stat-value">Rp {{ number_format($totalPembayaranBulanIni, 0, ',', '.') }}</div>
                <div class="stat-label">Pembayaran Bulan Ini</div>
            </div>
        </div>

        {{-- KARTU 4: Tagihan Jatuh Tempo --}}
        <div class="col-3">
            <div class="card stat-card">
                <div class="stat-header">
                    {{-- Inline style untuk custom warna merah --}}
                    {{-- rgba(239,68,68,0.1): Background merah dengan transparansi 10% --}}
                    {{-- #ef4444: Warna teks merah --}}
                    <div class="stat-icon" style="background: rgba(239,68,68,0.1); color: #ef4444;">
                        <i class="bi bi-exclamation-triangle"></i> {{-- Icon peringatan --}}
                    </div>
                </div>
                {{-- $tagihanJatuhTempo: Jumlah tagihan yang sudah lewat jatuh tempo --}}
                <div class="stat-value">{{ $tagihanJatuhTempo }}</div>
                <div class="stat-label">Tagihan Jatuh Tempo</div>
            </div>
        </div>
    </div>

    {{-- TABEL PEMBAYARAN TERBARU --}}
    {{-- card: Komponen kartu untuk menampung tabel --}}
    <div class="card">
        {{-- card-header: Header kartu dengan judul dan tombol aksi --}}
        <div class="card-header">
            {{-- card-title: Judul bagian tabel --}}
            <h3 class="card-title">Pembayaran Terbaru</h3>
            {{-- Tombol link ke halaman daftar pembayaran lengkap --}}
            {{-- route(): Helper Laravel untuk generate URL dari named route --}}
            <a href="{{ route('bendahara.pembayaran.index') }}" class="btn btn-sm btn-secondary">Lihat Semua</a>
        </div>
        
        {{-- table-responsive: Membuat tabel scrollable di layar kecil --}}
        <div class="table-responsive">
            {{-- table: Class dasar untuk styling tabel Bootstrap --}}
            <table class="table">
                {{-- thead: Bagian header tabel --}}
                <thead>
                    <tr> {{-- tr: Table row (baris) --}}
                        {{-- th: Table header (kolom header) --}}
                        <th>No. Transaksi</th>
                        <th>Santri</th>
                        <th>Tagihan</th>
                        <th>Jumlah</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                {{-- tbody: Bagian body/isi tabel --}}
                <tbody>
                    {{-- @forelse: Loop Blade yang menangani kasus kosong --}}
                    {{-- $pembayaranTerbaru: Collection data pembayaran dari controller --}}
                    {{-- $p: Variable iterator untuk setiap item pembayaran --}}
                    @forelse($pembayaranTerbaru as $p)
                        <tr>
                            {{-- td: Table data (sel data) --}}
                            <td>
                                {{-- code: Tag HTML untuk menampilkan teks monospace (kode/nomor) --}}
                                <code>{{ $p->nomor_transaksi }}</code>
                            </td>
                            {{-- $p->santri: Relasi Eloquent ke model Santri --}}
                            {{-- nama_lengkap: Kolom dari tabel santri --}}
                            <td>{{ $p->santri->nama_lengkap }}</td>
                            {{-- $p->tagihan: Relasi Eloquent ke model Tagihan --}}
                            <td>{{ $p->tagihan->nama_tagihan }}</td>
                            <td>Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                            {{-- format(): Method Carbon untuk format tanggal Indonesia --}}
                            <td>{{ $p->tanggal_bayar->format('d/m/Y H:i') }}</td>
                        </tr>
                    {{-- @empty: Blade directive jika collection kosong --}}
                    @empty
                        <tr>
                            {{-- colspan="5": Menggabungkan 5 kolom menjadi satu --}}
                            {{-- text-center: Class Bootstrap untuk teks rata tengah --}}
                            {{-- text-muted: Class untuk teks berwarna abu-abu --}}
                            <td colspan="5" class="text-center text-muted">Belum ada pembayaran</td>
                        </tr>
                    {{-- @endforelse: Penutup directive forelse --}}
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
{{-- @endsection: Penutup section content --}}
@endsection
