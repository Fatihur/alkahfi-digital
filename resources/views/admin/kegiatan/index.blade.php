{{--
================================================================================
FILE        : index.blade.php
DESKRIPSI   : Halaman daftar/list kegiatan untuk admin panel. Menampilkan tabel
              DataTables dengan fitur CRUD (Create, Read, Update, Delete) untuk
              mengelola data kegiatan sekolah.
LOKASI      : resources/views/admin/kegiatan/index.blade.php
CONTROLLER  : KegiatanController@index
ROUTE       : GET /admin/kegiatan (name: admin.kegiatan.index)
================================================================================
--}}

{{--
    @extends('layouts.admin')
    Directive ini memanggil layout utama admin yang berada di resources/views/layouts/admin.blade.php
    Layout ini berisi struktur HTML dasar, navbar, sidebar, dan footer
    Semua konten dalam @section akan dimasukkan ke dalam yield() di layout parent
--}}
@extends('layouts.admin')

{{--
    @section('title', 'Manajemen Kegiatan')
    Mengisi section 'title' yang ada di layout admin
    Title ini akan muncul di tab browser dan bisa digunakan untuk page header
--}}
@section('title', 'Manajemen Kegiatan')

{{--
    @section('content')
    Section utama yang berisi konten halaman
    Konten ini akan dimasukkan ke dalam yield('content') di layout parent
--}}
@section('content')
    {{--
        Page Header - Bagian atas halaman yang berisi judul dan tombol aksi
        Styling: page-header menggunakan flexbox dengan justify-content: space-between
    --}}
    <div class="page-header">
        <div>
            {{-- page-title: Judul utama halaman --}}
            <h1 class="page-title">Manajemen Kegiatan</h1>
            {{-- page-subtitle: Deskripsi singkat halaman --}}
            <p class="page-subtitle">Kelola kegiatan sekolah.</p>
        </div>
        {{--
            Tombol Tambah Kegiatan - Mengarahkan ke halaman create
            route('admin.kegiatan.create') menghasilkan URL: /admin/kegiatan/create
            btn-primary: styling Bootstrap untuk tombol utama (warna biru)
        --}}
        <a href="{{ route('admin.kegiatan.create') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i> Tambah Kegiatan
        </a>
    </div>

    {{--
        Card Container - Wrapper untuk tabel DataTables
        card: komponen Bootstrap untuk konten yang dikelompokkan dengan border dan shadow
    --}}
    <div class="card">
        <div class="card-body">
            {{--
                Tabel DataTables - Tabel interaktif dengan fitur sorting, searching, pagination
                id="dataTable": ID untuk inisialisasi JavaScript DataTables
                style="width:100%": memastikan tabel mengambil lebar penuh

                Contoh modifikasi styling:
                - class "table-striped" untuk baris selang-seling
                - class "table-hover" untuk efek hover pada baris
            --}}
            <table class="table" id="dataTable" style="width:100%">
                <thead>
                    <tr>
                        {{-- Header Kolom - Setiap th merepresentasikan kolom yang dapat di-sort --}}
                        <th>Nama Kegiatan</th>
                        <th>Tanggal</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Published</th>
                        {{-- width="100": membatasi lebar kolom aksi --}}
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{--
                        @foreach($kegiatan as $k)
                        Looping melalui koleksi $kegiatan dari controller
                        $k adalah variabel instance untuk setiap item kegiatan
                    --}}
                    @foreach($kegiatan as $k)
                        <tr>
                            {{-- Menampilkan nama kegiatan dari properti model --}}
                            <td>{{ $k->nama_kegiatan }}</td>
                            {{--
                                Tanggal Pelaksanaan dengan sorting
                                data-order: atribut untuk DataTables sorting (format Y-m-d)
                                format('d/m/Y'): menampilkan tanggal dalam format Indonesia
                            --}}
                            <td data-order="{{ $k->tanggal_pelaksanaan->format('Y-m-d') }}">
                                {{ $k->tanggal_pelaksanaan->format('d/m/Y') }}
                            </td>
                            {{--
                                Lokasi dengan fallback
                                ?? '-': null coalescing operator, menampilkan '-' jika null
                            --}}
                            <td>{{ $k->lokasi ?? '-' }}</td>
                            <td>
                                {{--
                                    Badge Status - Menampilkan status dengan styling visual
                                    ucfirst(): membuat huruf pertama kapital
                                    str_replace('_', ' ', ...): mengganti underscore dengan spasi
                                --}}
                                <span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $k->status)) }}</span>
                            </td>
                            <td>
                                {{--
                                    Badge Published - Status publikasi kegiatan
                                    Ternary: jika is_published true = badge-success (hijau)
                                    jika false = badge-warning (kuning)
                                --}}
                                <span class="badge badge-{{ $k->is_published ? 'success' : 'warning' }}">
                                    {{ $k->is_published ? 'Ya' : 'Tidak' }}
                                </span>
                            </td>
                            <td>
                                {{-- Tombol Aksi - Group tombol untuk Detail, Edit, dan Hapus --}}
                                <div class="btn-group">
                                    {{--
                                        Tombol Detail - Mengarahkan ke halaman show
                                        route('admin.kegiatan.show', $k) menghasilkan URL dengan ID
                                        Contoh: /admin/kegiatan/5
                                    --}}
                                    <a href="{{ route('admin.kegiatan.show', $k) }}" class="btn btn-sm btn-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    {{-- Tombol Edit - Mengarahkan ke halaman edit --}}
                                    <a href="{{ route('admin.kegiatan.edit', $k) }}" class="btn btn-sm btn-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    {{--
                                        Form Hapus - Menggunakan method POST dengan spoofing DELETE
                                        @csrf: token CSRF untuk keamanan form
                                        @method('DELETE'): Laravel method spoofing untuk HTTP DELETE
                                    --}}
                                    <form action="{{ route('admin.kegiatan.destroy', $k) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

{{--
    @push('scripts')
    Menambahkan script ke stack 'scripts' yang dirender di layout
    Ini memastikan script DataTables dimuat setelah library jQuery
--}}
@push('scripts')
<script>
    {{-- Inisialisasi DataTables saat dokumen selesai dimuat --}}
    $(document).ready(function() {
        $('#dataTable').DataTable({
            {{-- Urutan default: kolom ke-1 (Tanggal) secara descending --}}
            order: [[1, 'desc']],
            {{--
                columnDefs: konfigurasi khusus untuk kolom
                orderable: false: menonaktifkan sorting pada kolom terakhir (Aksi)
                targets: -1: menunjuk ke kolom terakhir
            --}}
            columnDefs: [
                { orderable: false, targets: -1 }
            ]
        });
    });
</script>
@endpush
