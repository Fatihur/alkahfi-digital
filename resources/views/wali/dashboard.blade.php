{{--
================================================================================
FILE        : dashboard.blade.php
DESKRIPSI   : Halaman dashboard utama untuk role Wali Santri. Menampilkan ringkasan
              tagihan belum dibayar, pengumuman terbaru, dan kegiatan mendatang.
              Halaman ini memberikan overview cepat status keuangan dan informasi
              penting sekolah kepada wali santri.
LOKASI      : resources/views/wali/dashboard.blade.php
CONTROLLER  : Wali\DashboardController@index
ROUTE       : GET /wali/dashboard -> wali.dashboard
================================================================================
--}}

{{-- @extends: Mengextends layout utama 'layouts.wali' yang berisi struktur HTML dasar --}}
{{-- Layout ini biasanya mencakup: header, sidebar navigasi, dan footer --}}
@extends('layouts.wali')

{{-- @section('title'): Mendefinisikan judul halaman yang akan ditampilkan di browser tab --}}
@section('title', 'Dashboard Wali Santri')

{{-- @section('content'): Mendefinisikan konten utama halaman --}}
{{-- Semua konten di dalam section ini akan di-render di yield('content') pada layout --}}
@section('content')
    {{-- Header Halaman: Menampilkan sambutan dengan nama user yang sedang login --}}
    {{-- Menggunakan auth()->user()->name untuk mendapatkan nama wali santri dari session --}}
    {{-- Styling: page-header menggunakan flexbox untuk layout, page-title untuk judul utama --}}
    <div class="page-header"><div><h1 class="page-title">Selamat Datang, {{ auth()->user()->name }}</h1><p class="page-subtitle">Lihat tagihan SPP dan informasi sekolah.</p></div></div>

    {{-- Alert Tagihan: Kondisional - hanya muncul jika ada tagihan yang belum dibayar --}}
    {{-- @if: Directive Blade untuk conditional rendering --}}
    {{-- $totalTagihan: Variable dari controller berisi total nominal tagihan pending --}}
    {{-- number_format(): PHP function untuk memformat angka ke format Rupiah --}}
    {{-- Styling: alert-warning memberikan background kuning/orange untuk peringatan --}}
    @if($totalTagihan > 0)
    <div class="alert alert-warning">
        <i class="bi bi-exclamation-triangle"></i>
        <span>Anda memiliki tagihan yang belum dibayar sebesar <strong>Rp {{ number_format($totalTagihan, 0, ',', '.') }}</strong></span>
    </div>
    @endif

    {{-- Layout Grid 2 Kolom: Kolom kiri (8) untuk tabel, kolom kanan (4) untuk info --}}
    {{-- class "row": Bootstrap grid system untuk layout responsif --}}
    <div class="row">
        {{-- Kolom Kiri (8/12): Tabel Tagihan Belum Dibayar --}}
        {{-- Menampilkan daftar tagihan yang perlu segera dibayar oleh wali santri --}}
        <div class="col-8">
            <div class="card">
                {{-- Card Header: Judul dan tombol navigasi ke halaman semua tagihan --}}
                <div class="card-header"><h3 class="card-title">Tagihan Belum Dibayar</h3><a href="{{ route('wali.tagihan.index') }}" class="btn btn-sm btn-secondary">Lihat Semua</a></div>
                <div class="table-responsive">
                    {{-- Tabel Data: Menampilkan tagihan dalam format tabel --}}
                    <table class="table">
                        <thead><tr><th>Santri</th><th>Tagihan</th><th>Total</th><th>Jatuh Tempo</th><th>Aksi</th></tr></thead>
                        <tbody>
                            {{-- @forelse: Loop dengan fallback jika collection kosong --}}
                            {{-- $tagihanBelumBayar: Collection dari model Tagihan dengan status != 'lunas' --}}
                            {{-- $t: Variable iterasi untuk setiap item tagihan --}}
                            @forelse($tagihanBelumBayar as $t)
                                <tr>
                                    {{-- Relasi Eloquent: $t->santri mengakses model Santri terkait --}}
                                    <td>{{ $t->santri->nama_lengkap }}</td>
                                    <td>{{ $t->nama_tagihan }}</td>
                                    {{-- Format Rupiah: number_format untuk tampilan yang mudah dibaca --}}
                                    <td>Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</td>
                                    <td>
                                        {{-- format(): Carbon method untuk memformat tanggal --}}
                                        {{-- 'd/m/Y' = 21/04/2026 format Indonesia --}}
                                        {{ $t->tanggal_jatuh_tempo->format('d/m/Y') }}
                                        {{-- Badge Status: Menampilkan badge jika tagihan sudah jatuh tempo --}}
                                        @if($t->status == 'jatuh_tempo')
                                            <span class="badge badge-danger">Jatuh Tempo</span>
                                        @endif
                                    </td>
                                    {{-- Tombol Aksi: Link ke halaman pembayaran untuk tagihan ini --}}
                                    {{-- route(): Helper untuk generate URL berdasarkan named route --}}
                                    <td><a href="{{ route('wali.pembayaran.bayar', $t) }}" class="btn btn-sm btn-primary">Bayar</a></td>
                                </tr>
                            {{-- @empty: Bagian yang ditampilkan jika $tagihanBelumBayar kosong --}}
                            @empty
                                <tr><td colspan="5" class="text-center text-muted">Tidak ada tagihan</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        {{-- Kolom Kanan (4/12): Sidebar Informasi --}}
        {{-- Menampilkan pengumuman dan kegiatan terbaru --}}
        <div class="col-4">
            {{-- Card Pengumuman Terbaru --}}
            <div class="card">
                <div class="card-header"><h3 class="card-title">Pengumuman Terbaru</h3></div>
                <div class="card-body">
                    {{-- Loop Pengumuman: Menampilkan 5 pengumuman terbaru --}}
                    {{-- $pengumumanTerbaru: Collection dari model Pengumuman, diurutkan by created_at DESC --}}
                    @forelse($pengumumanTerbaru as $p)
                        {{-- Inline Styling: Margin dan border untuk pemisah antar item --}}
                        {{-- var(--border-color): CSS custom property untuk konsistensi warna --}}
                        <div style="margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid var(--border-color);">
                            <h4 style="font-size: 0.9rem; margin-bottom: 4px;">{{ $p->judul }}</h4>
                            {{-- Format Tanggal: Carbon format untuk tampilan singkat --}}
                            <p class="text-muted" style="font-size: 0.8rem; margin: 0;">{{ $p->created_at->format('d M Y') }}</p>
                        </div>
                    @empty
                        <p class="text-muted text-center">Tidak ada pengumuman</p>
                    @endforelse
                </div>
            </div>
            
            {{-- Card Kegiatan Mendatang --}}
            {{-- $kegiatanMendatang: Collection dari model Kegiatan yang tanggalnya >= today --}}
            <div class="card">
                <div class="card-header"><h3 class="card-title">Kegiatan Mendatang</h3></div>
                <div class="card-body">
                    @forelse($kegiatanMendatang as $k)
                        <div style="margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid var(--border-color);">
                            <h4 style="font-size: 0.9rem; margin-bottom: 4px;">{{ $k->nama_kegiatan }}</h4>
                            <p class="text-muted" style="font-size: 0.8rem; margin: 0;">{{ $k->tanggal_pelaksanaan->format('d M Y') }}</p>
                        </div>
                    @empty
                        <p class="text-muted text-center">Tidak ada kegiatan</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
{{-- @endsection: Menutup section content --}}
@endsection

{{-- 
================================================================================
CATATAN PENTING:
================================================================================
1. VARIABLE YANG DIPASSING DARI CONTROLLER:
    - $totalTagihan: integer - Total nominal semua tagihan pending
    - $tagihanBelumBayar: Collection<Tagihan> - Tagihan dengan status != 'lunas'
    - $pengumumanTerbaru: Collection<Pengumuman> - 5 pengumuman terbaru
    - $kegiatanMendatang: Collection<Kegiatan> - Kegiatan dengan tanggal >= hari ini

2. RELASI ELOQUENT YANG DIGUNAKAN:
    - $tagihan->santri: Relasi belongsTo ke model Santri
    - Mengakses property: nama_lengkap, nis, kelas, dll

3. HELPER BLADE YANG DIGUNAKAN:
    - auth()->user(): Mendapatkan user yang sedang login
    - route('name', $param): Generate URL dari named route
    - number_format(): Format angka ke Rupiah
    - format(): Carbon method untuk tanggal

4. MODIFIKASI STYLING YANG MUNGKIN:
    - Ubah grid: ganti col-8/col-4 menjadi col-7/col-5 untuk proporsi berbeda
    - Tambahkan card border: style="border-left: 4px solid var(--warning-color)"
    - Ubah badge warning: class="badge badge-warning" → "badge badge-orange"
    - Tambahkan animasi: style="transition: all 0.3s ease" pada card

5. PENAMBAHAN FITUR:
    - Progress bar tagihan: <div class="progress"><div class="progress-bar"></div></div>
    - Filter santri: Dropdown untuk memilih santri jika memiliki multiple santri
    - Quick actions: Tombol shortcut ke fitur lain
================================================================================
--}}
