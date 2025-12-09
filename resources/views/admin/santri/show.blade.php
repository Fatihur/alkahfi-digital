@extends('layouts.admin')

@section('title', 'Detail Santri')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Santri</h1>
            <p class="page-subtitle">{{ $santri->nama_lengkap }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.santri.edit', $santri) }}" class="btn btn-primary">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('admin.santri.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Santri</h3>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr><td style="width: 150px;"><strong>NIS</strong></td><td>{{ $santri->nis }}</td></tr>
                        <tr><td><strong>Nama Lengkap</strong></td><td>{{ $santri->nama_lengkap }}</td></tr>
                        <tr><td><strong>Jenis Kelamin</strong></td><td>{{ $santri->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td></tr>
                        <tr><td><strong>Tempat, Tgl Lahir</strong></td><td>{{ $santri->tempat_lahir }}, {{ $santri->tanggal_lahir?->format('d/m/Y') ?? '-' }}</td></tr>
                        <tr><td><strong>Alamat</strong></td><td>{{ $santri->alamat ?? '-' }}</td></tr>
                        <tr><td><strong>Kelas</strong></td><td>{{ $santri->kelas->nama_kelas }}</td></tr>
                        <tr><td><strong>Angkatan</strong></td><td>{{ $santri->angkatan->tahun_angkatan }}</td></tr>
                        <tr><td><strong>Tanggal Masuk</strong></td><td>{{ $santri->tanggal_masuk?->format('d/m/Y') ?? '-' }}</td></tr>
                        <tr><td><strong>Status</strong></td><td><span class="badge badge-{{ $santri->status == 'aktif' ? 'success' : 'secondary' }}">{{ ucfirst($santri->status) }}</span></td></tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Wali Santri</h3>
                </div>
                <div class="card-body">
                    @if($santri->wali->count() > 0)
                        <table class="table">
                            <thead><tr><th>Nama</th><th>Email</th><th>Hubungan</th></tr></thead>
                            <tbody>
                                @foreach($santri->wali as $wali)
                                    <tr>
                                        <td>{{ $wali->name }}</td>
                                        <td>{{ $wali->email }}</td>
                                        <td>{{ ucfirst($wali->pivot->hubungan) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted">Belum ada wali yang terhubung.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Riwayat Tagihan</h3>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead><tr><th>Tagihan</th><th>Periode</th><th>Total</th><th>Jatuh Tempo</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($santri->tagihan as $tagihan)
                        <tr>
                            <td>{{ $tagihan->nama_tagihan }}</td>
                            <td>{{ $tagihan->periode ?? '-' }}</td>
                            <td>Rp {{ number_format($tagihan->total_bayar, 0, ',', '.') }}</td>
                            <td>{{ $tagihan->tanggal_jatuh_tempo->format('d/m/Y') }}</td>
                            <td>
                                @switch($tagihan->status)
                                    @case('lunas') <span class="badge badge-success">Lunas</span> @break
                                    @case('belum_bayar') <span class="badge badge-warning">Belum Bayar</span> @break
                                    @case('pending') <span class="badge badge-info">Pending</span> @break
                                    @case('jatuh_tempo') <span class="badge badge-danger">Jatuh Tempo</span> @break
                                @endswitch
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted">Belum ada tagihan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
