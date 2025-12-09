@extends('layouts.bendahara')

@section('title', 'Manajemen Tagihan')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Tagihan</h1>
            <p class="page-subtitle">Kelola tagihan SPP santri.</p>
        </div>
        <div>
            <a href="{{ route('bendahara.tagihan.create') }}" class="btn btn-primary">
                <i class="bi bi-plus"></i> Buat Tagihan
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <form action="" method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control" placeholder="Cari nama/NIS..." value="{{ request('search') }}" style="width: 200px;">
                <select name="status" class="form-control form-select" style="width: 150px;">
                    <option value="">Semua Status</option>
                    <option value="belum_bayar" {{ request('status') == 'belum_bayar' ? 'selected' : '' }}>Belum Bayar</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                    <option value="jatuh_tempo" {{ request('status') == 'jatuh_tempo' ? 'selected' : '' }}>Jatuh Tempo</option>
                </select>
                <select name="tahun" class="form-control form-select" style="width: 100px;">
                    <option value="">Tahun</option>
                    @for($y = date('Y'); $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
                <button type="submit" class="btn btn-secondary">Filter</button>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Santri</th>
                        <th>Tagihan</th>
                        <th>Total</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tagihan as $t)
                        <tr>
                            <td>
                                <strong>{{ $t->santri->nama_lengkap }}</strong>
                                <br><small class="text-muted">{{ $t->santri->nis }}</small>
                            </td>
                            <td>{{ $t->nama_tagihan }}<br><small class="text-muted">{{ $t->periode ?? '-' }}</small></td>
                            <td>Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</td>
                            <td>{{ $t->tanggal_jatuh_tempo->format('d/m/Y') }}</td>
                            <td>
                                @switch($t->status)
                                    @case('lunas') <span class="badge badge-success">Lunas</span> @break
                                    @case('belum_bayar') <span class="badge badge-warning">Belum Bayar</span> @break
                                    @case('pending') <span class="badge badge-info">Pending</span> @break
                                    @case('jatuh_tempo') <span class="badge badge-danger">Jatuh Tempo</span> @break
                                @endswitch
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('bendahara.tagihan.show', $t) }}" class="btn btn-sm btn-secondary"><i class="bi bi-eye"></i></a>
                                    @if($t->status !== 'lunas')
                                        <a href="{{ route('bendahara.tagihan.edit', $t) }}" class="btn btn-sm btn-secondary"><i class="bi bi-pencil"></i></a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted">Tidak ada data tagihan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($tagihan->hasPages())
            <div class="card-footer">
                {{ $tagihan->links() }}
            </div>
        @endif
    </div>
@endsection
