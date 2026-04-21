{{--
================================================================================
FILE        : edit.blade.php
DESKRIPSI   : Halaman form untuk mengedit data tagihan yang sudah ada.
              Menampilkan data existing dan memungkinkan perubahan pada
              nominal, diskon, denda, dan informasi tagihan lainnya.
LOKASI      : resources/views/admin/tagihan/edit.blade.php
CONTROLLER  : TagihanController@edit, TagihanController@update
ROUTE       : GET /admin/tagihan/{tagihan}/edit, PUT /admin/tagihan/{tagihan}
================================================================================
--}}

{{-- 
@extends('layouts.admin')
Menggunakan layout admin sebagai template utama
Semua konten akan dimasukkan ke dalam yield('content') di layout parent
--}}
@extends('layouts.admin')

{{-- Section title untuk judul halaman browser --}}
@section('title', 'Edit Tagihan')

{{-- Section content berisi form edit tagihan --}}
@section('content')
    {{-- Header halaman dengan informasi tagihan yang sedang diedit --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Tagihan</h1>
            {{-- 
            Subtitle menampilkan nama tagihan dan nama santri dari model
            Mengakses relasi: $tagihan->santri->nama_lengkap
            --}}
            <p class="page-subtitle">{{ $tagihan->nama_tagihan }} - {{ $tagihan->santri->nama_lengkap }}</p>
        </div>
    </div>

    {{-- 
    ============================================================
    BAGIAN: Form Edit Tagihan
    Form dengan method POST + PUT (method spoofing) untuk update
    ============================================================
    --}}
    <div class="card">
        <div class="card-body">
            {{-- 
            Form Edit
            action: route('admin.tagihan.update', $tagihan) -> URL dengan parameter tagihan
            method: POST (akan di-override dengan @method('PUT'))
            $tagihan otomatis di-bind ke route model binding
            --}}
            <form action="{{ route('admin.tagihan.update', $tagihan) }}" method="POST">
                {{-- Token CSRF untuk keamanan --}}
                @csrf
                {{-- 
                @method('PUT')
                Laravel method spoofing: Mengubah method POST menjadi PUT
                Karena HTML form hanya support GET dan POST
                REST convention: PUT untuk update resource
                --}}
                @method('PUT')

                {{-- 
                ========================================================
                BARIS 1: Nama Tagihan & Periode
                ========================================================
                --}}
                <div class="row">
                    {{-- Kolom Nama Tagihan --}}
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Nama Tagihan <span class="text-danger">*</span></label>
                            {{-- 
                            Input Nama Tagihan dengan old() helper
                            old('nama_tagihan', $tagihan->nama_tagihan):
                            - Jika ada error validasi, gunakan nilai input sebelumnya
                            - Jika tidak, gunakan nilai dari database ($tagihan->nama_tagihan)
                            Ini mencegah data hilang saat validasi gagal
                            --}}
                            <input type="text" name="nama_tagihan" class="form-control" value="{{ old('nama_tagihan', $tagihan->nama_tagihan) }}" required>
                        </div>
                    </div>
                    {{-- Kolom Periode --}}
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Periode</label>
                            <input type="text" name="periode" class="form-control" value="{{ old('periode', $tagihan->periode) }}">
                        </div>
                    </div>
                </div>

                {{-- 
                ========================================================
                BARIS 2: Bulan, Tahun & Tanggal Jatuh Tempo
                ========================================================
                --}}
                <div class="row">
                    {{-- Kolom Bulan --}}
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">Bulan</label>
                            <select name="bulan" class="form-control form-select">
                                {{-- Option kosong dengan value "-" --}}
                                <option value="">-</option>
                                {{-- 
                                Looping array bulan dengan selected condition
                                {{ old('bulan', $tagihan->bulan) == $i+1 ? 'selected' : '' }}
                                Menandai option sebagai selected jika cocok dengan data existing
                                --}}
                                @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $bulan)
                                    <option value="{{ $i+1 }}" {{ old('bulan', $tagihan->bulan) == $i+1 ? 'selected' : '' }}>{{ $bulan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- Kolom Tahun --}}
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">Tahun <span class="text-danger">*</span></label>
                            <input type="number" name="tahun" class="form-control" value="{{ old('tahun', $tagihan->tahun) }}" required>
                        </div>
                    </div>
                    {{-- Kolom Tanggal Jatuh Tempo --}}
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">Tanggal Jatuh Tempo <span class="text-danger">*</span></label>
                            {{-- 
                            Format tanggal untuk input type="date": Y-m-d
                            $tagihan->tanggal_jatuh_tempo adalah Carbon instance
                            format('Y-m-d'): Mengubah ke format ISO untuk input date
                            --}}
                            <input type="date" name="tanggal_jatuh_tempo" class="form-control" value="{{ old('tanggal_jatuh_tempo', $tagihan->tanggal_jatuh_tempo->format('Y-m-d')) }}" required>
                        </div>
                    </div>
                </div>

                {{-- 
                ========================================================
                BARIS 3: Nominal, Diskon & Denda
                Perhitungan: total_bayar = nominal - diskon + denda
                ========================================================
                --}}
                <div class="row">
                    {{-- Kolom Nominal --}}
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">Nominal (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="nominal" class="form-control" value="{{ old('nominal', $tagihan->nominal) }}" min="0" required>
                        </div>
                    </div>
                    {{-- Kolom Diskon --}}
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">Diskon (Rp)</label>
                            {{-- 
                            Diskon opsional, default 0
                            min="0": Diskon tidak boleh negatif
                            --}}
                            <input type="number" name="diskon" class="form-control" value="{{ old('diskon', $tagihan->diskon) }}" min="0">
                        </div>
                    </div>
                    {{-- Kolom Denda --}}
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">Denda (Rp)</label>
                            {{-- 
                            Denda opsional, default 0
                            Bisa diupdate jika terjadi keterlambatan pembayaran
                            --}}
                            <input type="number" name="denda" class="form-control" value="{{ old('denda', $tagihan->denda) }}" min="0">
                        </div>
                    </div>
                </div>

                {{-- 
                ========================================================
                BARIS 4: Keterangan
                ========================================================
                --}}
                <div class="form-group">
                    <label class="form-label">Keterangan</label>
                    {{-- Textarea untuk catatan tambahan --}}
                    <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $tagihan->keterangan) }}</textarea>
                </div>

                {{-- 
                ========================================================
                BARIS 5: Tombol Aksi
                ========================================================
                --}}
                <div class="d-flex gap-2">
                    {{-- 
                    Tombol Simpan
                    type="submit": Men-trigger form submission
                    Icon bi bi-check: Checkmark icon dari Bootstrap Icons
                    Contoh modifikasi styling:
                    - class="btn btn-primary btn-lg" untuk tombol besar
                    - class="btn btn-success" untuk warna hijau
                    --}}
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check"></i> Simpan</button>
                    {{-- Tombol Batal: Redirect ke halaman index tanpa menyimpan --}}
                    <a href="{{ route('admin.tagihan.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
{{-- Penutup section content --}}
@endsection

{{-- 
CATATAN TAMBAHAN UNTUK DEVELOPER:

1. Validasi Controller (contoh):
   $validated = $request->validate([
       'nama_tagihan' => 'required|string|max:255',
       'periode' => 'nullable|string|max:100',
       'bulan' => 'nullable|integer|between:1,12',
       'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 1),
       'tanggal_jatuh_tempo' => 'required|date',
       'nominal' => 'required|numeric|min:0',
       'diskon' => 'nullable|numeric|min:0',
       'denda' => 'nullable|numeric|min:0',
       'keterangan' => 'nullable|string',
   ]);

2. Update Logic (contoh di controller):
   $tagihan->update($validated);
   // Recalculate total
   $tagihan->total_bayar = $tagihan->nominal - $tagihan->diskon + $tagihan->denda;
   $tagihan->save();

3. Styling Alternatif:
   - Tambahkan class "is-invalid" pada input jika ada error:
     class="form-control {{ $errors->has('field') ? 'is-invalid' : '' }}"
   - Tampilkan pesan error per field:
     @error('field')<div class="invalid-feedback">{{ $message }}</div>@enderror
--}}
