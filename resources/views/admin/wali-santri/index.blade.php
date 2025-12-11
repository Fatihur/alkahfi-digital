@extends('layouts.admin')

@section('title', 'Kelola Wali Santri')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Kelola Wali Santri</h1>
            <p class="page-subtitle">Kelola data wali santri dan akun login mereka.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.wali-santri.generate') }}" class="btn btn-success">
                <i class="bi bi-magic"></i> Generate Akun Otomatis
            </a>
            <a href="{{ route('admin.wali-santri.create') }}" class="btn btn-primary">
                <i class="bi bi-plus"></i> Tambah Wali Santri
            </a>
        </div>
    </div>

    @if(session('generated_accounts'))
        <div class="alert alert-success">
            <h5><i class="bi bi-check-circle"></i> Akun Berhasil Dibuat</h5>
            <p>Simpan informasi login berikut:</p>
            <div class="table-responsive">
                <table class="table table-sm table-bordered bg-white">
                    <thead>
                        <tr>
                            <th>Santri</th>
                            <th>Email</th>
                            <th>Password</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(session('generated_accounts') as $account)
                            <tr>
                                <td>{{ $account['santri'] }}</td>
                                <td><code>{{ $account['email'] }}</code></td>
                                <td><code>{{ $account['password'] }}</code></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table" id="dataTable" style="width:100%">
                <thead>
                    <tr>
                        <th>Nama Wali</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        <th>Santri</th>
                        <th>Status</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($waliSantri as $wali)
                        <tr>
                            <td>{{ $wali->name }}</td>
                            <td>{{ $wali->email }}</td>
                            <td>{{ $wali->no_hp ?? '-' }}</td>
                            <td>
                                @forelse($wali->waliSantri as $ws)
                                    <span class="badge badge-info">{{ $ws->santri->nama_lengkap ?? 'N/A' }}</span>
                                @empty
                                    <span class="text-muted">-</span>
                                @endforelse
                            </td>
                            <td>
                                @if($wali->is_active)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.wali-santri.show', $wali) }}" class="btn btn-sm btn-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.wali-santri.edit', $wali) }}" class="btn btn-sm btn-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.wali-santri.reset-password', $wali) }}" method="POST" style="display:inline" onsubmit="return confirm('Reset password wali ini?')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning" title="Reset Password">
                                            <i class="bi bi-key"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.wali-santri.destroy', $wali) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin ingin menghapus wali santri ini?')">
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
            order: [[0, 'asc']],
            columnDefs: [
                { orderable: false, targets: -1 }
            ]
        });
    });
</script>
@endpush
