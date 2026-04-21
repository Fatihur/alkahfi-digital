{{-- ===================================================== --}}
{{-- FILE: index.blade.php (Jurusan) --}}
{{-- DESKRIPSI: Tabel daftar jurusan dengan kode dan jumlah santri --}}
{{-- LOKASI: resources/views/admin/jurusan/index.blade.php --}}
{{-- CONTROLLER: Admin/JurusanController@index --}}
{{-- ROUTE: GET /admin/jurusan --}}
{{-- ===================================================== --}}

@extends('layouts.admin')

@section('title', 'Manajemen Jurusan')

@section('content')
    {{-- Header halaman --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Jurusan</h1>
            <p class="page-subtitle">Kelola data jurusan.</p>
        </div>
        <div>
            <a href="{{ route('admin.jurusan.create') }}" class="btn btn-primary">
                <i class="bi bi-plus"></i> Tambah Jurusan
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table" id="dataTable" style="width:100%">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Jurusan</th>
                        <th>Jumlah Santri</th>
                        <th>Status</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jurusan as $j)
                        <tr>
                            {{-- Kode jurusan dengan default '-' --}}
                            <td>{{ $j->kode_jurusan ?? '-' }}</td>
                            <td>{{ $j->nama_jurusan }}</td>
                            <td>{{ $j->santri_count }} santri</td>
                            <td>
                                @if($j->is_active)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.jurusan.edit', $j) }}" class="btn btn-sm btn-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.jurusan.destroy', $j) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin ingin menghapus jurusan ini?')">
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

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            order: [[1, 'asc']],  // Urutkan berdasarkan nama jurusan
            columnDefs: [
                { orderable: false, targets: -1 }
            ]
        });
    });
</script>
@endpush
