{{-- ===================================================== --}}
{{-- FILE: dashboard.blade.php --}}
{{-- DESKRIPSI: View untuk halaman Dashboard Admin --}}
{{--          Menampilkan ringkasan data dan statistik --}}
{{-- LOKASI: resources/views/admin/dashboard.blade.php --}}
{{-- CONTROLLER: Admin/DashboardController.php --}}
{{-- ===================================================== --}}

{{-- @extends('layouts.admin') - Menggunakan layout admin.blade.php --}}
{{-- Layout ini sudah memiliki sidebar, header, dan struktur halaman --}}
@extends('layouts.admin')

{{-- @section('title', ...) - Mengirimkan judul halaman ke layout --}}
{{-- Judul ini akan muncul di tab browser dan header halaman --}}
@section('title', 'Dashboard Admin')

{{-- ===================================================== --}}
{{-- SECTION: KONTEN UTAMA --}}
{{-- ===================================================== --}}
{{-- @section('content') berisi semua konten yang akan --}}
{{-- ditampilkan di area utama halaman (bukan sidebar) --}}
@section('content')

    {{-- ---------------------------------------------------- --}}
    {{-- BAGIAN 1: HEADER HALAMAN --}}
    {{-- ---------------------------------------------------- --}}
    {{-- div.page-header: Container untuk judul dan deskripsi halaman --}}
    {{-- Styling biasanya: padding, border-bottom, margin-bottom --}}
    <div class="page-header">
        <div>
            {{-- h1.page-title: Judul utama halaman --}}
            {{-- Styling: Font besar, bold, warna gelap --}}
            {{-- Contoh styling CSS: font-size: 28px; font-weight: 600; --}}
            <h1 class="page-title">Dashboard</h1>
            
            {{-- p.page-subtitle: Deskripsi singkat halaman --}}
            {{-- Styling: Font lebih kecil, warna abu-abu --}}
            {{-- Contoh styling CSS: font-size: 14px; color: #6c757d; --}}
            <p class="page-subtitle">Ringkasan data sistem pembayaran SPP.</p>
        </div>
    </div>

    {{-- ---------------------------------------------------- --}}
    {{-- BAGIAN 2: STATISTIK UTAMA (4 Card) --}}
    {{-- ---------------------------------------------------- --}}
    {{-- div.row: Container grid Bootstrap --}}
    {{-- Grid system Bootstrap: 12 kolom total --}}
    {{-- col-3 = 3/12 = 25% lebar per card --}}
    {{-- Contoh modifikasi layout: --}}
    {{-- - col-4 = 4 card per baris (lebih besar) --}}
    {{-- - col-6 = 2 card per baris (paling besar) --}}
    <div class="row">
        
        {{-- CARD 1: Total Santri Aktif --}}
        {{-- div.col-3: Mengambil 3 dari 12 kolom (25% lebar) --}}
        <div class="col-3">
            {{-- div.card: Container card dengan border, shadow --}}
            {{-- class 'stat-card' = styling khusus untuk card statistik --}}
            {{-- CSS contoh: border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); --}}
            <div class="card stat-card">
                {{-- div.stat-header: Header card untuk ikon --}}
                <div class="stat-header">
                    {{-- div.stat-icon: Container untuk ikon statistik --}}
                    {{-- class 'primary' = warna tema utama (biru) --}}
                    {{-- Contoh warna lain: success (hijau), warning (kuning), danger (merah) --}}
                    {{-- Contoh modifikasi warna: style="background: #3b82f6; color: white;" --}}
                    <div class="stat-icon primary">
                        {{-- i.bi.bi-people: Ikon grup orang dari Bootstrap Icons --}}
                        {{-- Untuk mengganti ikon: ganti 'people' dengan nama ikon lain --}}
                        {{-- Lihat daftar ikon: https://icons.getbootstrap.com/ --}}
                        <i class="bi bi-people"></i>
                    </div>
                </div>
                {{-- div.stat-value: Angka statistik utama --}}
                {{-- number_format(): Format angka dengan pemisah ribuan --}}
                {{-- Contoh: 1500 menjadi "1.500" --}}
                {{-- Variable $totalSantri dikirim dari DashboardController --}}
                <div class="stat-value">{{ number_format($totalSantri) }}</div>
                {{-- div.stat-label: Label deskripsi statistik --}}
                <div class="stat-label">Total Santri Aktif</div>
            </div>
        </div>
        
        {{-- CARD 2: Total Wali Santri --}}
        <div class="col-3">
            <div class="card stat-card">
                <div class="stat-header">
                    {{-- class 'success' = warna hijau --}}
                    {{-- CSS contoh: background: rgba(16, 185, 129, 0.1); color: #10b981; --}}
                    <div class="stat-icon success">
                        {{-- bi-person-check: Ikon orang dengan centang --}}
                        <i class="bi bi-person-check"></i>
                    </div>
                </div>
                <div class="stat-value">{{ number_format($totalWali) }}</div>
                <div class="stat-label">Total Wali Santri</div>
            </div>
        </div>
        
        {{-- CARD 3: Total Tagihan Belum Bayar --}}
        <div class="col-3">
            <div class="card stat-card">
                <div class="stat-header">
                    {{-- class 'warning' = warna kuning/oranye --}}
                    <div class="stat-icon warning">
                        {{-- bi-receipt: Ikon struk/kwitansi --}}
                        <i class="bi bi-receipt"></i>
                    </div>
                </div>
                {{-- Format Rupiah: Rp + number_format dengan 0 desimal --}}
                {{-- Parameter number_format: (nilai, desimal, pemisah_desimal, pemisah_ribuan) --}}
                {{-- Contoh: Rp {{ number_format(5000000, 0, ',', '.') }} = Rp 5.000.000 --}}
                <div class="stat-value">Rp {{ number_format($totalTagihan, 0, ',', '.') }}</div>
                <div class="stat-label">Total Tagihan Belum Bayar</div>
            </div>
        </div>
        
        {{-- CARD 4: Total Pembayaran Masuk --}}
        <div class="col-3">
            <div class="card stat-card">
                <div class="stat-header">
                    {{-- class 'info' = warna biru muda/cyan --}}
                    <div class="stat-icon info">
                        {{-- bi-cash-stack: Ikon tumpukan uang --}}
                        <i class="bi bi-cash-stack"></i>
                    </div>
                </div>
                <div class="stat-value">Rp {{ number_format($totalPembayaran, 0, ',', '.') }}</div>
                <div class="stat-label">Total Pembayaran Masuk</div>
            </div>
        </div>
    </div>

    {{-- ---------------------------------------------------- --}}
    {{-- BAGIAN 3: STATISTIK TAGIHAN (3 Card) --}}
    {{-- ---------------------------------------------------- --}}
    {{-- col-4 = 4/12 = 33.33% lebar per card --}}
    <div class="row">
        
        {{-- CARD 5: Tagihan Belum Bayar (Jumlah) --}}
        <div class="col-4">
            <div class="card stat-card">
                <div class="stat-header">
                    <div class="stat-icon warning">
                        {{-- bi-hourglass-split: Ikon jam pasir --}}
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                </div>
                <div class="stat-value">{{ number_format($tagihanBelumBayar) }}</div>
                <div class="stat-label">Tagihan Belum Bayar</div>
            </div>
        </div>
        
        {{-- CARD 6: Tagihan Lunas --}}
        <div class="col-4">
            <div class="card stat-card">
                <div class="stat-header">
                    <div class="stat-icon success">
                        {{-- bi-check-circle: Ikon lingkaran dengan centang --}}
                        <i class="bi bi-check-circle"></i>
                    </div>
                </div>
                <div class="stat-value">{{ number_format($tagihanLunas) }}</div>
                <div class="stat-label">Tagihan Lunas</div>
            </div>
        </div>
        
        {{-- CARD 7: Tagihan Jatuh Tempo --}}
        <div class="col-4">
            <div class="card stat-card">
                <div class="stat-header">
                    {{-- CONTOH: Inline styling untuk warna custom --}}
                    {{-- background: rgba(239, 68, 68, 0.1) = merah dengan opacity 10% --}}
                    {{-- color: #ef4444 = warna merah solid (Tailwind red-500) --}}
                    {{-- Kode warna lain: #3b82f6 (biru), #10b981 (hijau), #f59e0b (kuning) --}}
                    <div class="stat-icon" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                        {{-- bi-exclamation-triangle: Ikon segitiga peringatan --}}
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                </div>
                <div class="stat-value">{{ number_format($tagihanJatuhTempo) }}</div>
                <div class="stat-label">Tagihan Jatuh Tempo</div>
            </div>
        </div>
    </div>

    {{-- ---------------------------------------------------- --}}
    {{-- BAGIAN 4: TABEL DATA --}}
    {{-- ---------------------------------------------------- --}}
    {{-- col-6 = 50% lebar, 2 kolom per baris --}}
    <div class="row">
        
        {{-- TABEL 1: Pembayaran Terbaru --}}
        <div class="col-6">
            {{-- div.card: Container untuk tabel --}}
            <div class="card">
                {{-- div.card-header: Header card dengan judul dan tombol --}}
                {{-- Styling: border-bottom, padding, flexbox untuk alignment --}}
                <div class="card-header">
                    {{-- h3.card-title: Judul card --}}
                    <h3 class="card-title">Pembayaran Terbaru</h3>
                    {{-- a.btn.btn-sm.btn-secondary: Tombol kecil sekunder --}}
                    {{-- route('admin.pembayaran.index') = link ke halaman daftar pembayaran --}}
                    {{-- Styling btn-sm: padding lebih kecil, font lebih kecil --}}
                    <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-sm btn-secondary">Lihat Semua</a>
                </div>
                
                {{-- div.table-responsive: Membuat tabel scrollable di mobile --}}
                {{-- CSS: overflow-x: auto; - tambah scrollbar horizontal jika perlu --}}
                <div class="table-responsive">
                    {{-- table.table: Tabel Bootstrap dengan styling default --}}
                    {{-- Styling default: border, striped rows, hover effect --}}
                    <table class="table">
                        {{-- thead: Header tabel (judul kolom) --}}
                        <thead>
                            {{-- tr: Table row (baris) --}}
                            <tr>
                                {{-- th: Table header cell (sel header) --}}
                                {{-- Styling: bold, background abu-abu muda --}}
                                <th>Santri</th>
                                <th>Tagihan</th>
                                <th>Jumlah</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        {{-- tbody: Body tabel (data) --}}
                        <tbody>
                            {{-- @forelse: Loop Laravel dengan fallback jika kosong --}}
                            {{-- Sama seperti foreach, tapi punya @empty untuk data kosong --}}
                            {{-- $pembayaranTerbaru: Array collection dari controller --}}
                            {{-- $p: Variable untuk setiap item dalam loop --}}
                            @forelse($pembayaranTerbaru as $p)
                                <tr>
                                    {{-- td: Table data cell (sel data) --}}
                                    {{-- $p->santri->nama_lengkap: Akses relasi model --}}
                                    {{-- Relasi 'santri' didefinisikan di Model Pembayaran --}}
                                    <td>{{ $p->santri->nama_lengkap }}</td>
                                    <td>{{ $p->tagihan->nama_tagihan }}</td>
                                    {{-- Format mata uang Rupiah --}}
                                    <td>Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                                    {{-- Format tanggal: format('d/m/Y') = 25/12/2024 --}}
                                    {{-- Format lain: 'd F Y' = 25 Desember 2024 --}}
                                    <td>{{ $p->tanggal_bayar->format('d/m/Y') }}</td>
                                </tr>
                            {{-- @empty: Ditampilkan jika $pembayaranTerbaru kosong --}}
                            @empty
                                <tr>
                                    {{-- colspan="4": Gabungkan 4 kolom jadi 1 --}}
                                    {{-- class text-center: Align teks ke tengah --}}
                                    {{-- class text-muted: Warna teks abu-abu --}}
                                    <td colspan="4" class="text-center text-muted">Belum ada pembayaran</td>
                                </tr>
                            {{-- @endforelse: Menutup loop --}}
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        {{-- TABEL 2: Tagihan Mendekati Jatuh Tempo --}}
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tagihan Mendekati Jatuh Tempo</h3>
                    <a href="{{ route('admin.tagihan.index') }}" class="btn btn-sm btn-secondary">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Santri</th>
                                <th>Tagihan</th>
                                <th>Total</th>
                                <th>Jatuh Tempo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tagihanTerbaru as $t)
                                <tr>
                                    <td>{{ $t->santri->nama_lengkap }}</td>
                                    <td>{{ $t->nama_tagihan }}</td>
                                    <td>Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</td>
                                    <td>{{ $t->tanggal_jatuh_tempo->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Tidak ada tagihan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
{{-- @endsection: Menutup section 'content' --}}
@endsection
