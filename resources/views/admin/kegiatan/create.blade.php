{{--
================================================================================
FILE        : create.blade.php
DESKRIPSI   : Halaman form untuk menambahkan kegiatan baru. Berisi form input
              dengan validasi dan fitur upload gambar.
LOKASI      : resources/views/admin/kegiatan/create.blade.php
CONTROLLER  : KegiatanController@create (GET), KegiatanController@store (POST)
ROUTE       : GET /admin/kegiatan/create, POST /admin/kegiatan
================================================================================
--}}

{{--
    @extends('layouts.admin')
    Memanggil layout utama admin dari resources/views/layouts/admin.blade.php
    Layout ini berisi struktur HTML dasar termasuk navbar dan sidebar
--}}
@extends('layouts.admin')

{{--
    @section('title', 'Tambah Kegiatan')
    Mengisi section 'title' di layout admin
    Title ini akan muncul di tab browser
--}}
@section('title', 'Tambah Kegiatan')

{{--
    @section('content')
    Section utama yang berisi konten halaman form
--}}
@section('content')
    {{-- Page Header dengan judul halaman --}}
    <div class="page-header"><div><h1 class="page-title">Tambah Kegiatan</h1></div></div>

    {{-- Card Container untuk form --}}
    <div class="card">
        <div class="card-body">
            {{--
                Form Tambah Kegiatan
                action: route('admin.kegiatan.store') mengarah ke method store di controller
                method="POST": HTTP method untuk menyimpan data
                enctype="multipart/form-data": wajib untuk upload file/gambar

                Contoh modifikasi styling form:
                - Tambahkan class "was-validated" untuk styling validasi Bootstrap
                - Tambahkan novalidate attribute untuk custom validation
            --}}
            <form action="{{ route('admin.kegiatan.store') }}" method="POST" enctype="multipart/form-data">
                {{--
                    @csrf
                    Laravel CSRF token untuk keamanan form
                    Menghasilkan input hidden dengan token unik
                --}}
                @csrf

                {{--
                    Form Group: Nama Kegiatan
                    form-group: wrapper untuk label dan input
                    form-label: styling label Bootstrap
                    text-danger: warna merah untuk indikator required
                    form-control: styling input Bootstrap
                    required: validasi HTML5
                --}}
                <div class="form-group">
                    <label class="form-label">Nama Kegiatan <span class="text-danger">*</span></label>
                    <input type="text" name="nama_kegiatan" class="form-control" required>
                </div>

                {{--
                    Form Group: Deskripsi
                    textarea: input multi-baris untuk deskripsi panjang
                    rows="3": tinggi textarea (3 baris)
                --}}
                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                </div>

                {{--
                    Row dengan 3 kolom untuk input tanggal dan waktu
                    col-4: masing-masing kolom mengambil 4/12 (33%) lebar
                --}}
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            {{-- type="date": input date picker native browser --}}
                            <label class="form-label">Tanggal Pelaksanaan <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_pelaksanaan" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            {{-- type="time": input time picker native browser --}}
                            <label class="form-label">Waktu Mulai</label>
                            <input type="time" name="waktu_mulai" class="form-control">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">Waktu Selesai</label>
                            <input type="time" name="waktu_selesai" class="form-control">
                        </div>
                    </div>
                </div>

                {{-- Row dengan 2 kolom untuk lokasi dan status --}}
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            {{-- Select dropdown untuk status --}}
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control form-select" required>
                                {{-- Option values disesuaikan dengan enum di database --}}
                                <option value="akan_datang">Akan Datang</option>
                                <option value="berlangsung">Berlangsung</option>
                                <option value="selesai">Selesai</option>
                                <option value="dibatalkan">Dibatalkan</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Form Group: Upload Gambar --}}
                <div class="form-group">
                    <label class="form-label">Gambar</label>
                    {{--
                        type="file": input untuk upload file
                        accept="image/*": filter hanya file gambar yang ditampilkan
                    --}}
                    <input type="file" name="gambar" class="form-control" accept="image/*">
                </div>

                {{--
                    Form Group: Checkbox Publish
                    form-check form-switch: styling Bootstrap untuk toggle switch
                    value="1": nilai yang dikirim jika checkbox dicentang
                --}}
                <div class="form-group">
                    <label class="form-check form-switch">
                        <input type="checkbox" name="is_published" class="form-check-input" value="1">
                        <span>Publish Sekarang</span>
                    </label>
                </div>

                {{--
                    Tombol Aksi Form
                    d-flex gap-2: flexbox dengan gap 0.5rem antar elemen
                --}}
                <div class="d-flex gap-2">
                    {{-- Tombol Submit dengan icon check --}}
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check"></i> Simpan</button>
                    {{-- Tombol Batal kembali ke halaman index --}}
                    <a href="{{ route('admin.kegiatan.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
