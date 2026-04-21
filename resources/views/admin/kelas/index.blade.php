{{-- ===================================================== --}}
{{-- FILE: index.blade.php (Kelas) --}}
{{-- DESKRIPSI: Tabel daftar kelas dengan jumlah santri --}}
{{-- LOKASI: resources/views/admin/kelas/index.blade.php --}}
{{-- CONTROLLER: Admin/KelasController@index --}}
{{-- ROUTE: GET /admin/kelas --}}
{{-- ===================================================== --}}

@extends('layouts.admin')

@section('title', 'Manajemen Kelas')

@section('content')
    {{-- Header halaman dengan tombol tambah --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Kelas</h1>
            <p class="page-subtitle">Kelola data kelas.</p>
        </div>
        <div>
            {{-- Tombol tambah kelas baru --}}
            <a href="{{ route('admin.kelas.create') }}" class="btn btn-primary">
                <i class="bi bi-plus"></i> Tambah Kelas
            </a>
        </div>
    </div>

    {{-- Card tabel --}}
    <div class="card">
        <div class="card-body">
            {{-- Tabel dengan DataTables --}}
            <table class="table" id="dataTable" style="width:100%">
                <thead>
                    <tr>
                        <th>Nama Kelas</th>
                        <th>Tingkat</th>
                        {{-- Kolom jumlah santri (dari withCount di controller) --}}
                        <th>Jumlah Santri</th>
                        <th>Status</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Loop data kelas --}}
                    @foreach($kelas as $k)
                        <tr>
                            <td>{{ $k->nama_kelas }}</td>
                            <td>{{ $k->tingkat ?? '-' }}</td>
                            {{-- santri_count: Hasil withCount('santri') --}}
                            <td>{{ $k->santri_count }} santri</td>
                            <td>
                                {{-- Badge status aktif/nonaktif --}}
                                @if($k->is_active)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                {{-- Tombol aksi --}}
                                <div class="btn-group">
                                    <a href="{{ route('admin.kelas.edit', $k) }}" class="btn btn-sm btn-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.kelas.destroy', $k) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
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

{{-- Script DataTables --}}
@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            order: [[0, 'asc']],  // Urutkan berdasarkan nama kelas
            columnDefs: [
                { orderable: false, targets: -1 }  // Nonaktifkan sort di kolom aksi
            ]
        });
    });
</script>
@endpush
