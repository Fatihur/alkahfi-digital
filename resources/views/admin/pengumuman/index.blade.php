{{--
================================================================================
FILE        : index.blade.php
DESKRIPSI   : Halaman daftar/list pengumuman untuk admin panel. Menampilkan tabel
              DataTables dengan fitur CRUD untuk mengelola pengumuman sekolah.
LOKASI      : resources/views/admin/pengumuman/index.blade.php
CONTROLLER  : PengumumanController@index
ROUTE       : GET /admin/pengumuman (name: admin.pengumuman.index)
================================================================================
--}}

{{-- Memanggil layout utama admin --}}
@extends('layouts.admin')

{{-- Mengisi section title --}}
@section('title', 'Manajemen Pengumuman')

{{-- Section konten utama --}}
@section('content')
    {{-- Page Header dengan judul dan tombol tambah --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Pengumuman</h1>
            <p class="page-subtitle">Kelola pengumuman untuk wali santri.</p>
        </div>
        {{-- Tombol Tambah Pengumuman --}}
        <a href="{{ route('admin.pengumuman.create') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i> Tambah Pengumuman
        </a>
    </div>

    {{-- Card Container untuk tabel --}}
    <div class="card">
        <div class="card-body">
            {{-- Tabel DataTables --}}
            <table class="table" id="dataTable" style="width:100%">
                <thead>
                    <tr>
                        {{-- Header Kolom --}}
                        <th>Judul</th>
                        <th>Prioritas</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Looping data pengumuman --}}
                    @foreach($pengumuman as $p)
                        <tr>
                            {{-- Judul pengumuman --}}
                            <td>{{ $p->judul }}</td>
                            <td>
                                {{--
                                    Badge Prioritas dengan conditional coloring
                                    Ternary operator untuk menentukan warna badge:
                                    - 'tinggi' => badge-danger (merah)
                                    - 'normal' => badge-info (biru)
                                    - lainnya => badge-secondary (abu)
                                --}}
                                <span class="badge badge-{{ $p->prioritas == 'tinggi' ? 'danger' : ($p->prioritas == 'normal' ? 'info' : 'secondary') }}">
                                    {{ ucfirst($p->prioritas) }}
                                </span>
                            </td>
                            <td>
                                {{-- Badge Published Status --}}
                                <span class="badge badge-{{ $p->is_published ? 'success' : 'warning' }}">
                                    {{ $p->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                            {{--
                                Tanggal dengan data-order untuk sorting
                                format('Y-m-d') untuk sorting, format('d/m/Y') untuk tampilan
                            --}}
                            <td data-order="{{ $p->created_at->format('Y-m-d') }}">
                                {{ $p->created_at->format('d/m/Y') }}
                            </td>
                            <td>
                                {{-- Tombol Aksi - Detail, Edit, Hapus --}}
                                <div class="btn-group">
                                    {{-- Tombol Detail --}}
                                    <a href="{{ route('admin.pengumuman.show', $p) }}" class="btn btn-sm btn-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('admin.pengumuman.edit', $p) }}" class="btn btn-sm btn-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    {{-- Form Hapus dengan CSRF dan Method Spoofing --}}
                                    <form action="{{ route('admin.pengumuman.destroy', $p) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin?')">
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

{{-- Push script DataTables ke stack scripts --}}
@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            {{-- Urutan default: kolom ke-3 (Tanggal) descending --}}
            order: [[3, 'desc']],
            columnDefs: [
                {{-- Nonaktifkan sorting pada kolom terakhir (Aksi) --}}
                { orderable: false, targets: -1 }
            ]
        });
    });
</script>
@endpush
