{{--
================================================================================
FILE        : show.blade.php
DESKRIPSI   : Halaman detail tagihan yang menampilkan informasi lengkap
              tagihan SPP, data santri, dan riwayat pembayaran terkait.
              Menyediakan view-only interface tanpa fitur edit.
LOKASI      : resources/views/admin/tagihan/show.blade.php
CONTROLLER  : TagihanController@show
ROUTE       : GET /admin/tagihan/{tagihan}
================================================================================
--}}

{{-- 
@extends('layouts.admin')
Menggunakan layout admin sebagai template dasar
Memastikan konsistensi tampilan dengan halaman admin lainnya
--}}
@extends('layouts.admin')

{{-- Section title untuk judul browser tab --}}
@section('title', 'Detail Tagihan')

{{-- Section content berisi konten utama halaman detail --}}
@section('content')
    {{-- 
    Header Halaman
    Berisi judul dan tombol navigasi kembali
    page-header biasanya menggunakan flexbox dengan justify-content: space-between
    --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Tagihan</h1>
        </div>
        {{-- 
        Tombol Kembali
        route('admin.tagihan.index'): URL ke halaman daftar tagihan
        btn btn-secondary: Styling tombol abu-abu (aksi sekunder)
        --}}
        <a href="{{ route('admin.tagihan.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    {{-- 
    ============================================================
    BARIS 1: Informasi Tagihan & Informasi Santri
    Menggunakan grid system 2 kolom (col-6 + col-6 = 12)
    ============================================================
    --}}
    <div class="row">
        {{-- 
        ========================================================
        KOLOM KIRI: Informasi Tagihan
        ========================================================
        --}}
        <div class="col-6">
            <div class="card">
                {{-- Card header dengan judul section --}}
                <div class="card-header"><h3 class="card-title">Informasi Tagihan</h3></div>
                <div class="card-body">
                    {{-- 
                    Tabel informasi tagihan
                    Struktur: 2 kolom (label dan value)
                    Setiap baris menggunakan <tr> dengan 2 <td>
                    --}}
                    <table class="table">
                        {{-- Baris Nama Tagihan --}}
                        <tr>
                            <td><strong>Nama Tagihan</strong></td>
                            <td>{{ $tagihan->nama_tagihan }}</td>
                        </tr>
                        {{-- 
                        Baris Periode
                        Operator ?? '-': Menampilkan '-' jika periode null/empty
                        --}}
                        <tr>
                            <td><strong>Periode</strong></td>
                            <td>{{ $tagihan->periode ?? '-' }}</td>
                        </tr>
                        {{-- Baris Bulan/Tahun --}}
                        <tr>
                            <td><strong>Bulan/Tahun</strong></td>
                            <td>{{ $tagihan->bulan ?? '-' }} / {{ $tagihan->tahun }}</td>
                        </tr>
                        {{-- 
                        Baris Nominal
                        number_format(): Memformat angka dengan pemisah ribuan
                        Hasil: Rp 1.500.000 (dari 1500000)
                        --}}
                        <tr>
                            <td><strong>Nominal</strong></td>
                            <td>Rp {{ number_format($tagihan->nominal, 0, ',', '.') }}</td>
                        </tr>
                        {{-- Baris Diskon --}}
                        <tr>
                            <td><strong>Diskon</strong></td>
                            <td>Rp {{ number_format($tagihan->diskon, 0, ',', '.') }}</td>
                        </tr>
                        {{-- Baris Denda --}}
                        <tr>
                            <td><strong>Denda</strong></td>
                            <td>Rp {{ number_format($tagihan->denda, 0, ',', '.') }}</td>
                        </tr>
                        {{-- 
                        Baris Total Bayar (ditebalkan)
                        Total = Nominal - Diskon + Denda
                        <strong>: Membuat teks menjadi bold
                        --}}
                        <tr>
                            <td><strong>Total Bayar</strong></td>
                            <td><strong>Rp {{ number_format($tagihan->total_bayar, 0, ',', '.') }}</strong></td>
                        </tr>
                        {{-- Baris Tanggal Jatuh Tempo --}}
                        <tr>
                            <td><strong>Jatuh Tempo</strong></td>
                            <td>{{ $tagihan->tanggal_jatuh_tempo->format('d/m/Y') }}</td>
                        </tr>
                        {{-- 
                        Baris Status dengan Badge
                        @switch: Directive Blade untuk kondisi multiple case
                        Badge warna menyesuaikan dengan status:
                        - badge-success (hijau): Lunas
                        - badge-warning (kuning/oranye): Belum Bayar
                        - badge-info (biru): Pending
                        - badge-danger (merah): Jatuh Tempo
                        --}}
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>
                                @switch($tagihan->status)
                                    @case('lunas') <span class="badge badge-success">Lunas</span> @break
                                    @case('belum_bayar') <span class="badge badge-warning">Belum Bayar</span> @break
                                    @case('pending') <span class="badge badge-info">Pending</span> @break
                                    @case('jatuh_tempo') <span class="badge badge-danger">Jatuh Tempo</span> @break
                                @endswitch
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- 
        ========================================================
        KOLOM KANAN: Informasi Santri
        ========================================================
        --}}
        <div class="col-6">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Informasi Santri</h3></div>
                <div class="card-body">
                    <table class="table">
                        {{-- Baris NIS (Nomor Induk Santri) --}}
                        <tr>
                            <td><strong>NIS</strong></td>
                            <td>{{ $tagihan->santri->nis }}</td>
                        </tr>
                        {{-- Baris Nama Lengkap --}}
                        <tr>
                            <td><strong>Nama</strong></td>
                            <td>{{ $tagihan->santri->nama_lengkap }}</td>
                        </tr>
                        {{-- 
                        Baris Kelas
                        Mengakses relasi nested: $tagihan->santri->kelas->nama_kelas
                        Operator ?? '-': Menangani jika santri belum punya kelas
                        --}}
                        <tr>
                            <td><strong>Kelas</strong></td>
                            <td>{{ $tagihan->santri->kelas->nama_kelas ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- 
    ============================================================
    BARIS 2: Riwayat Pembayaran
    Menampilkan daftar pembayaran yang sudah dilakukan untuk tagihan ini
    ============================================================
    --}}
    <div class="card">
        <div class="card-header"><h3 class="card-title">Riwayat Pembayaran</h3></div>
        {{-- 
        table-responsive: Membuat tabel scrollable di mobile device
        Mencegah tabel melebihi lebar layar kecil
        --}}
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No. Transaksi</th>
                        <th>Jumlah</th>
                        <th>Metode</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- 
                    @forelse($tagihan->pembayaran as $p)
                    Looping dengan forelse: kombinasi foreach + empty
                    Jika koleksi pembayaran kosong, bagian @empty akan dieksekusi
                    $tagihan->pembayaran adalah relasi hasMany dari model Tagihan
                    --}}
                    @forelse($tagihan->pembayaran as $p)
                        <tr>
                            {{-- Nomor transaksi unik --}}
                            <td>{{ $p->nomor_transaksi }}</td>
                            {{-- Jumlah pembayaran terformat --}}
                            <td>Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                            {{-- 
                            ucfirst(): Fungsi PHP untuk kapital huruf pertama
                            Misal: "transfer" menjadi "Transfer"
                            --}}
                            <td>{{ ucfirst($p->metode_pembayaran) }}</td>
                            {{-- 
                            Tanggal Bayar dengan null-safe operator (?->)
                            Jika tanggal_bayar null, tampilkan '-'
                            Format: d/m/Y H:i (tanggal/bulan/tahun Jam:Menit)
                            --}}
                            <td>{{ $p->tanggal_bayar?->format('d/m/Y H:i') ?? '-' }}</td>
                            {{-- 
                            Status Pembayaran dengan Badge
                            Kondisi ternary: badge-success jika 'berhasil', badge-warning untuk lainnya
                            ucfirst untuk kapitalisasi
                            --}}
                            <td>
                                <span class="badge badge-{{ $p->status == 'berhasil' ? 'success' : 'warning' }}">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                        </tr>
                    {{-- 
                    @empty
                    Tampilkan pesan jika belum ada pembayaran
                    colspan="5": Merge 5 kolom agar pesan center
                    text-center: Posisi teks tengah
                    text-muted: Warna teks abu-abu
                    --}}
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada pembayaran</td>
                        </tr>
                    {{-- @endforelse: Penutup forelse --}}
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
{{-- Penutup section content --}}
@endsection

{{-- 
CATATAN TAMBAHAN UNTUK DEVELOPER:

1. Relasi Eloquent yang digunakan:
   - $tagihan->santri: belongsTo relationship ke model Santri
   - $tagihan->santri->kelas: belongsTo relationship dari Santri ke Kelas
   - $tagihan->pembayaran: hasMany relationship ke model Pembayaran

2. Contoh modifikasi styling:
   
   A. Menambahkan warna latar berbeda per status:
      @case('lunas') 
          <span class="badge bg-success text-white">Lunas</span> 
      @break
   
   B. Menambahkan icon pada tabel:
      <td><i class="bi bi-cash-stack"></i> Rp {{ number_format(...) }}</td>
   
   C. Card dengan border warna:
      <div class="card border-primary">...</div>
   
   D. Tabel dengan hover effect:
      <table class="table table-hover">...</table>

3. Extension fitur yang mungkin:
   - Tombol "Bayar Sekarang" jika status belum lunas
   - Tombol "Print Invoice" untuk mencetak detail tagihan
   - Tombol "Kirim Notifikasi" untuk mengirim reminder ke ortu/wali
   - Timeline pembayaran dengan visualisasi progress

4. Format mata uang alternatif:
   - Menggunakan helper Laravel Number::currency() (Laravel 10+)
   - Menggunakan package laravel-money untuk format kompleks
   - Contoh: @money($tagihan->total_bayar, 'IDR')
--}}
