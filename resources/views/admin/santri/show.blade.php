{{-- ===================================================== --}}
{{-- FILE: show.blade.php (Santri) --}}
{{-- DESKRIPSI: Halaman detail santri lengkap dengan info, --}}
{{--          wali, dan riwayat tagihan --}}
{{-- LOKASI: resources/views/admin/santri/show.blade.php --}}
{{-- CONTROLLER: Admin/SantriController@show --}}
{{-- ROUTE: GET /admin/santri/{santri} --}}
{{-- ===================================================== --}}

@extends('layouts.admin')

@section('title', 'Detail Santri')

@section('content')
    {{-- ================================================= --}}
    {{-- HEADER DENGAN TOMBOL AKSI --}}
    {{-- ================================================= --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Santri</h1>
            {{-- Menampilkan nama santri --}}
            <p class="page-subtitle">{{ $santri->nama_lengkap }}</p>
        </div>
        {{-- d-flex gap-2: Flexbox dengan jarak antar elemen --}}
        <div class="d-flex gap-2">
            {{-- Tombol Edit --}}
            <a href="{{ route('admin.santri.edit', $santri) }}" class="btn btn-primary">
                <i class="bi bi-pencil"></i> Edit
            </a>
            {{-- Tombol Kembali ke daftar --}}
            <a href="{{ route('admin.santri.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    {{-- ================================================= --}}
    {{-- BARIS 1: INFO SANTRI & WALI (2 KOLOM) --}}
    {{-- ================================================= --}}
    <div class="row">
        {{-- KOLOM KIRI: Informasi Santri --}}
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Santri</h3>
                </div>
                <div class="card-body">
                    {{-- Tabel untuk menampilkan data secara rapi --}}
                    <table class="table">
                        {{-- Baris NIS --}}
                        {{-- style="width: 150px;": Lebar kolom label tetap --}}
                        <tr>
                            <td style="width: 150px;"><strong>NIS</strong></td>
                            <td>{{ $santri->nis }}</td>
                        </tr>
                        {{-- Baris Nama --}}
                        <tr>
                            <td><strong>Nama Lengkap</strong></td>
                            <td>{{ $santri->nama_lengkap }}</td>
                        </tr>
                        {{-- Baris Jenis Kelamin dengan ternary --}}
                        <tr>
                            <td><strong>Jenis Kelamin</strong></td>
                            {{-- Ternary: Jika 'L' maka 'Laki-laki', else 'Perempuan' --}}
                            <td>{{ $santri->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        </tr>
                        {{-- Baris TTL --}}
                        <tr>
                            <td><strong>Tempat, Tgl Lahir</strong></td>
                            <td>
                                {{ $santri->tempat_lahir }}, 
                                {{-- ?? '-': Default '-' jika tanggal null --}}
                                {{ $santri->tanggal_lahir?->format('d/m/Y') ?? '-' }}
                            </td>
                        </tr>
                        {{-- Baris Alamat dengan default --}}
                        <tr>
                            <td><strong>Alamat</strong></td>
                            <td>{{ $santri->alamat ?? '-' }}</td>
                        </tr>
                        {{-- Baris Kelas (dari relasi) --}}
                        <tr>
                            <td><strong>Kelas</strong></td>
                            {{-- Akses relasi: $santri->kelas->nama_kelas --}}
                            <td>{{ $santri->kelas->nama_kelas }}</td>
                        </tr>
                        {{-- Baris Tanggal Masuk --}}
                        <tr>
                            <td><strong>Tanggal Masuk</strong></td>
                            <td>{{ $santri->tanggal_masuk?->format('d/m/Y') ?? '-' }}</td>
                        </tr>
                        {{-- Baris Status dengan Badge --}}
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>
                                {{-- Badge dinamis berdasarkan status --}}
                                {{-- badge-success (hijau) untuk aktif, badge-secondary untuk lainnya --}}
                                <span class="badge badge-{{ $santri->status == 'aktif' ? 'success' : 'secondary' }}">
                                    {{-- ucfirst(): Kapital huruf pertama --}}
                                    {{ ucfirst($santri->status) }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        {{-- KOLOM KANAN: Wali Santri --}}
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Wali Santri</h3>
                </div>
                <div class="card-body">
                    {{-- Cek apakah santri memiliki wali --}}
                    @if($santri->wali->count() > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Hubungan</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Loop data wali --}}
                                @foreach($santri->wali as $wali)
                                    <tr>
                                        <td>{{ $wali->name }}</td>
                                        <td>{{ $wali->email }}</td>
                                        {{-- pivot->hubungan: Akses kolom dari tabel pivot (wali_santri) --}}
                                        <td>{{ ucfirst($wali->pivot->hubungan) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        {{-- Pesan jika belum ada wali --}}
                        <p class="text-muted">Belum ada wali yang terhubung.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================= --}}
    {{-- RIWAYAT TAGIHAN --}}
    {{-- ================================================= --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Riwayat Tagihan</h3>
        </div>
        {{-- table-responsive: Scroll horizontal jika tabel terlalu lebar --}}
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tagihan</th>
                        <th>Periode</th>
                        <th>Total</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @forelse: Loop dengan fallback jika kosong --}}
                    @forelse($santri->tagihan as $tagihan)
                        <tr>
                            <td>{{ $tagihan->nama_tagihan }}</td>
                            <td>{{ $tagihan->periode ?? '-' }}</td>
                            {{-- Format Rupiah --}}
                            <td>Rp {{ number_format($tagihan->total_bayar, 0, ',', '.') }}</td>
                            <td>{{ $tagihan->tanggal_jatuh_tempo->format('d/m/Y') }}</td>
                            <td>
                                {{-- Badge status dengan switch --}}
                                @switch($tagihan->status)
                                    @case('lunas')
                                        <span class="badge badge-success">Lunas</span>
                                        @break
                                    @case('belum_bayar')
                                        <span class="badge badge-warning">Belum Bayar</span>
                                        @break
                                    @case('pending')
                                        <span class="badge badge-info">Pending</span>
                                        @break
                                    @case('jatuh_tempo')
                                        <span class="badge badge-danger">Jatuh Tempo</span>
                                        @break
                                @endswitch
                            </td>
                        </tr>
                    @empty
                        {{-- colspan="5": Gabungkan 5 kolom --}}
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada tagihan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
