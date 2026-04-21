{{--
    ===============================================================================
    FILE        : edit.blade.php
    DESKRIPSI   : Halaman form untuk mengedit data pengguna yang sudah ada.
                  Menampilkan data pengguna saat ini dan memungkinkan admin
                  untuk mengubah informasi serta status akun. Password bersifat
                  opsional (hanya diubah jika diisi).
    LOKASI      : resources/views/admin/users/edit.blade.php
    CONTROLLER  : UserController@edit (tampilkan form), UserController@update (proses update)
    ROUTE       : GET /admin/users/{user}/edit (admin.users.edit)
                  PUT /admin/users/{user} (admin.users.update)
    ===============================================================================
--}}

{{-- 
    @extends('layouts.admin')
    Menggunakan layout admin sebagai template dasar
    Semua konten akan dimasukkan ke dalam section yang sesuai di layout parent
--}}
@extends('layouts.admin')

{{-- 
    @section('title', 'Edit Pengguna')
    Judul halaman yang akan ditampilkan di tab browser dan breadcrumb
    
    CONTOH MODIFIKASI:
    - Dengan nama user: @section('title', 'Edit - ' . $user->name)
    - Dengan icon: @section('title', '<i class="bi bi-pencil"></i> Edit Pengguna')
--}}
@section('title', 'Edit Pengguna')

{{-- 
    @section('content')
    Section utama yang berisi seluruh konten halaman edit
--}}
@section('content')
    {{-- 
        Page Header dengan informasi pengguna yang sedang diedit
        $user->name menampilkan nama pengguna dari model yang dikirim controller
        
        CONTOH MODIFIKASI:
        - Tambahkan avatar: <img src="{{ $user->avatar }}" class="rounded-circle" width="40">
        - Tambahkan badge role di subtitle
    --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Pengguna</h1>
            {{-- Menampilkan nama pengguna yang sedang diedit --}}
            <p class="page-subtitle">Ubah data pengguna: {{ $user->name }}</p>
        </div>
    </div>

    {{-- Card Container untuk Form Edit --}}
    <div class="card">
        <div class="card-body">
            {{-- 
                Form Update Pengguna
                action menggunakan route dengan parameter $user (route model binding)
                route('admin.users.update', $user) menghasilkan: /admin/users/123
                method="POST" dengan @method('PUT') untuk HTTP PUT request
                
                CONTOH MODIFIKASI:
                - Tambah preview: <div class="text-center mb-3"><img src="{{ $user->avatar }}" class="img-thumbnail"></div>
            --}}
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                {{-- 
                    @csrf
                    Token CSRF untuk keamanan form
                --}}
                @csrf
                {{-- 
                    @method('PUT')
                    HTTP method spoofing untuk mengirim PUT request
                    Laravel RESTful convention menggunakan PUT untuk update resource
                    
                    CONTOH MODIFIKASI (PATCH):
                    Jika controller menggunakan update partial: @method('PATCH')
                --}}
                @method('PUT')
                
                {{-- Row 1: Nama dan Email --}}
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            {{-- 
                                value="{{ old('name', $user->name) }}"
                                Menggunakan default value dari model jika tidak ada old input
                                Prioritas: old input > nilai dari database
                                
                                CONTOH MODIFIKASI:
                                - Tambah readonly: readonly (jika nama tidak boleh diubah)
                                - Tambah disabled: disabled (field nonaktif tapi tampil)
                            --}}
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="text-danger" style="font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            {{-- Nilai default diambil dari $user->email --}}
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="text-danger" style="font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Row 2: No. HP dan Role --}}
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">No. HP</label>
                            <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp', $user->no_hp) }}">
                            @error('no_hp')
                                <div class="text-danger" style="font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Role <span class="text-danger">*</span></label>
                            <select name="role" class="form-control form-select @error('role') is-invalid @enderror" required>
                                {{-- 
                                    Option tanpa value kosong karena role wajib dipilih
                                    Dan user sudah memiliki role sebelumnya
                                    
                                    CONTOH MODIFIKASI (Conditional disabled):
                                    @if($user->id === auth()->id()) disabled @endif
                                    (Admin tidak bisa mengubah role dirinya sendiri)
                                --}}
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="bendahara" {{ old('role', $user->role) == 'bendahara' ? 'selected' : '' }}>Bendahara</option>
                                <option value="wali_santri" {{ old('role', $user->role) == 'wali_santri' ? 'selected' : '' }}>Wali Santri</option>
                            </select>
                            @error('role')
                                <div class="text-danger" style="font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Row 3: Password Baru (Opsional) --}}
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Password Baru</label>
                            {{-- 
                                placeholder="Kosongkan jika tidak diubah"
                                Memberi tahu user bahwa password tidak wajib diisi saat edit
                                Jika dikosongkan, password lama tetap digunakan
                                
                                CONTOH MODIFIKASI:
                                - Tambah info strength: <small class="text-muted">Minimal 8 karakter</small>
                                - Tambah toggle visibility: <span class="input-group-text"><i class="bi bi-eye"></i></span>
                            --}}
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Kosongkan jika tidak diubah">
                            @error('password')
                                <div class="text-danger" style="font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>
                </div>

                {{-- 
                    Form Group untuk Status Akun (Switch/Toggle)
                    form-check form-switch: Styling Bootstrap untuk toggle switch
                    
                    CONTOH MODIFIKASI STYLING SWITCH:
                    - Warna custom: style="accent-color: #2563eb;"
                    - Ukuran besar: class="form-check form-switch form-switch-lg"
                    - Inline dengan label lain: class="d-inline-block"
                --}}
                <div class="form-group">
                    <label class="form-check form-switch">
                        {{-- 
                            Checkbox untuk status aktif
                            value="1": Nilai yang dikirim saat checkbox dicentang
                            {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                            - Jika ada old input, gunakan nilai old
                            - Jika tidak, gunakan nilai dari database ($user->is_active)
                            - Ternary operator untuk menambahkan attribute 'checked'
                            
                            CONTOH MODIFIKASI:
                            - Radio button: <input type="radio" name="is_active" value="1" ...> Aktif <input type="radio" name="is_active" value="0" ...> Nonaktif
                        --}}
                        <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                        <span>Akun Aktif</span>
                        {{-- 
                            CONTOH MODIFIKASI TAMBAHAN:
                            - Deskripsi: <small class="text-muted d-block">Nonaktifkan untuk menonaktifkan akses login user</small>
                        --}}
                    </label>
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex gap-2">
                    {{-- 
                        Tombol Simpan Perubahan
                        CONTOH MODIFIKASI:
                        - Dengan icon save: <i class="bi bi-save"></i>
                        - Loading state: onclick="this.disabled=true; this.form.submit();"
                    --}}
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check"></i> Simpan Perubahan
                    </button>
                    {{-- 
                        Tombol Batal - Kembali ke halaman index
                        CONTOH MODIFIKASI:
                        - Batal dengan konfirmasi: onclick="return confirm('Batalkan perubahan?')"
                    --}}
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
