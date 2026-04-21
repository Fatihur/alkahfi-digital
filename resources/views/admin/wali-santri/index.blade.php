{{--
    ===============================================================================
    FILE        : index.blade.php
    DESKRIPSI   : Halaman daftar wali santri dengan fitur manajemen lengkap.
                  Menampilkan data wali santri beserta santri yang terhubung,
                  status akun, dan tombol aksi (detail, edit, reset password, hapus).
                  Dilengkapi alert untuk menampilkan akun yang baru dibuat.
    LOKASI      : resources/views/admin/wali-santri/index.blade.php
    CONTROLLER  : WaliSantriController@index
    ROUTE       : GET /admin/wali-santri (route name: admin.wali-santri.index)
    ===============================================================================
--}}

{{-- 
    @extends('layouts.admin')
    Menggunakan layout admin sebagai template utama
--}}
@extends('layouts.admin')

{{-- 
    @section('title', 'Kelola Wali Santri')
    Judul halaman untuk tab browser dan header
    
    CONTOH MODIFIKASI:
    - Dengan badge count: @section('title', 'Kelola Wali Santri (' . $waliSantri->count() . ')')
--}}
@section('title', 'Kelola Wali Santri')

{{-- 
    @section('content')
    Section utama halaman
--}}
@section('content')
    {{-- 
        Page Header dengan tombol aksi
        d-flex gap-2: Flexbox dengan gap antar tombol
        
        CONTOH MODIFIKASI:
        - Tambah dropdown: 
          <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle">Aksi Massal</button>
            <div class="dropdown-menu">...</div>
          </div>
    --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Kelola Wali Santri</h1>
            <p class="page-subtitle">Kelola data wali santri dan akun login mereka.</p>
        </div>
        <div class="d-flex gap-2">
            {{-- 
                Tombol Generate Akun (opsional, tergantung fitur)
                CONTOH MODIFIKASI:
                - Warna ungu: class="btn btn-purple"
                - Outline style: class="btn btn-outline-success"
            --}}
            
            {{-- 
                Tombol Tambah Wali Santri
                Mengarah ke halaman create wali santri
            --}}
            <a href="{{ route('admin.wali-santri.create') }}" class="btn btn-primary">
                <i class="bi bi-plus"></i> Tambah Wali Santri
            </a>
        </div>
    </div>

    {{-- 
        Alert untuk Menampilkan Akun yang Baru Dibuat
        Muncul hanya jika ada session 'generated_accounts' (setelah generate otomatis)
        
        @if(session('generated_accounts'))
        Directive Blade untuk conditional rendering berdasarkan session
        Session di-set di controller setelah generate akun berhasil
        
        CONTOH MODIFIKASI:
        - Tambah tombol copy: <button onclick="copyToClipboard()" class="btn btn-sm btn-outline-primary">Copy</button>
        - Auto hide: style="animation: fadeOut 10s forwards;"
    --}}
    @if(session('generated_accounts'))
        {{-- 
            Alert Success dengan informasi akun
            CONTOH MODIFIKASI WARNA ALERT:
            - Info biru: class="alert alert-info"
            - Warning kuning: class="alert alert-warning"
            - Dengan border: class="alert alert-success border-success border-2"
        --}}
        <div class="alert alert-success">
            {{-- 
                Heading alert dengan icon
                CONTOH MODIFIKASI:
                - Warna teks: style="color: #065f46;"
                - Tambah animation: class="animate__animated animate__bounceIn"
            --}}
            <h5><i class="bi bi-check-circle"></i> Akun Berhasil Dibuat</h5>
            <p>Simpan informasi login berikut (Password menggunakan NIS santri):</p>
            
            {{-- 
                Tabel Responsive untuk Data Akun
                table-responsive: Membuat tabel scrollable di layar kecil
                table-sm: Ukuran tabel lebih kecil (compact)
                table-bordered: Tabel dengan border
                bg-white: Background putih
                
                CONTOH MODIFIKASI:
                - Striped: class="table table-sm table-bordered table-striped"
                - Hover: class="table table-sm table-bordered table-hover"
            --}}
            <div class="table-responsive">
                <table class="table table-sm table-bordered bg-white">
                    <thead>
                        <tr>
                            <th>Santri</th>
                            <th>NIS</th>
                            <th>Email</th>
                            <th>Password</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- 
                            @foreach(session('generated_accounts') as $account)
                            Looping data akun dari session
                            $account adalah array dengan key: santri, nis, email, password
                        --}}
                        @foreach(session('generated_accounts') as $account)
                            <tr>
                                <td>{{ $account['santri'] }}</td>
                                {{-- 
                                    <code>: Tag HTML untuk menampilkan teks monospace
                                    Biasanya digunakan untuk kode, password, atau data teknis
                                    
                                    CONTOH MODIFIKASI:
                                    - Dengan background: <code class="bg-light px-2 py-1 rounded">{{ $account['nis'] }}</code>
                                    - Font size: <code style="font-size: 1.1rem;">
                                --}}
                                <td><code>{{ $account['nis'] ?? $account['password'] }}</code></td>
                                <td><code>{{ $account['email'] }}</code></td>
                                <td><code>{{ $account['password'] }}</code></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- Card Tabel Data Wali Santri --}}
    <div class="card">
        <div class="card-body">
            {{-- Tabel dengan DataTables --}}
            <table class="table" id="dataTable" style="width:100%">
                <thead>
                    <tr>
                        <th>Nama Wali</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        <th>Santri</th>
                        <th>Status</th>
                        {{-- Lebar kolom aksi lebih besar karena ada 4 tombol --}}
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- 
                        @foreach($waliSantri as $wali)
                        Looping collection wali santri dari controller
                        $wali adalah model User dengan relasi waliSantri
                    --}}
                    @foreach($waliSantri as $wali)
                        <tr>
                            <td>{{ $wali->name }}</td>
                            <td>{{ $wali->email }}</td>
                            <td>{{ $wali->no_hp ?? '-' }}</td>
                            
                            {{-- 
                                Kolom Santri (Relasi)
                                Menampilkan daftar santri yang terhubung dengan wali ini
                                Menggunakan relasi $wali->waliSantri (hasMany)
                                
                                @forelse: Looping dengan empty state
                                - Jika ada data, tampilkan badge untuk setiap santri
                                - Jika kosong, tampilkan teks "-"
                                
                                CONTOH MODIFIKASI:
                                - Batasi jumlah: @foreach($wali->waliSantri->take(3) as $ws)
                                - Tampilkan semua dalam list: <ul>@foreach(...) <li>...</li> @endforeach</ul>
                            --}}
                            <td>
                                @forelse($wali->waliSantri as $ws)
                                    {{-- 
                                        badge-info: Badge berwarna biru muda (info)
                                        $ws->santri->nama_lengkap: Mengakses relasi nested
                                        
                                        CONTOH MODIFIKASI WARNA BADGE:
                                        - Hijau: badge badge-success
                                        - Merah: badge badge-danger
                                        - Kuning: badge badge-warning
                                        - Ungu: badge badge-purple (custom)
                                        
                                        CONTOH MODIFIKASI TAMPILAN:
                                        - Dengan icon: <span class="badge badge-info"><i class="bi bi-person"></i> {{ $ws->santri->nama_lengkap }}</span>
                                        - Tooltip: <span class="badge badge-info" title="NIS: {{ $ws->santri->nis }}">{{ $ws->santri->nama_lengkap }}</span>
                                    --}}
                                    <span class="badge badge-info">{{ $ws->santri->nama_lengkap ?? 'N/A' }}</span>
                                @empty
                                    {{-- Tampilkan jika wali belum memiliki santri --}}
                                    <span class="text-muted">-</span>
                                @endforelse
                            </td>
                            
                            {{-- Status Akun dengan badge --}}
                            <td>
                                @if($wali->is_active)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Nonaktif</span>
                                @endif
                            </td>
                            
                            {{-- 
                                Kolom Aksi dengan 4 Tombol
                                btn-group mengelompokkan tombol agar rapat
                            --}}
                            <td>
                                <div class="btn-group">
                                    {{-- 
                                        Tombol Detail
                                        route('admin.wali-santri.show', $wali): Halaman detail wali
                                        btn-info: Tombol berwarna biru (info)
                                        
                                        CONTOH MODIFIKASI:
                                        - Dropdown: 
                                          <div class="btn-group">
                                            <button class="btn btn-sm btn-secondary dropdown-toggle">Aksi</button>
                                            <ul class="dropdown-menu">...</ul>
                                          </div>
                                    --}}
                                    <a href="{{ route('admin.wali-santri.show', $wali) }}" class="btn btn-sm btn-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('admin.wali-santri.edit', $wali) }}" class="btn btn-sm btn-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    
                                    {{-- 
                                        Form Reset Password
                                        Menggunakan POST dengan route terpisah
                                        onsubmit="return confirm(...)": Konfirmasi sebelum reset
                                        
                                        CONTOH MODIFIKASI:
                                        - Modal confirmation: onclick="showResetModal({{ $wali->id }})"
                                        - Ajax: class="btn-reset" data-id="{{ $wali->id }}"
                                    --}}
                                    <form action="{{ route('admin.wali-santri.reset-password', $wali) }}" method="POST" style="display:inline" onsubmit="return confirm('Reset password wali ini?')">
                                        @csrf
                                        {{-- 
                                            btn-warning: Tombol kuning/oranye
                                            title="Reset Password": Tooltip saat hover
                                            
                                            CONTOH MODIFIKASI:
                                            - Warna lain: class="btn btn-sm btn-dark"
                                            - Loading state: <span class="spinner-border spinner-border-sm"></span>
                                        --}}
                                        <button type="submit" class="btn btn-sm btn-warning" title="Reset Password">
                                            <i class="bi bi-key"></i>
                                        </button>
                                    </form>
                                    
                                    {{-- Form Hapus Wali Santri --}}
                                    <form action="{{ route('admin.wali-santri.destroy', $wali) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin ingin menghapus wali santri ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

{{-- 
    @push('scripts')
    Script untuk inisialisasi DataTables
--}}
@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            order: [[0, 'asc']],
            columnDefs: [
                { orderable: false, targets: -1 }
            ]
            {{-- 
                CONTOH TAMBAHAN KONFIGURASI:
                - Language Indonesia: 
                  language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json' }
                - Export buttons:
                  dom: 'Bfrtip',
                  buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                - Column visibility:
                  buttons: ['colvis']
            --}}
        });
    });
</script>
@endpush
