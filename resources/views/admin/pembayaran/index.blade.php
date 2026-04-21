{{--
================================================================================
FILE        : index.blade.php
DESKRIPSI   : Halaman daftar riwayat pembayaran SPP santri dengan tabel DataTables.
              Menampilkan seluruh transaksi pembayaran dengan informasi lengkap
              seperti nomor transaksi, data santri, tagihan, jumlah bayar, 
              metode pembayaran, tanggal, dan status.
LOKASI      : resources/views/admin/pembayaran/index.blade.php
CONTROLLER  : PembayaranController@index
ROUTE       : GET /admin/pembayaran (name: admin.pembayaran.index)
================================================================================
--}}

{{--
    @extends('layouts.admin')
    Directive Blade yang menyatakan view ini mewarisi layout utama admin.
    Layout ini biasanya berisi struktur HTML dasar, navbar, sidebar, dan footer.
    Semua konten dari section akan di-inject ke dalam layout parent.
--}}
@extends('layouts.admin')

{{--
    @section('title', 'Manajemen Pembayaran')
    Menentukan judul halaman yang akan ditampilkan di tab browser.
    Bagian 'title' ini akan di-render di layout parent menggunakan @yield('title')
--}}
@section('title', 'Manajemen Pembayaran')

{{--
    @section('content')
    Memulai bagian konten utama halaman. Semua HTML di dalam section ini
    akan di-inject ke dalam @yield('content') di layout parent.
--}}
@section('content')
    {{--
        Page Header: Bagian atas halaman yang berisi judul dan deskripsi singkat
        Styling menggunakan class CSS kustom untuk tampilan yang konsisten
    --}}
    <div class="page-header">
        <div>
            {{-- Judul halaman utama dengan class page-title --}}
            <h1 class="page-title">Riwayat Pembayaran</h1>
            {{-- Subtitle/penjelasan singkat fungsi halaman --}}
            <p class="page-subtitle">Lihat riwayat pembayaran SPP santri.</p>
        </div>
    </div>

    {{--
        Card Container: Wrapper untuk tabel data dengan styling card
        Class 'card' dan 'card-body' adalah pola umum untuk komponen UI
    --}}
    <div class="card">
        <div class="card-body">
            {{--
                TABEL DATA PEMBAYARAN
                
                ID 'dataTable' digunakan untuk inisialisasi DataTables JavaScript
                Style width:100% memastikan tabel memenuhi container
                
                STRUKTUR KOLOM TABEL:
                1. No. Transaksi  - Kode unik transaksi (ditampilkan dalam format code)
                2. Santri         - Nama lengkap santri + NIS sebagai secondary info
                3. Tagihan        - Nama tagihan yang dibayar
                4. Jumlah         - Nominal pembayaran dalam format Rupiah
                5. Metode         - Cara pembayaran (tunai/transfer)
                6. Tanggal        - Waktu transaksi dengan sorting support
                7. Status         - Kondisi pembayaran (badge warna)
                8. Aksi           - Tombol detail dan cetak
            --}}
            <table class="table" id="dataTable" style="width:100%">
                <thead>
                    <tr>
                        <th>No. Transaksi</th>
                        <th>Santri</th>
                        <th>Tagihan</th>
                        <th>Jumlah</th>
                        <th>Metode</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        {{-- Width 80px untuk kolom aksi agar tidak terlalu lebar --}}
                        <th width="80">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{--
                        @foreach($pembayaran as $p)
                        Looping melalui collection $pembayaran yang dikirim dari Controller.
                        Variabel $p merepresentasikan satu record pembayaran (model Pembayaran).
                        
                        Relasi yang digunakan:
                        - $p->santri     : Relasi belongsTo ke model Santri
                        - $p->tagihan    : Relasi belongsTo ke model Tagihan
                    --}}
                    @foreach($pembayaran as $p)
                        <tr>
                            {{--
                                Nomor Transaksi: Ditampilkan dalam format <code>
                                untuk styling monospace dan background terang
                            --}}
                            <td><code>{{ $p->nomor_transaksi }}</code></td>
                            
                            {{--
                                Data Santri: Mengakses relasi santri
                                - $p->santri->nama_lengkap : Nama santri
                                - $p->santri->nis          : Nomor Induk Santri
                                <br> membuat baris baru, <small> untuk teks lebih kecil
                                Class 'text-muted' untuk warna abu-abu
                            --}}
                            <td>
                                {{ $p->santri->nama_lengkap }}
                                <br><small class="text-muted">{{ $p->santri->nis }}</small>
                            </td>
                            
                            {{-- Nama tagihan dari relasi tagihan --}}
                            <td>{{ $p->tagihan->nama_tagihan }}</td>
                            
                            {{--
                                FORMAT MATA UANG RUPIAH
                                
                                Fungsi number_format($number, $decimals, $dec_point, $thousands_sep)
                                - $p->jumlah_bayar  : Nilai numerik dari database
                                - 0                 : 0 digit desimal (bilangan bulat)
                                - ','               : Pem separator desimal (Indonesia)
                                - '.'               : Pem separator ribuan (Indonesia)
                                
                                CONTOH OUTPUT: Rp 1.500.000
                                
                                Alternatif: Menggunakan helper Laravel:
                                {{ 'Rp ' . number_format($p->jumlah_bayar, 0, ',', '.') }}
                                atau package laravel-money untuk format lebih kompleks
                            --}}
                            <td>Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                            
                            {{--
                                Format Metode Pembayaran:
                                - ucfirst()          : Kapital huruf pertama
                                - str_replace()      : Ganti underscore dengan spasi
                                Contoh: 'bank_transfer' menjadi 'Bank transfer'
                            --}}
                            <td>{{ ucfirst(str_replace('_', ' ', $p->metode_pembayaran)) }}</td>
                            
                            {{--
                                Tanggal Bayar dengan DataTables Sorting Support
                                
                                Atribut data-order: Digunakan DataTables untuk sorting
                                Format ISO: Y-m-d H:i:s (2024-01-15 14:30:00)
                                
                                Operator ?-> (Nullsafe):
                                - Mencegah error jika $p->tanggal_bayar null
                                - Jika null, gunakan string kosong untuk sorting
                                
                                Format Tampilan: d/m/Y H:i (15/01/2024 14:30)
                                - d = 2 digit hari (01-31)
                                - m = 2 digit bulan (01-12)
                                - Y = 4 digit tahun (2024)
                                - H = 2 digit jam 24-jam (00-23)
                                - i = 2 digit menit (00-59)
                            --}}
                            <td data-order="{{ $p->tanggal_bayar?->format('Y-m-d H:i:s') ?? '' }}">
                                {{-- Ternary operator: tampilkan '-' jika tanggal null --}}
                                {{ $p->tanggal_bayar?->format('d/m/Y H:i') ?? '-' }}
                            </td>
                            
                            {{--
                                BADGE STATUS PEMBAYARAN
                                
                                @switch($p->status)
                                Directive Blade untuk multi-conditional rendering
                                Mirip dengan switch-case di PHP
                                
                                Kelas Badge Bootstrap (dapat dimodifikasi):
                                - badge-success   : Hijau (berhasil)
                                - badge-warning   : Kuning (pending)
                                - badge-danger    : Merah (gagal)
                                - badge-secondary : Abu-abu (expired)
                                
                                CONTOH MODIFIKASI STYLING:
                                @case('berhasil')
                                    <span class="badge" style="background: #28a745; color: white; padding: 5px 10px; border-radius: 4px;">
                                        <i class="bi bi-check-circle"></i> Berhasil
                                    </span>
                                    @break
                            --}}
                            <td>
                                @switch($p->status)
                                    @case('berhasil')
                                        <span class="badge badge-success">Berhasil</span>
                                        @break
                                    @case('pending')
                                        <span class="badge badge-warning">Pending</span>
                                        @break
                                    @case('gagal')
                                        <span class="badge badge-danger">Gagal</span>
                                        @break
                                    @case('expired')
                                        <span class="badge badge-secondary">Expired</span>
                                        @break
                                @endswitch
                            </td>
                            
                            {{--
                                KOLOM AKSI
                                
                                btn-group: Mengelompokkan tombol secara horizontal
                                
                                Tombol 1 - Detail (selalu tampil):
                                - route('admin.pembayaran.show', $p) : URL ke halaman detail
                                - $p secara otomatis menggunakan route model binding
                                - btn-info : Warna biru muda
                                - bi bi-eye : Icon Bootstrap Icons (mata)
                                
                                Tombol 2 - Cetak (kondisional):
                                - @if($p->status == 'berhasil') : Hanya tampil jika berhasil
                                - target="_blank" : Buka di tab baru
                                - btn-primary : Warna biru
                                - bi bi-printer : Icon printer
                                
                                CONTOH TAMBAHAN TOMBOL:
                                @if(auth()->user()->can('delete-pembayaran'))
                                    <form action="{{ route('admin.pembayaran.destroy', $p) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            --}}
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.pembayaran.show', $p) }}" class="btn btn-sm btn-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if($p->status == 'berhasil')
                                        <a href="{{ route('admin.pembayaran.cetak', $p) }}" class="btn btn-sm btn-primary" target="_blank" title="Cetak">
                                            <i class="bi bi-printer"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    {{-- @endforeach menutup loop --}}
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
{{-- @endsection menutup section content --}}
@endsection

{{--
    @push('scripts')
    Menambahkan konten ke stack 'scripts' yang didefinisikan di layout parent.
    Stack ini biasanya ditempatkan sebelum </body> atau di bagian head.
    Berguna untuk menambahkan JavaScript khusus halaman ini saja.
--}}
@push('scripts')
{{-- Script untuk inisialisasi DataTables --}}
<script>
    // $(document).ready() memastikan DOM sudah sepenuhnya dimuat
    $(document).ready(function() {
        // Inisialisasi DataTables pada elemen dengan id 'dataTable'
        $('#dataTable').DataTable({
            // order: Mengatur kolom default untuk sorting
            // [5, 'desc'] = Kolom ke-6 (Tanggal), urutan descending (terbaru dulu)
            order: [[5, 'desc']],
            
            // columnDefs: Konfigurasi khusus untuk kolom tertentu
            // targets: -1 = kolom terakhir (Aksi)
            // orderable: false = kolom ini tidak bisa di-sort
            columnDefs: [
                { orderable: false, targets: -1 }
            ]
            
            // CONTOH KONFIGURASI TAMBAHAN:
            // language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json' },
            // pageLength: 25,
            // responsive: true
        });
    });
</script>
@endpush
