{{--
================================================================================
FILE        : index.blade.php
DESKRIPSI   : Halaman daftar/manajemen tagihan SPP santri dengan fitur 
              DataTables, filter status, dan aksi CRUD
LOKASI      : resources/views/admin/tagihan/index.blade.php
CONTROLLER  : TagihanController@index
ROUTE       : GET /admin/tagihan
================================================================================
--}}

{{-- 
@extends('layouts.admin')
Directive ini menginherit layout utama admin dari file resources/views/layouts/admin.blade.php
Layout ini biasanya berisi struktur HTML dasar, navbar, sidebar, dan footer
Contoh modifikasi: @extends('layouts.admin-custom') untuk layout khusus
--}}
@extends('layouts.admin')

{{-- 
@section('title', 'Manajemen Tagihan')
Mendefinisikan section 'title' yang akan dirender di dalam layout parent
Nilai 'Manajemen Tagihan' akan muncul di tag <title> halaman
--}}
@section('title', 'Manajemen Tagihan')

{{-- 
@section('content')
Memulai section 'content' yang berisi konten utama halaman
Semua konten di dalam section ini akan dimasukkan ke yield('content') di layout parent
--}}
@section('content')
    {{-- 
    Header Halaman
    Struktur: Judul utama + subtitle di kiri, tombol aksi di kanan
    Class page-header biasanya menggunakan flexbox dengan justify-content: space-between
    --}}
    <div class="page-header">
        <div>
            {{-- page-title: Class CSS untuk styling judul utama --}}
            <h1 class="page-title">Manajemen Tagihan</h1>
            {{-- page-subtitle: Class CSS untuk deskripsi pendek --}}
            <p class="page-subtitle">Kelola tagihan SPP santri.</p>
        </div>
        <div>
            {{-- 
            Tombol "Buat Tagihan"
            route('admin.tagihan.create') menghasilkan URL ke halaman create
            Class btn btn-primary: Styling Bootstrap untuk tombol utama (biasanya biru)
            Icon bi bi-plus: Menggunakan Bootstrap Icons
            --}}
            <a href="{{ route('admin.tagihan.create') }}" class="btn btn-primary">
                <i class="bi bi-plus"></i> Buat Tagihan
            </a>
        </div>
    </div>

    {{-- 
    Card Container
    Class card digunakan untuk membungkus konten dalam box dengan shadow dan border
    Bisa dimodifikasi dengan: card-outline card-primary, card-success, dll
    --}}
    <div class="card">
        <div class="card-body">
            {{-- 
            Tabel Data Tagihan dengan DataTables
            id="dataTable": ID unik untuk inisialisasi JavaScript DataTables
            style="width:100%": Memastikan tabel menggunakan lebar penuh
            Class table: Styling Bootstrap untuk tabel
            --}}
            <table class="table" id="dataTable" style="width:100%">
                <thead>
                    <tr>
                        {{-- Kolom-kolom tabel --}}
                        <th>Santri</th>
                        <th>Tagihan</th>
                        <th>Total</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                        {{-- width="120": Lebar tetap untuk kolom aksi --}}
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- 
                    @foreach($tagihan as $t)
                    Looping melalui koleksi tagihan yang dikirim dari controller
                    $t adalah variabel iterasi untuk setiap item tagihan
                    --}}
                    @foreach($tagihan as $t)
                        <tr>
                            {{-- 
                            Kolom Santri
                            Mengakses relasi santri: $t->santri->nama_lengkap
                            <br>: Line break untuk menampilkan NIS di baris kedua
                            text-muted: Class untuk teks berwarna abu-abu
                            --}}
                            <td>
                                <strong>{{ $t->santri->nama_lengkap }}</strong>
                                <br><small class="text-muted">{{ $t->santri->nis }}</small>
                            </td>
                            {{-- 
                            Kolom Tagihan
                            Menampilkan nama_tagihan dan periode (jika ada)
                            Operator ?? '-' menampilkan '-' jika periode null
                            --}}
                            <td>
                                {{ $t->nama_tagihan }}
                                <br><small class="text-muted">{{ $t->periode ?? '-' }}</small>
                            </td>
                            {{-- 
                            Kolom Total
                            number_format(): Fungsi PHP untuk memformat angka
                            Parameter: (angka, desimal, pemisah_desimal, pemisah_ribuan)
                            Hasil: Rp 1.000.000 (dari 1000000)
                            --}}
                            <td>Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</td>
                            {{-- 
                            Kolom Jatuh Tempo dengan sorting support
                            data-order: Atribut untuk DataTables sorting (format Y-m-d)
                            Format tampilan: d/m/Y (Indonesia)
                            --}}
                            <td data-order="{{ $t->tanggal_jatuh_tempo->format('Y-m-d') }}">
                                {{ $t->tanggal_jatuh_tempo->format('d/m/Y') }}
                            </td>
                            {{-- 
                            Kolom Status dengan Badge
                            @switch: Directive Blade untuk switch case
                            Setiap case menampilkan badge dengan warna berbeda:
                            - badge-success (hijau): Lunas
                            - badge-warning (kuning): Belum Bayar
                            - badge-info (biru): Pending
                            - badge-danger (merah): Jatuh Tempo
                            --}}
                            <td>
                                @switch($t->status)
                                    @case('lunas')
                                        <span class="badge badge-success">Lunas</span>
                                        @break
                                    @case('belum_bayar')
                                        <span class="badge badge-warning">Belum Bayar</span>
                                        @break
                                    @case('pending')
                                        <span class="badge badge-info">Pending</span>
                                        @break
                                    @case('jatuh_tempo')
                                        <span class="badge badge-danger">Jatuh Tempo</span>
                                        @break
                                @endswitch
                            </td>
                            {{-- 
                            Kolom Aksi
                            btn-group: Mengelompokkan tombol secara horizontal
                            Tombol Detail: Selalu tampil (btn-info = biru muda)
                            Tombol Edit & Hapus: Hanya tampil jika status BUKAN lunas
                            --}}
                            <td>
                                <div class="btn-group">
                                    {{-- Tombol Detail - Mengarah ke halaman show --}}
                                    <a href="{{ route('admin.tagihan.show', $t) }}" class="btn btn-sm btn-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    {{-- 
                                    @if($t->status !== 'lunas')
                                    Kondisi: Tombol edit dan hapus hanya muncul jika tagihan belum lunas
                                    --}}
                                    @if($t->status !== 'lunas')
                                        {{-- Tombol Edit - Mengarah ke halaman edit --}}
                                        <a href="{{ route('admin.tagihan.edit', $t) }}" class="btn btn-sm btn-secondary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        {{-- 
                                        Form Hapus dengan method POST + DELETE
                                        style="display:inline": Agar form sejajar dengan tombol lain
                                        onsubmit="return confirm('Yakin?')": Konfirmasi sebelum hapus
                                        @csrf: Token CSRF untuk keamanan
                                        @method('DELETE'): Override method menjadi DELETE
                                        --}}
                                        <form action="{{ route('admin.tagihan.destroy', $t) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    {{-- @endforeach: Penutup loop --}}
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
{{-- @endsection: Penutup section content --}}
@endsection

{{-- 
@push('scripts')
Menambahkan script ke section/stack 'scripts' di layout parent
Biasanya diletakkan sebelum closing </body>
--}}
@push('scripts')
{{-- Inisialisasi DataTables dengan konfigurasi khusus --}}
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            {{-- 
            order: [[3, 'desc']]
            Mengurutkan tabel berdasarkan kolom ke-4 (Jatuh Tempo) secara descending
            Index dimulai dari 0
            --}}
            order: [[3, 'desc']],
            {{-- 
            columnDefs: Mendefinisikan perilaku khusus kolom
            orderable: false: Kolom tidak bisa diurutkan
            targets: -1: Menunjuk kolom terakhir (Aksi)
            --}}
            columnDefs: [
                { orderable: false, targets: -1 }
            ]
        });
    });
</script>
@endpush
