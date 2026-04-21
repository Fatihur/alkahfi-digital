{{--
================================================================================
FILE        : index.blade.php
DESKRIPSI   : Halaman daftar lengkap tagihan SPP untuk wali santri. Menampilkan
              semua tagihan dalam bentuk tabel data dengan fitur sorting,
              searching, dan pagination menggunakan DataTables.
LOKASI      : resources/views/wali/tagihan/index.blade.php
CONTROLLER  : Wali\TagihanController@index
ROUTE       : wali.tagihan.index (GET /wali/tagihan)
================================================================================
--}}

{{-- Menggunakan layout wali sebagai kerangka halaman --}}
@extends('layouts.wali')

{{-- Mengatur judul halaman di browser --}}
@section('title', 'Tagihan SPP')

{{-- Konten utama halaman --}}
@section('content')
    {{-- 
    ============================================================================
    PAGE HEADER
    ============================================================================
    --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Tagihan SPP</h1>
            <p class="page-subtitle">Daftar tagihan SPP anak Anda.</p>
        </div>
    </div>

    {{-- 
    ============================================================================
    DATA TABLE CARD
    ============================================================================
    Tabel lengkap dengan DataTables untuk fitur interaktif
    --}}
    <div class="card">
        <div class="card-body">
            {{-- 
            ID "dataTable" digunakan untuk inisialisasi DataTables JavaScript
            style="width:100%" memastikan tabel mengisi container penuh
            --}}
            <table class="table" id="dataTable" style="width:100%">
                <thead>
                    <tr>
                        <th>Santri</th>
                        <th>Tagihan</th>
                        <th>Periode</th>
                        <th>Total</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                        {{-- width="80" membatasi lebar kolom aksi --}}
                        <th width="80">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Looping melalui collection tagihan --}}
                    @foreach($tagihan as $t)
                        <tr>
                            {{-- Mengakses relasi santri untuk mendapatkan nama lengkap --}}
                            <td>{{ $t->santri->nama_lengkap }}</td>
                            <td>{{ $t->nama_tagihan }}</td>
                            {{-- Null coalescing operator (??) untuk default value --}}
                            <td>{{ $t->periode ?? '-' }}</td>
                            <td>Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</td>
                            {{-- 
                            data-order attribute untuk DataTables sorting
                            Format Y-m-d memastikan sorting tanggal benar
                            --}}
                            <td data-order="{{ $t->tanggal_jatuh_tempo->format('Y-m-d') }}">
                                {{ $t->tanggal_jatuh_tempo->format('d/m/Y') }}
                            </td>
                            <td>
                                {{-- 
                                ============================================================================
                                STATUS BADGE
                                ============================================================================
                                @switch: Kondisional multi-case untuk menampilkan badge sesuai status
                                badge-success = hijau (lunas)
                                badge-warning = kuning/orange (belum bayar)
                                badge-danger = merah (jatuh tempo)
                                --}}
                                @switch($t->status)
                                    @case('lunas')
                                        <span class="badge badge-success">Lunas</span>
                                        @break
                                    @case('belum_bayar')
                                        <span class="badge badge-warning">Belum Bayar</span>
                                        @break
                                    @case('jatuh_tempo')
                                        <span class="badge badge-danger">Jatuh Tempo</span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                {{-- Tombol bayar hanya muncul jika status bukan lunas --}}
                                @if($t->status != 'lunas')
                                    <a href="{{ route('wali.pembayaran.bayar', $t) }}" class="btn btn-sm btn-primary">
                                        {{-- Bootstrap Icons untuk icon kartu kredit --}}
                                        <i class="bi bi-credit-card"></i> Bayar
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

{{-- 
================================================================================
SCRIPTS SECTION
================================================================================
@push('scripts'): Menambahkan script ke stack 'scripts' di layout
Script ini akan dimuat di bagian bawah halaman untuk optimasi loading
================================================================================
--}}
@push('scripts')
<script>
    $(document).ready(function() {
        // Inisialisasi DataTables dengan konfigurasi
        $('#dataTable').DataTable({
            // Sorting default: kolom ke-5 (Jatuh Tempo) ascending
            order: [[4, 'asc']],
            // columnDefs: konfigurasi spesifik per kolom
            columnDefs: [
                // targets: -1 = kolom terakhir (Aksi), tidak bisa disort
                { orderable: false, targets: -1 }
            ]
        });
    });
</script>
@endpush

{{--
================================================================================
CONTOH MODIFIKASI STYLING
================================================================================

1. Menambahkan filter status:
   Tambahkan dropdown filter di atas tabel untuk filter by status

2. Custom badge colors:
   .badge-success { background-color: #28a745; }
   .badge-warning { background-color: #ffc107; color: #000; }
   .badge-danger { background-color: #dc3545; }

3. Row highlighting untuk jatuh tempo:
   @if($t->status == 'jatuh_tempo') style="background-color: #fff3cd;" @endif

4. Format mata uang berbeda:
   Rp {{ number_format($t->total_bayar, 2, ',', '.') }} // dengan 2 desimal
================================================================================
--}}
