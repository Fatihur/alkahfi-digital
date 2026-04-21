{{--
================================================================================
FILE        : index.blade.php
DESKRIPSI   : Halaman riwayat pembayaran SPP untuk wali santri. Menampilkan
              daftar semua pembayaran yang telah dilakukan dengan informasi
              nomor transaksi, jumlah, metode, dan status pembayaran.
LOKASI      : resources/views/wali/pembayaran/index.blade.php
CONTROLLER  : Wali\PembayaranController@index
ROUTE       : wali.pembayaran.index (GET /wali/pembayaran)
================================================================================
--}}

{{-- Menggunakan layout wali sebagai kerangka halaman --}}
@extends('layouts.wali')

{{-- Judul halaman --}}
@section('title', 'Riwayat Pembayaran')

{{-- Konten utama --}}
@section('content')
    {{-- 
    ============================================================================
    PAGE HEADER
    ============================================================================
    --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Riwayat Pembayaran</h1>
            <p class="page-subtitle">Daftar pembayaran yang telah dilakukan.</p>
        </div>
    </div>

    {{-- 
    ============================================================================
    DATA TABLE CARD
    ============================================================================
    Tabel riwayat pembayaran dengan DataTables
    --}}
    <div class="card">
        <div class="card-body">
            <table class="table" id="dataTable" style="width:100%">
                <thead>
                    <tr>
                        <th>No. Transaksi</th>
                        <th>Santri</th>
                        <th>Tagihan</th>
                        <th>Jumlah</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th width="60">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Looping collection pembayaran --}}
                    @foreach($pembayaran as $p)
                        <tr>
                            <td>
                                {{-- <code> untuk menampilkan nomor transaksi dengan font monospace --}}
                                <code>{{ $p->nomor_transaksi }}</code>
                            </td>
                            <td>{{ $p->santri->nama_lengkap }}</td>
                            <td>{{ $p->tagihan->nama_tagihan }}</td>
                            <td>Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                            <td data-order="{{ $p->tanggal_bayar?->format('Y-m-d H:i:s') ?? '' }}">
                                {{-- 
                                Nullsafe operator (?->): Mencegah error jika tanggal_bayar null
                                Format dengan jam dan menit
                                --}}
                                {{ $p->tanggal_bayar?->format('d/m/Y H:i') ?? '-' }}
                            </td>
                            <td>
                                {{-- 
                                ============================================================================
                                STATUS BADGE
                                ============================================================================
                                Ternary operator untuk menentukan class badge
                                berhasil = badge-success (hijau)
                                selain berhasil = badge-warning (kuning)
                                ucfirst(): Kapitalisasi huruf pertama
                                --}}
                                <span class="badge badge-{{ $p->status == 'berhasil' ? 'success' : 'warning' }}">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                            <td>
                                {{-- 
                                ============================================================================
                                TOMBOL CETAK
                                ============================================================================
                                Hanya muncul jika status pembayaran berhasil
                                target="_blank" untuk membuka di tab baru
                                title untuk tooltip
                                --}}
                                @if($p->status == 'berhasil')
                                    <a href="{{ route('wali.pembayaran.cetak', $p) }}" 
                                       class="btn btn-sm btn-primary" 
                                       target="_blank" 
                                       title="Cetak Bukti">
                                        <i class="bi bi-printer"></i>
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
--}}
@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            // Sorting default: kolom ke-5 (Tanggal) descending (terbaru di atas)
            order: [[4, 'desc']],
            columnDefs: [
                // Kolom terakhir (Aksi) tidak bisa disort
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

1. Menambahkan filter periode:
   <div class="card-header">
       <input type="month" class="form-control" id="filterBulan">
   </div>

2. Row styling berdasarkan status:
   <tr class="{{ $p->status == 'berhasil' ? 'table-success' : 'table-warning' }}">

3. Summary statistics:
   <div class="row mb-3">
       <div class="col-3">
           <div class="card bg-success text-white">
               <div class="card-body">
                   <h5>Total Berhasil</h5>
                   <h3>Rp {{ number_format($totalBerhasil) }}</h3>
               </div>
           </div>
       </div>
   </div>

4. Badge dengan icon:
   <span class="badge badge-success">
       <i class="bi bi-check-circle"></i> Berhasil
   </span>
================================================================================
--}}
