@extends('layouts.wali')

@section('title', 'Detail Tagihan')

@section('content')
    <div class="page-header">
        <div><h1 class="page-title">Detail Tagihan</h1></div>
        <a href="{{ route('wali.tagihan.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Informasi Tagihan</h3></div>
                <div class="card-body">
                    <table class="table">
                        <tr><td><strong>Nama Tagihan</strong></td><td>{{ $tagihan->nama_tagihan }}</td></tr>
                        <tr><td><strong>Periode</strong></td><td>{{ $tagihan->periode ?? '-' }}</td></tr>
                        <tr><td><strong>Nominal</strong></td><td>Rp {{ number_format($tagihan->nominal, 0, ',', '.') }}</td></tr>
                        <tr><td><strong>Diskon</strong></td><td>Rp {{ number_format($tagihan->diskon, 0, ',', '.') }}</td></tr>
                        <tr><td><strong>Denda</strong></td><td>Rp {{ number_format($tagihan->denda, 0, ',', '.') }}</td></tr>
                        <tr><td><strong>Total Bayar</strong></td><td><strong>Rp {{ number_format($tagihan->total_bayar, 0, ',', '.') }}</strong></td></tr>
                        <tr><td><strong>Jatuh Tempo</strong></td><td>{{ $tagihan->tanggal_jatuh_tempo->format('d/m/Y') }}</td></tr>
                        <tr><td><strong>Status</strong></td><td>
                            @switch($tagihan->status)
                                @case('lunas') <span class="badge badge-success">Lunas</span> @break
                                @case('belum_bayar') <span class="badge badge-warning">Belum Bayar</span> @break
                                @case('jatuh_tempo') <span class="badge badge-danger">Jatuh Tempo</span> @break
                            @endswitch
                        </td></tr>
                    </table>
                    @if($tagihan->status != 'lunas')
                        <a href="{{ route('wali.pembayaran.bayar', $tagihan) }}" class="btn btn-primary w-100"><i class="bi bi-credit-card"></i> Bayar Sekarang</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Informasi Santri</h3></div>
                <div class="card-body">
                    <table class="table">
                        <tr><td><strong>NIS</strong></td><td>{{ $tagihan->santri->nis }}</td></tr>
                        <tr><td><strong>Nama</strong></td><td>{{ $tagihan->santri->nama_lengkap }}</td></tr>
                        <tr><td><strong>Kelas</strong></td><td>{{ $tagihan->santri->kelas->nama_kelas ?? '-' }}</td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
