{{-- ===================================================== --}}
{{-- FILE: create.blade.php (Santri) --}}
{{-- DESKRIPSI: Form untuk menambah data santri baru --}}
{{--          Berisi input lengkap dengan validasi --}}
{{-- LOKASI: resources/views/admin/santri/create.blade.php --}}
{{-- CONTROLLER: Admin/SantriController@create, @store --}}
{{-- ROUTE: GET /admin/santri/create, POST /admin/santri --}}
{{-- ===================================================== --}}

{{-- @extends: Menggunakan layout admin dengan sidebar --}}
@extends('layouts.admin')

{{-- Title halaman --}}
@section('title', 'Tambah Santri')

{{-- ===================================================== --}}
{{-- KONTEN UTAMA --}}
{{-- ===================================================== --}}
@section('content')
    {{-- Header halaman dengan judul dan deskripsi --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Santri</h1>
            <p class="page-subtitle">Tambah data santri baru.</p>
        </div>
    </div>

    {{-- Card container untuk form --}}
    <div class="card">
        <div class="card-body">
            {{-- ================================================= --}}
            {{-- FORM TAMBAH SANTRI --}}
            {{-- ================================================= --}}
            {{-- action: Route untuk menyimpan data --}}
            {{-- method="POST": HTTP method untuk create --}}
            {{-- enctype="multipart/form-data": WAJIB untuk upload file --}}
            <form action="{{ route('admin.santri.store') }}" method="POST" enctype="multipart/form-data">
                {{-- @csrf: Token keamanan Laravel WAJIB untuk form POST --}}
                @csrf
                
                {{-- ------------------------------------------------ --}}
                {{-- BARIS 1: NIS dan Nama Lengkap --}}
                {{-- ------------------------------------------------ --}}
                {{-- row: Container grid Bootstrap --}}
                <div class="row">
                    {{-- col-6: Setiap input mengambil 50% lebar (6 dari 12 kolom) --}}
                    <div class="col-6">
                        {{-- form-group: Container untuk label dan input --}}
                        <div class="form-group">
                            {{-- Label dengan tanda bintang merah untuk wajib --}}
                            <label class="form-label">NIS <span class="text-danger">*</span></label>
                            {{-- Input teks untuk NIS --}}
                            {{-- @error('nis') is-invalid: Tambah class 'is-invalid' jika ada error validasi --}}
                            {{-- value="{{ old('nis') }}": Pertahankan nilai lama jika validasi gagal --}}
                            <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror" value="{{ old('nis') }}" required>
                            {{-- Tampilkan pesan error jika ada --}}
                            @error('nis')
                                <div class="text-danger" style="font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap') }}" required>
                            @error('nama_lengkap')
                                <div class="text-danger" style="font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- ------------------------------------------------ --}}
                {{-- BARIS 2: Jenis Kelamin dan Tempat Lahir --}}
                {{-- ------------------------------------------------ --}}
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            {{-- Select dropdown untuk pilihan terbatas --}}
                            {{-- form-select: Styling khusus untuk select Bootstrap --}}
                            <select name="jenis_kelamin" class="form-control form-select @error('jenis_kelamin') is-invalid @enderror" required>
                                <option value="">Pilih</option>
                                {{-- Ternary untuk menandai selected --}}
                                {{-- Jika old('jenis_kelamin') == 'L', tambahkan attribute 'selected' --}}
                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir') }}">
                        </div>
                    </div>
                </div>

                {{-- ------------------------------------------------ --}}
                {{-- BARIS 3: Tanggal Lahir dan Tanggal Masuk --}}
                {{-- ------------------------------------------------ --}}
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Tanggal Lahir</label>
                            {{-- type="date": Input tanggal dengan datepicker native --}}
                            <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Tanggal Masuk</label>
                            <input type="date" name="tanggal_masuk" class="form-control" value="{{ old('tanggal_masuk') }}">
                        </div>
                    </div>
                </div>

                {{-- ------------------------------------------------ --}}
                {{-- BARIS 4: Kelas dan Jurusan --}}
                {{-- ------------------------------------------------ --}}
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Kelas <span class="text-danger">*</span></label>
                            <select name="kelas_id" class="form-control form-select @error('kelas_id') is-invalid @enderror" required>
                                <option value="">Pilih Kelas</option>
                                {{-- Loop daftar kelas dari controller --}}
                                @foreach($kelasList as $kelas)
                                    <option value="{{ $kelas->id }}" {{ old('kelas_id') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Jurusan</label>
                            <select name="jurusan_id" class="form-control form-select">
                                <option value="">Pilih Jurusan</option>
                                {{-- Loop daftar jurusan dari controller --}}
                                @foreach($jurusanList as $jurusan)
                                    <option value="{{ $jurusan->id }}" {{ old('jurusan_id') == $jurusan->id ? 'selected' : '' }}>{{ $jurusan->nama_jurusan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- ------------------------------------------------ --}}
                {{-- BARIS 5: Alamat (Full Width) --}}
                {{-- ------------------------------------------------ --}}
                {{-- Tidak menggunakan col-6 karena ingin lebar penuh --}}
                <div class="form-group">
                    <label class="form-label">Alamat</label>
                    {{-- textarea: Input multi-baris untuk teks panjang --}}
                    {{-- rows="3": Tinggi 3 baris --}}
                    {{-- old('alamat'): Pertahankan nilai lama --}}
                    <textarea name="alamat" class="form-control" rows="3">{{ old('alamat') }}</textarea>
                </div>

                {{-- ------------------------------------------------ --}}
                {{-- BARIS 6: Status dan Foto --}}
                {{-- ------------------------------------------------ --}}
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control form-select" required>
                                {{-- old('status', 'aktif'): Default 'aktif' jika tidak ada old value --}}
                                <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                <option value="lulus" {{ old('status') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                                <option value="pindah" {{ old('status') == 'pindah' ? 'selected' : '' }}>Pindah</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Foto</label>
                            {{-- type="file": Input untuk upload file --}}
                            {{-- accept="image/*": Hanya menerima file gambar --}}
                            <input type="file" name="foto" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>

                {{-- ------------------------------------------------ --}}
                {{-- PEMISAH: Hubungkan Wali --}}
                {{-- ------------------------------------------------ --}}
                {{-- hr: Garis horizontal sebagai pemisah section --}}
                <hr>
                {{-- h5: Sub judul section --}}
                {{-- mb-4: Margin bottom 4 unit --}}
                <h5 class="mb-4">Hubungkan Wali (Opsional)</h5>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Wali Santri</label>
                            <select name="wali_id" class="form-control form-select">
                                <option value="">Pilih Wali (jika ada)</option>
                                {{-- Loop daftar wali dari controller --}}
                                @foreach($waliList as $wali)
                                    {{-- Tampilkan nama dan email dalam satu opsi --}}
                                    <option value="{{ $wali->id }}">{{ $wali->name }} ({{ $wali->email }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Hubungan</label>
                            <select name="hubungan" class="form-control form-select">
                                <option value="wali">Wali</option>
                                <option value="ayah">Ayah</option>
                                <option value="ibu">Ibu</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- ------------------------------------------------ --}}
                {{-- TOMBOL AKSI --}}
                {{-- ------------------------------------------------ --}}
                {{-- d-flex: Display flexbox --}}
                {{-- gap-2: Jarak antar elemen 2 unit (0.5rem) --}}
                <div class="d-flex gap-2">
                    {{-- Tombol submit utama --}}
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check"></i> Simpan
                    </button>
                    {{-- Link kembali ke daftar --}}
                    <a href="{{ route('admin.santri.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
