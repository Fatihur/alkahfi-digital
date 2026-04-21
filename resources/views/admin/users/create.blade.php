{{--
    ===============================================================================
    FILE        : create.blade.php
    DESKRIPSI   : Halaman form untuk membuat pengguna baru. Berisi input field
                  untuk nama, email, nomor HP, role, dan password. Dilengkapi
                  dengan validasi error dan old input retention.
    LOKASI      : resources/views/admin/users/create.blade.php
    CONTROLLER  : UserController@create (menampilkan form), UserController@store (proses simpan)
    ROUTE       : GET /admin/users/create (admin.users.create)
                  POST /admin/users (admin.users.store)
    ===============================================================================
--}}

{{-- 
    @extends('layouts.admin')
    Menggunakan layout admin sebagai template utama
    Layout ini biasanya berisi: header, sidebar, footer, dan struktur HTML dasar
--}}
@extends('layouts.admin')

{{-- 
    @section('title', 'Tambah Pengguna')
    Mengisi section 'title' di layout dengan judul halaman ini
    Title ini akan muncul di: tab browser, breadcrumb, dan meta tag
--}}
@section('title', 'Tambah Pengguna')

{{-- 
    @section('content')
    Section utama yang berisi seluruh konten halaman form
    Konten ini akan di-render di dalam yield('content') pada layout admin
--}}
@section('content')
    {{-- 
        Page Header
        Berisi judul dan subtitle halaman
        CONTOH MODIFIKASI:
        - Tambahkan breadcrumb di bawah subtitle
        - Tambahkan icon di samping judul
    --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Pengguna</h1>
            <p class="page-subtitle">Buat akun pengguna baru.</p>
        </div>
    </div>

    {{-- 
        Card Container Form
        Mengelompokkan form dalam card dengan styling yang konsisten
        
        CONTOH MODIFIKASI STYLING CARD:
        - Border berwarna: style="border-top: 4px solid #2563eb;"
        - Shadow lebih besar: class="card shadow-lg"
        - Background berbeda: style="background: linear-gradient(to bottom, #ffffff, #f9fafb);"
    --}}
    <div class="card">
        <div class="card-body">
            {{-- 
                Form Tambah Pengguna
                action="{{ route('admin.users.store') }}" : URL tujuan saat form disubmit
                method="POST" : HTTP method untuk mengirim data (Create operation)
                
                CONTOH MODIFIKASI:
                - Tambah enctype untuk upload file: enctype="multipart/form-data"
                - Tambah class: class="needs-validation" untuk Bootstrap validation
                - Tambah novalidate: untuk menonaktifkan browser validation
            --}}
            <form action="{{ route('admin.users.store') }}" method="POST">
                {{-- 
                    @csrf
                    Cross-Site Request Forgery token - WAJIB untuk form POST
                    Melindungi dari serangan CSRF dengan menambahkan token unik
                    
                    CONTOH OUTPUT HTML:
                    <input type="hidden" name="_token" value="random_token_string">
                --}}
                @csrf
                
                {{-- 
                    Row 1: Nama dan Email
                    Menggunakan grid system Bootstrap: 2 kolom (col-6 + col-6 = 12)
                    
                    CONTOH MODIFIKASI LAYOUT:
                    - 3 kolom: col-4 + col-4 + col-4
                    - Full width: col-12
                    - Responsive: col-md-6 (stack di mobile, side-by-side di desktop)
                --}}
                <div class="row">
                    {{-- Kolom Nama Lengkap --}}
                    <div class="col-6">
                        {{-- 
                            form-group: Wrapper untuk label dan input
                            Memberikan spacing antar field form
                            CONTOH MODIFIKASI MARGIN: class="form-group mb-4"
                        --}}
                        <div class="form-group">
                            {{-- 
                                Label Input
                                class="form-label": Styling label form yang konsisten
                                <span class="text-danger">*</span>: Indicator field wajib diisi
                                
                                CONTOH MODIFIKASI LABEL:
                                - Tambah icon: <i class="bi bi-person"></i> Nama Lengkap
                                - Ubah warna asterisk: <span style="color: #dc2626;">*</span>
                            --}}
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            
                            {{-- 
                                Input Field Nama
                                type="text": Input teks standar
                                name="name": Nama field yang akan dikirim ke server
                                class="form-control": Styling input Bootstrap
                                
                                @error('name') is-invalid @enderror:
                                - Directive Blade untuk menambahkan class 'is-invalid' jika ada error validasi
                                - Menampilkan border merah dan icon error pada field
                                
                                value="{{ old('name') }}":
                                - old('name') mengembalikan nilai input sebelumnya setelah validasi gagal
                                - Mencegah user mengetik ulang data
                                
                                required: Validasi HTML5, mencegah submit jika kosong
                                
                                CONTOH MODIFIKASI INPUT:
                                - Placeholder: placeholder="Masukkan nama lengkap..."
                                - Autofocus: autofocus (kursor langsung di field ini saat load)
                                - Pattern: pattern="[A-Za-z\s]+" (hanya huruf dan spasi)
                                - Maxlength: maxlength="100"
                            --}}
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            
                            {{-- 
                                @error('name')
                                Directive Blade untuk menampilkan pesan error validasi
                                Hanya muncul jika field 'name' memiliki error
                                
                                CONTOH MODIFIKASI TAMPILAN ERROR:
                                - Dengan icon: <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                - Alert style: <div class="alert alert-danger py-1">{{ $message }}</div>
                            --}}
                            @error('name')
                                {{-- 
                                    Pesan error dengan styling inline
                                    font-size: 0.875rem (14px) - ukuran teks kecil
                                    margin-top: 4px - jarak dari input
                                    
                                    CONTOH MODIFIKASI:
                                    - Gunakan class: class="invalid-feedback" (Bootstrap)
                                    - Tambah animasi: style="animation: shake 0.5s;"
                                --}}
                                <div class="text-danger" style="font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    {{-- Kolom Email --}}
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            {{-- 
                                type="email": Input dengan validasi format email bawaan browser
                                Browser akan menampilkan warning jika format tidak valid
                                
                                CONTOH MODIFIKASI:
                                - Autocomplete: autocomplete="email"
                                - Multiple: multiple (untuk input beberapa email)
                            --}}
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="text-danger" style="font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Row 2: No. HP dan Role --}}
                <div class="row">
                    {{-- Kolom No. HP (Opsional) --}}
                    <div class="col-6">
                        <div class="form-group">
                            {{-- Tidak ada tanda * karena field opsional --}}
                            <label class="form-label">No. HP</label>
                            {{-- 
                                Field opsional tanpa attribute 'required'
                                type="text" digunakan agar bisa menerima karakter seperti +, -, spasi
                                
                                CONTOH MODIFIKASI:
                                - type="tel": Input optimized untuk telepon di mobile
                                - Pattern: pattern="[0-9]+" (hanya angka)
                                - Placeholder: placeholder="081234567890"
                            --}}
                            <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp') }}">
                            @error('no_hp')
                                <div class="text-danger" style="font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    {{-- Kolom Role (Dropdown Select) --}}
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Role <span class="text-danger">*</span></label>
                            {{-- 
                                Select Dropdown untuk Role
                                name="role": Nama field untuk data role
                                class="form-control form-select": Styling Bootstrap untuk select
                                required: Harus memilih salah satu opsi
                                
                                CONTOH MODIFIKASI SELECT:
                                - Multiple select: multiple name="roles[]"
                                - Searchable: class="form-select select2" (dengan plugin Select2)
                                - Disabled: disabled (nonaktifkan field)
                            --}}
                            <select name="role" class="form-control form-select @error('role') is-invalid @enderror" required>
                                {{-- Option default/kosong --}}
                                <option value="">Pilih Role</option>
                                {{-- 
                                    Option dengan kondisi selected
                                    old('role') == 'admin' ? 'selected' : ''
                                    - Jika ada old input dengan nilai 'admin', maka option ini akan terpilih
                                    - Mencegah reset dropdown saat validasi gagal
                                    
                                    CONTOH MODIFIKASI:
                                    - Data dari database: @foreach($roles as $role) <option value="{{ $role->id }}">{{ $role->name }}</option> @endforeach
                                --}}
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="bendahara" {{ old('role') == 'bendahara' ? 'selected' : '' }}>Bendahara</option>
                                <option value="wali_santri" {{ old('role') == 'wali_santri' ? 'selected' : '' }}>Wali Santri</option>
                            </select>
                            @error('role')
                                <div class="text-danger" style="font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Row 3: Password dan Konfirmasi Password --}}
                <div class="row">
                    {{-- Kolom Password --}}
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            {{-- 
                                type="password": Input yang menyembunyikan karakter (****)
                                Tidak menggunakan old('password') karena alasan keamanan
                                Password tidak perlu di-retain setelah validasi gagal
                                
                                CONTOH MODIFIKASI PASSWORD:
                                - Minlength: minlength="8" (minimal 8 karakter)
                                - Pattern: pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" (1 angka, 1 huruf besar, 1 kecil)
                                - Toggle visibility: <button onclick="togglePassword()"><i class="bi bi-eye"></i></button>
                            --}}
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="text-danger" style="font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    {{-- Kolom Konfirmasi Password --}}
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                            {{-- 
                                name="password_confirmation": Nama khusus untuk Laravel
                                Laravel akan otomatis membandingkan password dan password_confirmation
                                Jika tidak sama, validasi 'confirmed' akan gagal
                                
                                CONTOH MODIFIKASI:
                                - Tambah teks bantuan: <small class="text-muted">Ulangi password di atas</small>
                            --}}
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>
                </div>

                {{-- 
                    Tombol Aksi Form
                    d-flex: Display flexbox
                    gap-2: Jarak antar tombol (0.5rem)
                    
                    CONTOH MODIFIKASI TOMBOL:
                    - Posisi kanan: class="d-flex gap-2 justify-content-end"
                    - Posisi tengah: class="d-flex gap-2 justify-content-center"
                    - Full width: class="d-grid gap-2" (tombol memenuhi lebar)
                --}}
                <div class="d-flex gap-2">
                    {{-- 
                        Tombol Submit Simpan
                        type="submit": Akan mengirim form ke URL yang didefinisikan di attribute action
                        class="btn btn-primary": Tombol berwarna biru (primary)
                        
                        CONTOH MODIFIKASI TOMBOL:
                        - Warna hijau: class="btn btn-success"
                        - Dengan loading: <button type="submit" class="btn btn-primary" id="submitBtn"><span class="spinner-border spinner-border-sm d-none"></span> Simpan</button>
                        - Ukuran besar: class="btn btn-primary btn-lg"
                    --}}
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check"></i> Simpan
                    </button>
                    
                    {{-- 
                        Tombol Batal
                        Link yang mengarah kembali ke halaman index
                        class="btn btn-secondary": Tombol abu-abu (warna netral)
                        
                        CONTOH MODIFIKASI:
                        - Outline style: class="btn btn-outline-secondary"
                        - Dengan icon kembali: <i class="bi bi-arrow-left"></i> Batal
                    --}}
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
