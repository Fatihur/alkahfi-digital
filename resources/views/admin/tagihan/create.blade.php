{{--
================================================================================
FILE        : create.blade.php
DESKRIPSI   : Halaman form untuk membuat tagihan SPP baru dengan fitur
              pilihan tipe tagihan (per santri/per kelas) dan validasi
LOKASI      : resources/views/admin/tagihan/create.blade.php
CONTROLLER  : TagihanController@create, TagihanController@store
ROUTE       : GET /admin/tagihan/create, POST /admin/tagihan
================================================================================
--}}

{{-- 
@extends('layouts.admin')
Menggunakan layout admin sebagai kerangka dasar halaman
Layout ini berisi struktur HTML, CSS, dan JavaScript yang digunakan bersama
--}}
@extends('layouts.admin')

{{-- Section title untuk judul halaman di browser tab --}}
@section('title', 'Buat Tagihan')

{{-- Section content berisi konten utama halaman --}}
@section('content')
    {{-- Header halaman dengan judul dan deskripsi --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Buat Tagihan</h1>
            <p class="page-subtitle">Buat tagihan SPP baru untuk santri.</p>
        </div>
    </div>

    {{-- 
    ============================================================
    BAGIAN: Error Validation
    Menampilkan pesan error jika validasi form gagal
    ============================================================
    --}}
    {{-- 
    @if($errors->any())
    Mengecek apakah ada error validasi dari controller
    $errors adalah variabel global Laravel untuk menyimpan error validasi
    --}}
    @if($errors->any())
        {{-- 
        Alert Error Styling
        alert alert-danger: Box merah untuk pesan error
        margin:0 dan padding-left:20px: Styling kustom untuk list
        --}}
        <div class="alert alert-danger">
            <ul style="margin:0;padding-left:20px;">
                {{-- 
                @foreach($errors->all() as $error)
                Looping semua pesan error dan menampilkannya sebagai list
                --}}
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 
    ============================================================
    BAGIAN: Form Create Tagihan
    Form dengan method POST ke route admin.tagihan.store
    ============================================================
    --}}
    <div class="card">
        <div class="card-body">
            {{-- 
            Form Tagihan
            action: route('admin.tagihan.store') -> URL tujuan submit
            method: POST (sesuai REST convention untuk create)
            enctype default: application/x-www-form-urlencoded
            --}}
            <form action="{{ route('admin.tagihan.store') }}" method="POST">
                {{-- 
                @csrf
                Token CSRF (Cross-Site Request Forgery) wajib untuk form POST
                Melindungi dari serangan CSRF
                --}}
                @csrf

                {{-- 
                ========================================================
                BARIS 1: Tipe Penerapan & Santri/Kelas
                ========================================================
                --}}
                <div class="row">
                    {{-- Kolom Kiri: Pilihan Tipe Tagihan --}}
                    <div class="col-6">
                        <div class="form-group">
                            {{-- Label dengan penanda required (* merah) --}}
                            <label class="form-label">Tipe Penerapan <span class="text-danger">*</span></label>
                            {{-- 
                            Select Tipe Tagihan
                            id="tipe_tagihan": ID untuk JavaScript event listener
                            class form-control form-select: Styling Bootstrap
                            required: Validasi HTML5, field wajib diisi
                            --}}
                            <select name="tipe_tagihan" id="tipe_tagihan" class="form-control form-select" required>
                                {{-- 
                                Option values:
                                individual: Tagihan untuk satu santri tertentu
                                kelas: Tagihan untuk semua santri dalam satu kelas
                                --}}
                                <option value="individual">Per Santri</option>
                                <option value="kelas">Per Kelas</option>
                            </select>
                        </div>
                    </div>
                    {{-- Kolom Kanan: Santri atau Kelas (dinamis dengan JS) --}}
                    <div class="col-6">
                        {{-- 
                        Group Santri
                        id="santri_group": Target JavaScript untuk show/hide
                        Tampil default saat tipe_tagihan = individual
                        --}}
                        <div class="form-group" id="santri_group">
                            <label class="form-label">Santri <span class="text-danger">*</span></label>
                            <select name="santri_id" class="form-control form-select">
                                <option value="">Pilih Santri</option>
                                {{-- 
                                @foreach($santriList as $s)
                                Looping daftar santri dari controller
                                Menampilkan format: NIS - Nama Lengkap
                                --}}
                                @foreach($santriList as $s)
                                    <option value="{{ $s->id }}">{{ $s->nis }} - {{ $s->nama_lengkap }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- 
                        Group Kelas
                        id="kelas_group": Target JavaScript untuk show/hide
                        style="display:none": Hidden by default
                        Muncul saat tipe_tagihan = kelas (via JavaScript)
                        --}}
                        <div class="form-group" id="kelas_group" style="display:none;">
                            <label class="form-label">Kelas <span class="text-danger">*</span></label>
                            <select name="kelas_id" class="form-control form-select">
                                <option value="">Pilih Kelas</option>
                                {{-- Looping daftar kelas dari controller --}}
                                @foreach($kelasList as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- 
                ========================================================
                BARIS 2: Nama Tagihan
                ========================================================
                --}}
                <div class="form-group">
                    <label class="form-label">Nama Tagihan <span class="text-danger">*</span></label>
                    {{-- 
                    Input Text untuk Nama Tagihan
                    type="text": Input teks biasa
                    name="nama_tagihan": Akan menjadi key di $request di controller
                    placeholder: Hint teks yang muncul saat kosong
                    Contoh modifikasi styling: class="form-control form-control-lg" untuk input besar
                    --}}
                    <input type="text" name="nama_tagihan" class="form-control" placeholder="Contoh: SPP Januari 2025" required>
                </div>

                {{-- 
                ========================================================
                BARIS 3: Periode, Bulan, Tahun
                ========================================================
                --}}
                <div class="row">
                    {{-- Kolom Periode --}}
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">Periode</label>
                            {{-- Input opsional untuk periode/tagihan --}}
                            <input type="text" name="periode" class="form-control" placeholder="Contoh: Januari 2025">
                        </div>
                    </div>
                    {{-- Kolom Bulan --}}
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">Bulan</label>
                            <select name="bulan" class="form-control form-select">
                                <option value="">Pilih Bulan</option>
                                {{-- 
                                Array bulan dalam bahasa Indonesia
                                @foreach dengan $i => $bulan untuk mendapatkan index (0-11) dan value
                                value="{{ $i+1 }}": Nilai 1-12 (sesuai format database)
                                --}}
                                @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $bulan)
                                    <option value="{{ $i+1 }}">{{ $bulan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- Kolom Tahun --}}
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">Tahun <span class="text-danger">*</span></label>
                            {{-- 
                            Input Tahun dengan nilai default tahun sekarang
                            date('Y'): Fungsi PHP untuk mendapatkan tahun sekarang (4 digit)
                            Contoh: 2025
                            --}}
                            <input type="number" name="tahun" class="form-control" value="{{ date('Y') }}" required>
                        </div>
                    </div>
                </div>

                {{-- 
                ========================================================
                BARIS 4: Nominal & Tanggal Jatuh Tempo
                ========================================================
                --}}
                <div class="row">
                    {{-- Kolom Nominal --}}
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Nominal (Rp) <span class="text-danger">*</span></label>
                            {{-- 
                            Input Nominal
                            type="number": Hanya menerima angka
                            min="0": Tidak boleh negatif
                            Validasi: server-side juga harus dilakukan di controller
                            --}}
                            <input type="number" name="nominal" class="form-control" min="0" required>
                        </div>
                    </div>
                    {{-- Kolom Tanggal Jatuh Tempo --}}
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Tanggal Jatuh Tempo <span class="text-danger">*</span></label>
                            {{-- 
                            Input Date Picker
                            type="date": Menampilkan kalender picker di browser
                            Format value: YYYY-MM-DD (ISO standard)
                            --}}
                            <input type="date" name="tanggal_jatuh_tempo" class="form-control" required>
                        </div>
                    </div>
                </div>

                {{-- 
                ========================================================
                BARIS 5: Keterangan (Opsional)
                ========================================================
                --}}
                <div class="form-group">
                    <label class="form-label">Keterangan</label>
                    {{-- 
                    Textarea untuk keterangan panjang
                    rows="3": Tinggi default 3 baris
                    Bisa ditambahkan class resize-none untuk mencegah resize
                    --}}
                    <textarea name="keterangan" class="form-control" rows="3"></textarea>
                </div>

                {{-- 
                ========================================================
                BARIS 6: Tombol Aksi
                ========================================================
                d-flex gap-2: Flexbox dengan gap 0.5rem antara tombol
                --}}
                <div class="d-flex gap-2">
                    {{-- Tombol Submit Simpan --}}
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check"></i> Simpan</button>
                    {{-- Tombol Batal kembali ke halaman index --}}
                    <a href="{{ route('admin.tagihan.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection

{{-- 
@push('scripts')
JavaScript untuk interaksi dinamis form
Script ini akan dipush ke stack 'scripts' di layout parent
--}}
@push('scripts')
<script>
    {{-- 
    Event Listener untuk Select Tipe Tagihan
    Ketika user mengubah pilihan (individual/kelas), tampilkan form yang sesuai
    --}}
    document.getElementById('tipe_tagihan').addEventListener('change', function() {
        {{-- Sembunyikan semua group terlebih dahulu --}}
        document.getElementById('santri_group').style.display = 'none';
        document.getElementById('kelas_group').style.display = 'none';
        
        {{-- Tampilkan group sesuai pilihan --}}
        if (this.value === 'individual') {
            {{-- Tampilkan select santri --}}
            document.getElementById('santri_group').style.display = 'block';
        } else if (this.value === 'kelas') {
            {{-- Tampilkan select kelas --}}
            document.getElementById('kelas_group').style.display = 'block';
        }
    });
</script>
@endpush
