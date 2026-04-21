{{--
================================================================================
FILE        : index.blade.php
DESKRIPSI   : Halaman daftar pengguna (Manajemen Pengguna) - Menampilkan tabel
              data semua pengguna sistem dengan fitur CRUD, DataTables, dan
              penanganan status aktif/nonaktif.
LOKASI      : resources/views/admin/users/index.blade.php
CONTROLLER  : App\Http\Controllers\Admin\UserController@index
ROUTE       : GET /admin/users (name: admin.users.index)
================================================================================
--}}

{{-- ================================================================================
DIRECTIVE: @extends('layouts.admin')
FUNGSI   : Menginheritance layout utama admin yang berisi struktur HTML dasar,
           includin header, sidebar, footer, dan asset CSS/JS global.
           Semua konten dari section akan dimasukkan ke dalam yield di layout.
================================================================================ --}}
@extends('layouts.admin')

{{-- ================================================================================
DIRECTIVE: @section('title', 'Manajemen Pengguna')
FUNGSI   : Mendefinisikan section 'title' yang akan di-render di layout admin.
           Judul ini muncul di tab browser dan header halaman.
MODIFIKASI: Ganti teks untuk mengubah judul halaman.
================================================================================ --}}
@section('title', 'Manajemen Pengguna')

{{-- ================================================================================
DIRECTIVE: @section('content')
FUNGSI   : Mendefinisikan section 'content' utama yang berisi seluruh konten halaman.
           Konten ini akan di-insert ke dalam @yield('content') di layout admin.
================================================================================ --}}
@section('content')
    {{-- ----------------------------------------------------------------------------
    PAGE HEADER
    -----------------------------------------------------------------------------
    Elemen header halaman yang berisi judul, subtitle, dan tombol aksi utama.
    Struktur: flex container dengan justify-content: space-between
    
    KELAS CSS:
    - page-header : Wrapper flex untuk header (biasanya display: flex, justify-content: space-between)
    - page-title  : Styling untuk judul utama (font-size besar, font-weight bold)
    - page-subtitle: Styling untuk deskripsi halaman (warna muted, font-size lebih kecil)
    
    MODIFIKASI STYLING:
    - Warna tombol: btn-primary (biru), btn-success (hijau), btn-danger (merah)
    - Ukuran tombol: btn-lg (besar), btn-sm (kecil), default (normal)
    - Icon: Gunakan class bi bi-* dari Bootstrap Icons
    ---------------------------------------------------------------------------- --}}
    <div class="page-header">
        {{-- Bagian kiri: Judul dan deskripsi --}}
        <div>
            {{-- page-title: Judul utama halaman --}}
            <h1 class="page-title">Manajemen Pengguna</h1>
            {{-- page-subtitle: Keterangan singkat fungsi halaman --}}
            <p class="page-subtitle">Kelola data pengguna sistem.</p>
        </div>
        {{-- Bagian kanan: Tombol aksi utama --}}
        <div>
            {{-- Link ke halaman create pengguna baru --}}
            {{-- route('admin.users.create') menghasilkan URL /admin/users/create --}}
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                {{-- Icon plus dari Bootstrap Icons --}}
                <i class="bi bi-plus"></i> Tambah Pengguna
            </a>
        </div>
    </div>

    {{-- ----------------------------------------------------------------------------
    CARD UTAMA - TABEL DATA PENGGUNA
    -----------------------------------------------------------------------------
    Card berisi tabel DataTables untuk menampilkan data pengguna.
    
    KELAS CSS:
    - card      : Wrapper card dengan shadow dan border-radius
    - card-body : Container untuk konten card dengan padding
    - table     : Styling tabel dasar Bootstrap
    
    MODIFIKASI STYLING:
    - Warna header tabel: bg-primary (biru), bg-success (hijau), bg-dark (hitam)
    - Striped rows: tambahkan class 'table-striped' pada <table>
    - Hover effect: tambahkan class 'table-hover' pada <table>
    - Border: tambahkan class 'table-bordered' pada <table>
    ---------------------------------------------------------------------------- --}}
    <div class="card">
        <div class="card-body">
            {{-- TABEL DATATABLES
                id="dataTable" : ID untuk inisialisasi DataTables di JavaScript
                style="width:100%" : Memastikan tabel memenuhi lebar container
                
                DataTables memberikan fitur:
                - Pagination (pembagian halaman)
                - Search/filter global
                - Sorting pada kolom
                - Responsive layout
            --}}
            <table class="table" id="dataTable" style="width:100%">
                {{-- THEAD: Bagian header tabel --}}
                <thead>
                    <tr>
                        {{-- width="100" : Menetapkan lebar kolom aksi --}}
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                {{-- TBODY: Bagian body tabel dengan data dinamis --}}
                <tbody>
                    {{-- ================================================================================
                    DIRECTIVE: @foreach($users as $user)
                    FUNGSI   : Looping melalui koleksi $users yang dikirim dari controller.
                               Setiap iterasi menyimpan data user ke variabel $user.
                    SYNTAX   : @foreach($collection as $item) ... @endforeach
                    ================================================================================ --}}
                    @foreach($users as $user)
                        <tr>
                            {{-- Menampilkan properti name dari model User --}}
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            {{-- ?? '-' : Null coalescing operator, tampilkan '-' jika no_hp null --}}
                            <td>{{ $user->no_hp ?? '-' }}</td>
                            <td>
                                {{-- ================================================================================
                                BADGE ROLE
                                FUNGSI   : Menampilkan role user dalam bentuk badge.
                                
                                FUNGSI PHP:
                                - ucfirst()        : Kapitalisasi huruf pertama
                                - str_replace()    : Ganti '_' dengan spasi
                                
                                KELAS BADGE:
                                - badge-primary : Biru (Admin)
                                - badge-success : Hijau (Bendahara)
                                - badge-info    : Biru muda (Wali Santri)
                                - badge-warning : Kuning
                                - badge-danger  : Merah
                                ================================================================================ --}}
                                <span class="badge badge-primary">
                                    {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                </span>
                            </td>
                            <td>
                                {{-- ================================================================================
                                DIRECTIVE: @if($user->is_active)
                                FUNGSI   : Conditional rendering berdasarkan status aktif user.
                                           Menampilkan badge berbeda untuk aktif/nonaktif.
                                ================================================================================ --}}
                                @if($user->is_active)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                {{-- ----------------------------------------------------------------------------
                                TOMBOL AKSI
                                -----------------------------------------------------------------------------
                                btn-group : Mengelompokkan tombol secara horizontal
                                btn-sm    : Ukuran tombol small
                                
                                TOMBOL EDIT:
                                - route('admin.users.edit', $user) : URL edit dengan parameter user
                                - btn-secondary : Warna abu-abu
                                
                                TOMBOL HAPUS:
                                - Hanya muncul jika user BUKAN user yang sedang login
                                - onsubmit="return confirm(...)" : Konfirmasi sebelum hapus
                                - @csrf : Token CSRF untuk keamanan form
                                - @method('DELETE') : Spoofing method HTTP DELETE
                                --------------------------------------------------------------------------- --}}
                                <div class="btn-group">
                                    {{-- Tombol Edit - Redirect ke halaman edit --}}
                                    <a href="{{ route('admin.users.edit', $user) }}" 
                                       class="btn btn-sm btn-secondary" 
                                       title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    
                                    {{-- ================================================================================
                                    DIRECTIVE: @if($user->id !== auth()->id())
                                    FUNGSI   : Mencegah user menghapus akunnya sendiri.
                                               auth()->id() mengembalikan ID user yang login.
                                    ================================================================================ --}}
                                    @if($user->id !== auth()->id())
                                        {{-- Form delete dengan method POST + DELETE spoofing --}}
                                        <form action="{{ route('admin.users.destroy', $user) }}" 
                                              method="POST" 
                                              style="display:inline" 
                                              onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                            {{-- ================================================================================
                                            DIRECTIVE: @csrf
                                            FUNGSI   : Generate token CSRF untuk keamanan form.
                                                       Wajib ada pada setiap form POST/PUT/DELETE.
                                            ================================================================================ --}}
                                            @csrf
                                            {{-- ================================================================================
                                            DIRECTIVE: @method('DELETE')
                                            FUNGSI   : Method spoofing untuk mengirim HTTP DELETE.
                                                       Laravel mengubah POST menjadi DELETE.
                                            ================================================================================ --}}
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

{{-- ================================================================================
DIRECTIVE: @push('scripts')
FUNGSI   : Menambahkan konten ke stack 'scripts' yang didefinisikan di layout.
           Berguna untuk menempatkan JavaScript di akhir body.
           Konten akan di-push ke @stack('scripts') di layout admin.
================================================================================ --}}
@push('scripts')
<script>
    {{-- Inisialisasi DataTables setelah DOM siap --}}
    $(document).ready(function() {
        $('#dataTable').DataTable({
            {{-- order: Kolom default untuk sorting (index 0 = Nama, 'asc' = ascending) --}}
            order: [[0, 'asc']],
            {{-- columnDefs: Konfigurasi khusus kolom --}}
            columnDefs: [
                {{-- orderable: false - Nonaktifkan sorting pada kolom terakhir (Aksi) --}}
                {{-- targets: -1 = kolom terakhir --}}
                { orderable: false, targets: -1 }
            ]
            
            {{-- OPSI TAMBAHAN DATATABLES YANG BISA DITAMBAHKAN:
            
            - paging: false              : Nonaktifkan pagination
            - searching: false          : Nonaktifkan fitur search
            - info: false               : Sembunyikan info "Showing X of Y entries"
            - lengthChange: false       : Sembunyikan dropdown "Show X entries"
            - pageLength: 25            : Default 25 rows per page
            - language: {               : Bahasa Indonesia
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
              }
            --}}
        });
    });
</script>
@endpush
