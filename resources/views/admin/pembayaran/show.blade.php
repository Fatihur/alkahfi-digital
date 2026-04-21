{{--
================================================================================
FILE        : show.blade.php
DESKRIPSI   : Halaman detail pembayaran yang menampilkan informasi lengkap
              tentang satu transaksi pembayaran. Menampilkan data pembayaran,
              informasi santri, dan detail verifikasi jika ada.
              Dilengkapi tombol cetak bukti dan navigasi kembali.
LOKASI      : resources/views/admin/pembayaran/show.blade.php
CONTROLLER  : PembayaranController@show
ROUTE       : GET /admin/pembayaran/{pembayaran} (name: admin.pembayaran.show)
================================================================================
--}}

{{--
    @extends('layouts.admin')
    Directive Blade yang menyatakan view ini mewarisi layout utama admin.
    Semua section yang didefinisikan akan di-inject ke layout parent.
--}}
@extends('layouts.admin')

{{--
    @section('title', 'Detail Pembayaran')
    Menentukan judul halaman yang ditampilkan di tab browser.
--}}
@section('title', 'Detail Pembayaran')

{{--
    @section('content')
    Memulai bagian konten utama halaman yang akan di-render di @yield('content').
--}}
@section('content')
    {{--
        PAGE HEADER
        
        Bagian atas halaman yang berisi:
        - Judul halaman dan nomor transaksi (sebagai identifier unik)
        - Tombol aksi (Cetak Bukti dan Kembali)
        
        Class styling:
        - page-header: Wrapper dengan margin-bottom
        - d-flex gap-2: Flexbox untuk tombol dengan jarak antar elemen
    --}}
    <div class="page-header">
        <div>
            {{-- Judul halaman utama --}}
            <h1 class="page-title">Detail Pembayaran</h1>
            {{--
                Subtitle: Menampilkan nomor transaksi dari model pembayaran
                $pembayaran->nomor_transaksi di-pass dari controller
                Contoh: TRX-2024-00123
            --}}
            <p class="page-subtitle">{{ $pembayaran->nomor_transaksi }}</p>
        </div>
        {{--
            TOMBOL AKSI HEADER
            
            d-flex gap-2: Flexbox horizontal dengan gap 0.5rem
        --}}
        <div class="d-flex gap-2">
            {{--
                TOMBOL CETAK BUKTI (Kondisional)
                
                @if($pembayaran->status == 'berhasil')
                Directive Blade untuk kondisional rendering.
                Tombol hanya muncul jika status pembayaran adalah 'berhasil'.
                
                route('admin.pembayaran.cetak', $pembayaran):
                - Generate URL ke halaman cetak
                - $pembayaran secara otomatis di-bind ke route parameter
                
                target="_blank": Buka halaman cetak di tab baru
                btn-primary: Styling tombol warna biru
                bi bi-printer: Icon printer dari Bootstrap Icons
                
                CONTOH MODIFIKASI:
                @if(in_array($pembayaran->status, ['berhasil', 'pending']))
            --}}
            @if($pembayaran->status == 'berhasil')
                <a href="{{ route('admin.pembayaran.cetak', $pembayaran) }}" class="btn btn-primary" target="_blank">
                    <i class="bi bi-printer"></i> Cetak Bukti
                </a>
            @endif
            {{--
                TOMBOL KEMBALI
                
                Redirect ke halaman daftar pembayaran
                btn-secondary: Warna abu-abu untuk aksi sekunder
            --}}
            <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    {{--
        LAYOUT 2 KOLOM
        
        Grid Bootstrap dengan struktur:
        - col-6: Masing-masing kolom 50% lebar
        - Kolom Kiri: Informasi Pembayaran
        - Kolom Kanan: Informasi Santri + Verifikasi
    --}}
    <div class="row">
        {{--
            KOLOM KIRI: INFORMASI PEMBAYARAN
            
            Card yang berisi detail lengkap transaksi dalam format tabel.
            Struktur tabel: 2 kolom (label dan value)
        --}}
        <div class="col-6">
            <div class="card">
                {{-- Card Header dengan judul section --}}
                <div class="card-header"><h3 class="card-title">Informasi Pembayaran</h3></div>
                <div class="card-body">
                    {{--
                        TABEL DETAIL PEMBAYARAN
                        
                        Setiap baris berisi 2 kolom:
                        - Kolom 1: Label dengan tag <strong> (bold)
                        - Kolom 2: Value dari model $pembayaran
                        
                        DATA YANG DITAMPILKAN:
                        1. No. Transaksi  - Kode unik transaksi
                        2. Tagihan        - Nama tagihan dari relasi
                        3. Jumlah Bayar   - Nominal dalam format Rupiah
                        4. Metode         - Cara pembayaran
                        5. Channel        - Channel pembayaran (opsional)
                        6. Tanggal Bayar  - Waktu transaksi
                        7. Status         - Badge status pembayaran
                        8. Catatan        - Catatan tambahan
                    --}}
                    <table class="table">
                        {{-- Baris No. Transaksi --}}
                        <tr>
                            <td><strong>No. Transaksi</strong></td>
                            {{-- Ditampilkan dalam format code untuk monospace styling --}}
                            <td><code>{{ $pembayaran->nomor_transaksi }}</code></td>
                        </tr>
                        {{-- Baris Tagihan --}}
                        <tr>
                            <td><strong>Tagihan</strong></td>
                            {{-- Mengakses relasi tagihan untuk mendapatkan nama --}}
                            <td>{{ $pembayaran->tagihan->nama_tagihan }}</td>
                        </tr>
                        {{-- Baris Jumlah Bayar --}}
                        <tr>
                            <td><strong>Jumlah Bayar</strong></td>
                            <td>
                                {{--
                                    FORMAT MATA UANG RUPIAH
                                    
                                    number_format($number, $decimals, $dec_point, $thousands_sep)
                                    - $pembayaran->jumlah_bayar: Nilai numerik
                                    - 0: Tanpa desimal
                                    - ',': Separator desimal Indonesia
                                    - '.': Separator ribuan Indonesia
                                    
                                    CONTOH OUTPUT: Rp 1.500.000
                                    
                                    strong: Penekanan visual pada nominal
                                --}}
                                <strong>Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</strong>
                            </td>
                        </tr>
                        {{-- Baris Metode Pembayaran --}}
                        <tr>
                            <td><strong>Metode</strong></td>
                            <td>
                                {{--
                                    Format metode pembayaran:
                                    - ucfirst(): Kapitalisasi huruf pertama
                                    - str_replace('_', ' ', ...): Ganti underscore jadi spasi
                                    Contoh: 'bank_transfer' -> 'Bank transfer'
                                --}}
                                {{ ucfirst(str_replace('_', ' ', $pembayaran->metode_pembayaran)) }}
                            </td>
                        </tr>
                        {{-- Baris Channel Pembayaran --}}
                        <tr>
                            <td><strong>Channel</strong></td>
                            <td>
                                {{--
                                    Null Coalescing Operator (??)
                                    Menampilkan '-' jika channel_pembayaran null/kosong
                                    Alternatif: {{ $pembayaran->channel_pembayaran ?: '-' }}
                                --}}
                                {{ $pembayaran->channel_pembayaran ?? '-' }}
                            </td>
                        </tr>
                        {{-- Baris Tanggal Bayar --}}
                        <tr>
                            <td><strong>Tanggal Bayar</strong></td>
                            <td>
                                {{--
                                    Nullsafe Operator (?->) dan Format Tanggal
                                    
                                    $pembayaran->tanggal_bayar?->format('d/m/Y H:i'):
                                    - ?->: Mencegah error jika tanggal_bayar null
                                    - format('d/m/Y H:i'): Format Indonesia
                                      * d = hari (01-31)
                                      * m = bulan (01-12)
                                      * Y = tahun 4 digit (2024)
                                      * H = jam 24-jam (00-23)
                                      * i = menit (00-59)
                                    - ?? '-': Default value jika null
                                    
                                    CONTOH OUTPUT: 15/01/2024 14:30 atau '-'
                                --}}
                                {{ $pembayaran->tanggal_bayar?->format('d/m/Y H:i') ?? '-' }}
                            </td>
                        </tr>
                        {{-- Baris Status --}}
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>
                                {{--
                                    BADGE STATUS PEMBAYARAN
                                    
                                    @switch($pembayaran->status)
                                    Directive Blade untuk multi-conditional rendering
                                    Mirip switch-case di PHP
                                    
                                    Kelas Badge (Bootstrap):
                                    - badge-success: Hijau (berhasil)
                                    - badge-warning: Kuning (pending)
                                    - badge-danger: Merah (gagal)
                                    
                                    CONTOH MODIFIKASI STYLING CUSTOM:
                                    @case('berhasil')
                                        <span style="background: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                                            <i class="bi bi-check-circle"></i> Berhasil
                                        </span>
                                        @break
                                --}}
                                @switch($pembayaran->status)
                                    @case('berhasil') <span class="badge badge-success">Berhasil</span> @break
                                    @case('pending') <span class="badge badge-warning">Pending</span> @break
                                    @case('gagal') <span class="badge badge-danger">Gagal</span> @break
                                @endswitch
                            </td>
                        </tr>
                        {{-- Baris Catatan --}}
                        <tr>
                            <td><strong>Catatan</strong></td>
                            <td>
                                {{-- Menampilkan catatan atau '-' jika kosong --}}
                                {{ $pembayaran->catatan ?? '-' }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{--
            KOLOM KANAN: INFORMASI SANTRI & VERIFIKASI
            
            Terdiri dari 2 card:
            1. Informasi Santri (selalu tampil)
            2. Verifikasi (kondisional, hanya jika diverifikasi)
        --}}
        <div class="col-6">
            {{-- CARD INFORMASI SANTRI --}}
            <div class="card">
                <div class="card-header"><h3 class="card-title">Informasi Santri</h3></div>
                <div class="card-body">
                    {{--
                        Tabel data santri dari relasi $pembayaran->santri
                        Relasi: Pembayaran belongsTo Santri
                    --}}
                    <table class="table">
                        {{-- Baris NIS --}}
                        <tr>
                            <td><strong>NIS</strong></td>
                            {{-- Mengakses properti nis dari relasi santri --}}
                            <td>{{ $pembayaran->santri->nis }}</td>
                        </tr>
                        {{-- Baris Nama --}}
                        <tr>
                            <td><strong>Nama</strong></td>
                            <td>{{ $pembayaran->santri->nama_lengkap }}</td>
                        </tr>
                        {{-- Baris Kelas --}}
                        <tr>
                            <td><strong>Kelas</strong></td>
                            <td>
                                {{--
                                    Relasi bersarang: santri -> kelas -> nama_kelas
                                    ?? '-': Default jika kelas tidak ditemukan
                                --}}
                                {{ $pembayaran->santri->kelas->nama_kelas ?? '-' }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            {{--
                CARD VERIFIKASI (Kondisional)
                
                @if($pembayaran->verifiedBy)
                Hanya ditampilkan jika pembayaran memiliki relasi verifiedBy.
                Ini menandakan pembayaran sudah diverifikasi oleh admin.
                
                Relasi: Pembayaran belongsTo User (verifiedBy)
            --}}
            @if($pembayaran->verifiedBy)
            <div class="card">
                <div class="card-header"><h3 class="card-title">Verifikasi</h3></div>
                <div class="card-body">
                    <table class="table">
                        {{-- Baris Diverifikasi Oleh --}}
                        <tr>
                            <td><strong>Diverifikasi Oleh</strong></td>
                            {{-- Mengakses nama verifier dari relasi verifiedBy --}}
                            <td>{{ $pembayaran->verifiedBy->name }}</td>
                        </tr>
                        {{-- Baris Waktu Verifikasi --}}
                        <tr>
                            <td><strong>Waktu Verifikasi</strong></td>
                            <td>
                                {{-- Format tanggal verifikasi --}}
                                {{ $pembayaran->verified_at?->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
