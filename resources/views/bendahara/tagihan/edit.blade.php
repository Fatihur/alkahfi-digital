{{--
================================================================================
FILE        : edit.blade.php
DESKRIPSI   : Halaman form untuk mengedit data tagihan SPP yang sudah ada.
              Form menampilkan data tagihan yang dapat diedit termasuk
              nama, periode, nominal, diskon, denda, dan jatuh tempo.
LOKASI      : resources/views/bendahara/tagihan/edit.blade.php
CONTROLLER  : Bendahara\TagihanController@edit, @update
ROUTE       : GET /bendahara/tagihan/{tagihan}/edit, PUT /bendahara/tagihan/{tagihan}
================================================================================

CONTOH MODIFIKASI STYLING:
- Tambahkan field baru: Contoh field keterangan dengan editor WYSIWYG
- Ubah layout: Ganti row menjadi 3 kolom dengan col-4
- Tambahkan preview: Tampilkan preview perubahan sebelum disimpan

DATA YANG DIBUTUHKAN DARI CONTROLLER:
- $tagihan: Model Tagihan yang sedang diedit dengan relasi santri
================================================================================
--}}

{{-- Mewarisi layout bendahara --}}
@extends('layouts.bendahara')

{{-- Judul halaman --}}
@section('title', 'Edit Tagihan')

{{-- Konten utama halaman --}}
@section('content')
    
    {{-- PAGE HEADER dengan informasi tagihan yang diedit --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Tagihan</h1>
            {{-- Menampilkan nama tagihan dan nama santri yang bersangkutan --}}
            <p class="page-subtitle">{{ $tagihan->nama_tagihan }} - {{ $tagihan->santri->nama_lengkap }}</p>
        </div>
    </div>

    {{-- CARD FORM EDIT --}}
    <div class="card">
        <div class="card-body">
            {{-- FORM UPDATE TAGIHAN --}}
            {{-- route(): Menggunakan route update dengan parameter $tagihan --}}
            {{-- Parameter akan di-convert ke ID untuk URL --}}
            <form action="{{ route('bendahara.tagihan.update', $tagihan) }}" method="POST">
                
                {{-- @csrf: Token keamanan CSRF (WAJIB untuk form Laravel) --}}
                @csrf
                {{-- @method('PUT'): Method spoofing untuk HTTP PUT --}}
                {{-- Laravel form hanya support GET/POST, untuk PUT/PATCH/DELETE gunakan @method() --}}
                @method('PUT')
                
                {{-- ROW 1: NAMA TAGIHAN & PERIODE --}}
                <div class="row">
                    {{-- KOLOM NAMA TAGIHAN --}}
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Nama Tagihan <span class="text-danger">*</span></label>
                            {{-- INPUT DENGAN OLD DATA --}}
                            {{-- old(): Helper Laravel mengembalikan nilai input sebelumnya --}}
                            {{-- old('field', 'default'): Parameter kedua adalah nilai default --}}
                            {{-- $tagihan->nama_tagihan: Nilai dari database jika tidak ada old input --}}
                            <input type="text" name="nama_tagihan" class="form-control" value="{{ old('nama_tagihan', $tagihan->nama_tagihan) }}" required>
                        </div>
                    </div>
                    {{-- KOLOM PERIODE --}}
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Periode</label>
                            <input type="text" name="periode" class="form-control" value="{{ old('periode', $tagihan->periode) }}">
                        </div>
                    </div>
                </div>

                {{-- ROW 2: BULAN, TAHUN, JATUH TEMPO --}}
                <div class="row">
                    {{-- KOLOM BULAN --}}
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">Bulan</label>
                            <select name="bulan" class="form-control form-select">
                                {{-- Opsi kosong dengan dash --}}
                                <option value="">-</option>
                                {{-- Loop 12 bulan --}}
                                @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $bulan)
                                    {{-- KONDISI SELECTED --}}
                                    {{-- old('bulan', ...): Ambil old input atau nilai dari database --}}
                                    {{-- == $i+1: Bandingkan dengan index bulan (1-12) --}}
                                    {{-- 'selected': Atribut HTML untuk memilih opsi --}}
                                    <option value="{{ $i+1 }}" {{ old('bulan', $tagihan->bulan) == $i+1 ? 'selected' : '' }}>{{ $bulan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- KOLOM TAHUN --}}
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">Tahun <span class="text-danger">*</span></label>
                            <input type="number" name="tahun" class="form-control" value="{{ old('tahun', $tagihan->tahun) }}" required>
                        </div>
                    </div>
                    {{-- KOLOM TANGGAL JATUH TEMPO --}}
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">Tanggal Jatuh Tempo <span class="text-danger">*</span></label>
                            {{-- FORMAT TANGGAL UNTUK INPUT TYPE="DATE" --}}
                            {{-- $tagihan->tanggal_jatuh_tempo->format('Y-m-d'): Format ISO untuk input date --}}
                            <input type="date" name="tanggal_jatuh_tempo" class="form-control" value="{{ old('tanggal_jatuh_tempo', $tagihan->tanggal_jatuh_tempo->format('Y-m-d')) }}" required>
                        </div>
                    </div>
                </div>

                {{-- ROW 3: NOMINAL, DISKON, DENDA --}}
                <div class="row">
                    {{-- KOLOM NOMINAL --}}
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">Nominal (Rp) <span class="text-danger">*</span></label>
                            {{-- min="0": Validasi tidak boleh negatif --}}
                            <input type="number" name="nominal" class="form-control" value="{{ old('nominal', $tagihan->nominal) }}" min="0" required>
                        </div>
                    </div>
                    {{-- KOLOM DISKON --}}
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">Diskon (Rp)</label>
                            <input type="number" name="diskon" class="form-control" value="{{ old('diskon', $tagihan->diskon) }}" min="0">
                        </div>
                    </div>
                    {{-- KOLOM DENDA --}}
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">Denda (Rp)</label>
                            <input type="number" name="denda" class="form-control" value="{{ old('denda', $tagihan->denda) }}" min="0">
                        </div>
                    </div>
                </div>

                {{-- ROW 4: KETERANGAN --}}
                <div class="form-group">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $tagihan->keterangan) }}</textarea>
                </div>

                {{-- TOMBOL AKSI --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check"></i> Simpan
                    </button>
                    <a href="{{ route('bendahara.tagihan.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
    
{{-- @endsection: Penutup section content --}}
@endsection
