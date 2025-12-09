@extends('layouts.admin')

@section('title', 'Log Aktivitas')

@section('content')
    <div class="page-header"><div><h1 class="page-title">Log Aktivitas</h1><p class="page-subtitle">Riwayat aktivitas pengguna.</p></div></div>

    <div class="card">
        <div class="card-header">
            <form action="" method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control" placeholder="Cari aktivitas..." value="{{ request('search') }}" style="width: 200px;">
                <select name="modul" class="form-control form-select" style="width: 150px;">
                    <option value="">Semua Modul</option>
                    @foreach($modulList as $modul)
                        <option value="{{ $modul }}" {{ request('modul') == $modul ? 'selected' : '' }}>{{ ucfirst($modul) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-secondary">Filter</button>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead><tr><th>Waktu</th><th>User</th><th>Aktivitas</th><th>Modul</th><th>Deskripsi</th><th>IP</th></tr></thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $log->user->name ?? 'System' }}</td>
                            <td>{{ $log->aktivitas }}</td>
                            <td><span class="badge badge-info">{{ $log->modul ?? '-' }}</span></td>
                            <td>{{ Str::limit($log->deskripsi, 50) ?? '-' }}</td>
                            <td><code>{{ $log->ip_address ?? '-' }}</code></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted">Tidak ada log</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
            <div class="card-footer">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
@endsection
