@extends('layouts.admin')

@section('title', 'Log Aktivitas')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Log Aktivitas</h1>
            <p class="page-subtitle">Riwayat aktivitas pengguna sistem.</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table" id="dataTable" style="width:100%">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>User</th>
                        <th>Aktivitas</th>
                        <th>Modul</th>
                        <th>Deskripsi</th>
                        <th>IP</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                        <tr>
                            <td data-order="{{ $log->created_at->format('Y-m-d H:i:s') }}">
                                {{ $log->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td>{{ $log->user->name ?? 'System' }}</td>
                            <td>{{ $log->aktivitas }}</td>
                            <td><span class="badge badge-info">{{ $log->modul ?? '-' }}</span></td>
                            <td>{{ Str::limit($log->deskripsi, 50) ?? '-' }}</td>
                            <td><code>{{ $log->ip_address ?? '-' }}</code></td>
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
            order: [[0, 'desc']]
        });
    });
</script>
@endpush
