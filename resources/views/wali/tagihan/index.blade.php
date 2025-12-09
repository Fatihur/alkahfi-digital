@extends('layouts.wali')

@section('title', 'Tagihan SPP')

@section('content')
    <div class="page-header"><div><h1 class="page-title">Tagihan SPP</h1><p class="page-subtitle">Daftar tagihan SPP anak Anda.</p></div></div>

    <div class="card">
        <div class="card-header">
            <form action="" method="GET" class="d-flex gap-2">
                <select name="status" class="form-control form-select" style="width: 150px;">
                    <option value="">Semua Status</option>
                    <option value="belum_bayar" {{ request('status') == 'belum_bayar' ? 'selected' : '' }}>Belum Bayar</option>
                    <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                    <option value="jatuh_tempo" {{ request('status') == 'jatuh_tempo' ? 'selected' : '' }}>Jatuh Tempo</option>
                </select>
                <select name="santri_id" class="form-control form-select" style="width: 200px;">
                    <option value="">Semua Santri</option>
                    @foreach($santriList as $s)
                        <option value="{{ $s->id }}" {{ request('santri_id') == $s->id ? 'selected' : '' }}>{{ $s->nama_lengkap }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-secondary">Filter</button>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead><tr><th>Santri</th><th>Tagihan</th><th>Periode</th><th>Total</th><th>Jatuh Tempo</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($tagihan as $t)
                        <tr>
                            <td>{{ $t->santri->nama_lengkap }}</td>
                            <td>{{ $t->nama_tagihan }}</td>
                            <td>{{ $t->periode ?? '-' }}</td>
                            <td>Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</td>
                            <td>{{ $t->tanggal_jatuh_tempo->format('d/m/Y') }}</td>
                            <td>
                                @switch($t->status)
                                    @case('lunas') <span class="badge badge-success">Lunas</span> @break
                                    @case('belum_bayar') <span class="badge badge-warning">Belum Bayar</span> @break
                                    @case('jatuh_tempo') <span class="badge badge-danger">Jatuh Tempo</span> @break
                                @endswitch
                            </td>
                            <td>
                                @if($t->status != 'lunas')
                                    <a href="{{ route('wali.pembayaran.bayar', $t) }}" class="btn btn-sm btn-primary">Bayar</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted">Tidak ada tagihan</td></tr>
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
