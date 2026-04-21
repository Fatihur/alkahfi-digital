{{--
================================================================================
FILE        : index.blade.php
DESKRIPSI   : Halaman daftar/manajemen tagihan SPP. Menampilkan tabel data tagihan
              dengan fitur DataTables (sorting, searching, pagination). Setiap
              baris menampilkan informasi santri, tagihan, status, dan aksi.
LOKASI      : resources/views/bendahara/tagihan/index.blade.php
CONTROLLER  : Bendahara\TagihanController@index
ROUTE       : GET /bendahara/tagihan
================================================================================

CONTOH MODIFIKASI STYLING:
- Tambahkan kolom baru: Duplikat <th> dan <td> dengan field yang diinginkan
- Ubah warna badge: badge-success (hijau), badge-warning (kuning),
  badge-danger (merah), badge-info (biru), badge-secondary (abu)
- Tambahkan filter: Tambahkan <select> filter di atas tabel

DATA YANG DIBUTUHKAN DARI CONTROLLER:
- $tagihan: Collection model Tagihan dengan relasi santri
================================================================================
--}}

{{-- Mewarisi layout bendahara --}}
@extends('layouts.bendahara')

{{-- Judul halaman untuk tab browser --}}
@section('title', 'Manajemen Tagihan')

{{-- Konten utama halaman --}}
@section('content')
    
    {{-- PAGE HEADER dengan tombol aksi --}}
    <div class="page-header">
        <div>
            {{-- Judul halaman --}}
            <h1 class="page-title">Manajemen Tagihan</h1>
            {{-- Deskripsi singkat --}}
            <p class="page-subtitle">Kelola tagihan SPP santri.</p>
        </div>
        <div>
            {{-- TOMBOL TAMBAH TAGIHAN --}}
            {{-- btn btn-primary: Tombol dengan style primary (biru) --}}
            {{-- route('bendahara.tagihan.create'): Named route ke halaman create --}}
            <a href="{{ route('bendahara.tagihan.create') }}" class="btn btn-primary">
                {{-- bi bi-plus: Icon tambah/plus --}}
                <i class="bi bi-plus"></i> Buat Tagihan
            </a>
        </div>
    </div>

    {{-- CARD TABEL TAGIHAN --}}
    <div class="card">
        <div class="card-body">
            {{-- TABEL DENGAN DATATABLES --}}
            {{-- id="dataTable": ID untuk inisialisasi DataTables JavaScript --}}
            {{-- style="width:100%": Memastikan tabel mengambil lebar penuh --}}
            <table class="table" id="dataTable" style="width:100%">
                <thead>
                    <tr>
                        {{-- Kolom Santri --}}
                        <th>Santri</th>
                        {{-- Kolom Nama Tagihan --}}
                        <th>Tagihan</th>
                        {{-- Kolom Total Pembayaran --}}
                        <th>Total</th>
                        {{-- Kolom Tanggal Jatuh Tempo --}}
                        <th>Jatuh Tempo</th>
                        {{-- Kolom Status Pembayaran --}}
                        <th>Status</th>
                        {{-- Kolom Aksi (Edit, Detail) dengan lebar tetap 80px --}}
                        <th width="80">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- LOOP DATA TAGIHAN --}}
                    {{-- @foreach: Directive loop untuk iterasi collection --}}
                    {{-- $tagihan: Collection model Tagihan dari controller --}}
                    {{-- $t: Variable iterator untuk setiap tagihan --}}
                    @foreach($tagihan as $t)
                        <tr>
                            {{-- KOLOM SANTRI --}}
                            <td>
                                {{-- Nama lengkap santri dengan teks bold --}}
                                <strong>{{ $t->santri->nama_lengkap }}</strong>
                                {{-- NIS santri dengan teks kecil dan warna abu --}}
                                <br><small class="text-muted">{{ $t->santri->nis }}</small>
                            </td>
                            
                            {{-- KOLOM TAGIHAN --}}
                            <td>
                                {{-- Nama tagihan --}}
                                {{ $t->nama_tagihan }}
                                {{-- Periode tagihan (bulan/tahun) --}}
                                <br><small class="text-muted">{{ $t->periode ?? '-' }}</small>
                            </td>
                            
                            {{-- KOLOM TOTAL --}}
                            {{-- Format angka ribuan dengan titik --}}
                            <td>Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</td>
                            
                            {{-- KOLOM JATUH TEMPO --}}
                            {{-- data-order: Atribut untuk sorting DataTables (format Y-m-d) --}}
                            <td data-order="{{ $t->tanggal_jatuh_tempo->format('Y-m-d') }}">
                                {{-- Format tampilan tanggal Indonesia (d/m/Y) --}}
                                {{ $t->tanggal_jatuh_tempo->format('d/m/Y') }}
                            </td>
                            
                            {{-- KOLOM STATUS DENGAN BADGE --}}
                            <td>
                                {{-- @switch: Directive Blade untuk kondisi multiple case --}}
                                {{-- Mengecek nilai $t->status dan menampilkan badge sesuai --}}
                                @switch($t->status)
                                    {{-- Case LUNAS: Badge hijau --}}
                                    @case('lunas')
                                        <span class="badge badge-success">Lunas</span>
                                        @break
                                    {{-- Case BELUM_BAYAR: Badge kuning --}}
                                    @case('belum_bayar')
                                        <span class="badge badge-warning">Belum Bayar</span>
                                        @break
                                    {{-- Case PENDING: Badge biru --}}
                                    @case('pending')
                                        <span class="badge badge-info">Pending</span>
                                        @break
                                    {{-- Case JATUH_TEMPO: Badge merah --}}
                                    @case('jatuh_tempo')
                                        <span class="badge badge-danger">Jatuh Tempo</span>
                                        @break
                                {{-- @endswitch: Penutup switch statement --}}
                                @endswitch
                            </td>
                            
                            {{-- KOLOM AKSI --}}
                            <td>
                                {{-- btn-group: Grup tombol yang digabung --}}
                                <div class="btn-group">
                                    {{-- TOMBOL DETAIL/LIHAT --}}
                                    {{-- btn btn-sm btn-info: Tombol kecil dengan style info (biru muda) --}}
                                    {{-- title: Tooltip yang muncul saat hover --}}
                                    <a href="{{ route('bendahara.tagihan.show', $t) }}" class="btn btn-sm btn-info" title="Detail">
                                        <i class="bi bi-eye"></i> {{-- Icon mata/lihat --}}
                                    </a>
                                    
                                    {{-- TOMBOL EDIT (Hanya jika belum lunas) --}}
                                    {{-- @if: Kondisi hanya tampil jika status bukan lunas --}}
                                    @if($t->status !== 'lunas')
                                        <a href="{{ route('bendahara.tagihan.edit', $t) }}" class="btn btn-sm btn-secondary" title="Edit">
                                            <i class="bi bi-pencil"></i> {{-- Icon pensil/edit --}}
                                        </a>
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

{{-- @push('scripts'): Menambahkan script ke stack 'scripts' di layout --}}
{{-- Script ini akan dimuat di bagian bawah halaman --}}
@push('scripts')
{{-- JavaScript untuk inisialisasi DataTables --}}
<script>
    {{-- $(document).ready(): Menjalankan kode setelah DOM selesai dimuat --}}
    $(document).ready(function() {
        {{-- Inisialisasi DataTables pada tabel dengan id="dataTable" --}}
        $('#dataTable').DataTable({
            {{-- order: Konfigurasi sorting default --}}
            {{-- [3, 'desc']: Urutkan kolom ke-4 (Jatuh Tempo) secara descending --}}
            order: [[3, 'desc']],
            {{-- columnDefs: Konfigurasi khusus untuk kolom --}}
            columnDefs: [
                {{-- orderable: false: Nonaktifkan sorting untuk kolom terakhir (Aksi) --}}
                {{-- targets: -1: Menunjuk ke kolom terakhir --}}
                { orderable: false, targets: -1 }
            ]
        });
    });
</script>
{{-- @endpush: Penutup push scripts --}}
@endpush
