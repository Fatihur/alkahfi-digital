{{--
================================================================================
FILE        : create.blade.php
DESKRIPSI   : Halaman form untuk membuat tagihan SPP baru. Mendukung dua mode
              penerapan: Individual (per santri) atau Kelas (per kelas).
              Form berisi field nama tagihan, periode, nominal, dan jatuh tempo.
LOKASI      : resources/views/bendahara/tagihan/create.blade.php
CONTROLLER  : Bendahara\TagihanController@create, @store
ROUTE       : GET /bendahara/tagihan/create, POST /bendahara/tagihan
================================================================================

CONTOH MODIFIKASI STYLING:
- Tambahkan field baru: Tambahkan <div class="form-group"> dengan input baru
- Ubah layout kolom: Ganti "col-6" menjadi "col-4" atau "col-12"
- Tambahkan validasi: Gunakan atribut HTML5 seperti min, max, pattern

DATA YANG DIBUTUHKAN DARI CONTROLLER:
- $santriList: Collection santri untuk dropdown
- $kelasList: Collection kelas untuk dropdown
================================================================================
--}}

{{-- Mewarisi layout bendahara --}}
@extends('layouts.bendahara')

{{-- Judul halaman --}}
@section('title', 'Buat Tagihan')

{{-- Konten utama halaman --}}
@section('content')
    
    {{-- PAGE HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Buat Tagihan</h1>
            <p class="page-subtitle">Buat tagihan SPP baru untuk santri.</p>
        </div>
    </div>

    {{-- ALERT ERROR VALIDASI --}}
    {{-- @if: Kondisi menampilkan error jika ada --}}
    {{-- $errors->any(): Mengecek apakah ada error validasi --}}
    @if($errors->any())
        {{-- alert alert-danger: Komponen alert merah dari Bootstrap --}}
        <div class="alert alert-danger">
            {{-- List error validasi --}}
            <ul style="margin:0;padding-left:20px;">
                {{-- @foreach: Loop semua pesan error --}}
                {{-- $errors->all(): Mengembalikan array semua pesan error --}}
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- CARD FORM TAGIHAN --}}
    <div class="card">
        <div class="card-body">
            {{-- FORM CREATE TAGIHAN --}}
            {{-- action: URL tujuan submit form (route store) --}}
            {{-- method="POST": HTTP method untuk create data --}}
            <form action="{{ route('bendahara.tagihan.store') }}" method="POST">
                
                {{-- @csrf: Token CSRF untuk keamanan form Laravel (WAJIB) --}}
                @csrf
                
                {{-- ROW 1: TIPE PENERAPAN & TARGET (Santri/Kelas) --}}
                <div class="row">
                    {{-- KOLOM TIPE PENERAPAN --}}
                    <div class="col-6">
                        <div class="form-group">
                            {{-- LABEL INPUT --}}
                            <label class="form-label">
                                Tipe Penerapan 
                                {{-- text-danger: Warna merah untuk wajib diisi --}}
                                <span class="text-danger">*</span>
                            </label>
                            {{-- SELECT DROPDOWN --}}
                            {{-- id="tipe_tagihan": ID untuk JavaScript manipulasi --}}
                            {{-- required: Validasi HTML5 wajib diisi --}}
                            <select name="tipe_tagihan" id="tipe_tagihan" class="form-control form-select" required>
                                {{-- Opsi Individual: Tagihan untuk 1 santri --}}
                                <option value="individual">Per Santri</option>
                                {{-- Opsi Kelas: Tagihan untuk semua santri dalam kelas --}}
                                <option value="kelas">Per Kelas</option>
                            </select>
                        </div>
                    </div>
                    
                    {{-- KOLOM TARGET (Santri atau Kelas) --}}
                    <div class="col-6">
                        {{-- GROUP SANTRI (Tampil default) --}}
                        {{-- id="santri_group": Target JavaScript show/hide --}}
                        <div class="form-group" id="santri_group">
                            <label class="form-label">Santri <span class="text-danger">*</span></label>
                            <select name="santri_id" class="form-control form-select">
                                <option value="">Pilih Santri</option>
                                {{-- Loop data santri dari controller --}}
                                @foreach($santriList as $s)
                                    <option value="{{ $s->id }}">{{ $s->nis }} - {{ $s->nama_lengkap }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        {{-- GROUP KELAS (Hidden default) --}}
                        {{-- style="display:none;": Disembunyikan via CSS --}}
                        <div class="form-group" id="kelas_group" style="display:none;">
                            <label class="form-label">Kelas <span class="text-danger">*</span></label>
                            <select name="kelas_id" class="form-control form-select">
                                <option value="">Pilih Kelas</option>
                                {{-- Loop data kelas dari controller --}}
                                @foreach($kelasList as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- ROW 2: NAMA TAGIHAN --}}
                <div class="form-group">
                    <label class="form-label">Nama Tagihan <span class="text-danger">*</span></label>
                    {{-- INPUT TEXT --}}
                    {{-- placeholder: Teks hint di input --}}
                    <input type="text" name="nama_tagihan" class="form-control" placeholder="Contoh: SPP Januari 2025" required>
                </div>

                {{-- ROW 3: PERIODE, BULAN, TAHUN --}}
                <div class="row">
                    {{-- KOLOM PERIODE --}}
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">Periode</label>
                            <input type="text" name="periode" class="form-control" placeholder="Contoh: Januari 2025">
                        </div>
                    </div>
                    {{-- KOLOM BULAN --}}
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">Bulan</label>
                            <select name="bulan" class="form-control form-select">
                                <option value="">Pilih Bulan</option>
                                {{-- Array bulan dalam Bahasa Indonesia --}}
                                @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $bulan)
                                    {{-- $i+1: Nilai 1-12 untuk database --}}
                                    <option value="{{ $i+1 }}">{{ $bulan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- KOLOM TAHUN --}}
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">Tahun <span class="text-danger">*</span></label>
                            {{-- date('Y'): Helper PHP mengembalikan tahun sekarang --}}
                            <input type="number" name="tahun" class="form-control" value="{{ date('Y') }}" required>
                        </div>
                    </div>
                </div>

                {{-- ROW 4: NOMINAL & JATUH TEMPO --}}
                <div class="row">
                    {{-- KOLOM NOMINAL --}}
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Nominal (Rp) <span class="text-danger">*</span></label>
                            {{-- min="0": Validasi HTML5 tidak boleh negatif --}}
                            <input type="number" name="nominal" class="form-control" min="0" required>
                        </div>
                    </div>
                    {{-- KOLOM TANGGAL JATUH TEMPO --}}
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Tanggal Jatuh Tempo <span class="text-danger">*</span></label>
                            {{-- type="date": Input khusus tanggal dengan datepicker --}}
                            <input type="date" name="tanggal_jatuh_tempo" class="form-control" required>
                        </div>
                    </div>
                </div>

                {{-- ROW 5: KETERANGAN --}}
                <div class="form-group">
                    <label class="form-label">Keterangan</label>
                    {{-- TEXTAREA: Input multi-baris --}}
                    {{-- rows="3": Tinggi textarea 3 baris --}}
                    <textarea name="keterangan" class="form-control" rows="3"></textarea>
                </div>

                {{-- TOMBOL AKSI FORM --}}
                {{-- d-flex gap-2: Flexbox dengan gap 0.5rem antar elemen --}}
                <div class="d-flex gap-2">
                    {{-- TOMBOL SIMPAN --}}
                    {{-- type="submit": Tombol untuk submit form --}}
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check"></i> Simpan
                    </button>
                    {{-- TOMBOL BATAL --}}
                    {{-- route('bendahara.tagihan.index'): Kembali ke daftar tagihan --}}
                    <a href="{{ route('bendahara.tagihan.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
    
{{-- @endsection: Penutup section content --}}
@endsection

{{-- @push('scripts'): Script JavaScript tambahan --}}
@push('scripts')
<script>
    {{-- Event listener untuk dropdown tipe_tagihan --}}
    document.getElementById('tipe_tagihan').addEventListener('change', function() {
        {{-- Sembunyikan kedua group terlebih dahulu --}}
        document.getElementById('santri_group').style.display = 'none';
        document.getElementById('kelas_group').style.display = 'none';
        
        {{-- Tampilkan group sesuai pilihan --}}
        if (this.value === 'individual') {
            document.getElementById('santri_group').style.display = 'block';
        } else if (this.value === 'kelas') {
            document.getElementById('kelas_group').style.display = 'block';
        }
    });
</script>
@endpush
