@extends('layouts.wali')

@section('title', 'Jadwal')

@section('content')
    <div class="page-header"><div><h1 class="page-title">Jadwal</h1><p class="page-subtitle">Jadwal kegiatan mendatang.</p></div></div>

    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead><tr><th>Judul</th><th>Jenis</th><th>Tanggal</th><th>Waktu</th><th>Lokasi</th></tr></thead>
                <tbody>
                    @forelse($jadwal as $j)
                        <tr>
                            <td>{{ $j->judul }}</td>
                            <td><span class="badge badge-info">{{ ucfirst($j->jenis) }}</span></td>
                            <td>{{ $j->tanggal_mulai->format('d/m/Y') }} {{ $j->tanggal_selesai ? '- '.$j->tanggal_selesai->format('d/m/Y') : '' }}</td>
                            <td>{{ $j->waktu_mulai ?? '-' }} {{ $j->waktu_selesai ? '- '.$j->waktu_selesai : '' }}</td>
                            <td>{{ $j->lokasi ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted">Tidak ada jadwal</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($jadwal->hasPages())
            <div class="card-footer">
                {{ $jadwal->links() }}
            </div>
        @endif
    </div>
@endsection
