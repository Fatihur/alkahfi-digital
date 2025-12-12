@extends('layouts.admin')

@section('title', 'Detail Wali Santri')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Wali Santri</h1>
            <p class="page-subtitle">Informasi lengkap wali santri.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.wali-santri.edit', $wali_santri) }}" class="btn btn-secondary">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('admin.wali-santri.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    @if(session('generated_password'))
        <div class="alert alert-warning">
            <i class="bi bi-key"></i> <strong>Password Akun:</strong> Simpan password ini, tidak akan ditampilkan lagi: <code>{{ session('generated_password') }}</code>
        </div>
    @endif

    @if(session('new_password'))
        <div class="alert alert-warning">
            <i class="bi bi-key"></i> <strong>Password Baru:</strong> Password berhasil direset: <code>{{ session('new_password') }}</code>
        </div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informasi Akun</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted" width="40%">Nama</td>
                            <td>{{ $wali_santri->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Email</td>
                            <td>{{ $wali_santri->email }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">No. HP</td>
                            <td>{{ $wali_santri->no_hp ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Status</td>
                            <td>
                                @if($wali_santri->is_active)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Nonaktif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Terdaftar</td>
                            <td>{{ $wali_santri->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <form action="{{ route('admin.wali-santri.reset-password', $wali_santri) }}" method="POST" onsubmit="return confirm('Reset password wali ini?')">
                        @csrf
                        <button type="submit" class="btn btn-warning btn-sm w-100">
                            <i class="bi bi-key"></i> Reset Password
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Daftar Santri</h5>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>NIS</th>
                                <th>Nama Santri</th>
                                <th>Kelas</th>
                                <th>Hubungan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($wali_santri->waliSantri as $ws)
                                <tr>
                                    <td>{{ $ws->santri->nis ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('admin.santri.show', $ws->santri) }}">
                                            {{ $ws->santri->nama_lengkap ?? 'N/A' }}
                                        </a>
                                    </td>
                                    <td>{{ $ws->santri->kelas->nama ?? '-' }}</td>
                                    <td><span class="badge badge-info">{{ ucfirst($ws->hubungan) }}</span></td>
                                    <td>
                                        @if($ws->santri->status == 'aktif')
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-secondary">{{ ucfirst($ws->santri->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada santri yang terhubung</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
