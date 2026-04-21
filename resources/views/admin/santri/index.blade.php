{{-- ===================================================== --}}
{{-- FILE: index.blade.php (Santri) --}}
{{-- DESKRIPSI: View untuk menampilkan daftar data santri --}}
{{--          dengan tabel yang bisa di-sort dan di-search --}}
{{-- LOKASI: resources/views/admin/santri/index.blade.php --}}
{{-- CONTROLLER: Admin/SantriController.php --}}
{{-- ROUTE: GET /admin/santri --}}
{{-- ===================================================== --}}

{{-- @extends('layouts.admin') - Menggunakan layout admin dengan sidebar --}}
@extends('layouts.admin')

{{-- Judul halaman yang akan muncul di tab browser --}}
@section('title', 'Manajemen Santri')

{{-- ===================================================== --}}
{{-- KONTEN UTAMA HALAMAN --}}
{{-- ===================================================== --}}
@section('content')
    {{-- ---------------------------------------------------- --}}
    {{-- HEADER HALAMAN --}}
    {{-- ---------------------------------------------------- --}}
    {{-- page-header: Container untuk judul dan tombol aksi --}}
    {{-- Biasanya menggunakan flexbox: justify-content: space-between --}}
    <div class="page-header">
        <div>
            {{-- Judul halaman --}}
            <h1 class="page-title">Manajemen Santri</h1>
            {{-- Deskripsi singkat --}}
            <p class="page-subtitle">Kelola data santri.</p>
        </div>
        <div>
            {{-- Tombol Tambah Santri --}}
            {{-- route('admin.santri.create') = link ke form tambah --}}
            {{-- class 'btn btn-primary' = tombol dengan warna utama (biru) --}}
            {{-- CONTOH MODIFIKASI WARNA: --}}
            {{-- - style="background: #10b981;" untuk hijau --}}
            {{-- - class="btn btn-success" untuk tombol hijau Bootstrap --}}
            <a href="{{ route('admin.santri.create') }}" class="btn btn-primary">
                {{-- Ikon plus untuk menandakan 'tambah' --}}
                <i class="bi bi-plus"></i> Tambah Santri
            </a>
        </div>
    </div>

    {{-- ---------------------------------------------------- --}}
    {{-- CARD TABEL DATA --}}
    {{-- ---------------------------------------------------- --}}
    {{-- card: Container dengan border, shadow, dan padding --}}
    {{-- CONTOH STYLING CARD: --}}
    {{-- style="border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);" --}}
    <div class="card">
        {{-- card-body: Padding internal card --}}
        <div class="card-body">
            {{-- table: Tabel Bootstrap standar --}}
            {{-- id="dataTable": ID untuk inisialisasi DataTables JavaScript --}}
            {{-- style="width:100%": Memastikan tabel menggunakan lebar penuh --}}
            {{-- CONTOH STYLING TABEL: --}}
            {{-- class="table table-striped table-hover" untuk striped rows dan hover effect --}}
            <table class="table" id="dataTable" style="width:100%">
                {{-- thead: Header tabel --}}
                <thead>
                    <tr>
                        {{-- th: Header cell --}}
                        {{-- CONTOH MODIFIKASI: --}}
                        {{-- style="background: #4f46e5; color: white;" untuk header berwarna --}}
                        <th>NIS</th>
                        <th>Nama Lengkap</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>Status</th>
                        {{-- width="120": Lebar kolom tetap 120px --}}
                        {{-- Berguna untuk kolom aksi agar tidak terlalu lebar --}}
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                {{-- tbody: Body tabel dengan data --}}
                <tbody>
                    {{-- @foreach: Loop Laravel untuk iterasi array $santri --}}
                    {{-- $santri dikirim dari controller SantriController@index --}}
                    {{-- $s: Variable untuk setiap item dalam collection --}}
                    @foreach($santri as $s)
                        <tr>
                            {{-- td: Data cell --}}
                            {{-- Menampilkan NIS dari object santri --}}
                            <td>{{ $s->nis }}</td>
                            <td>{{ $s->nama_lengkap }}</td>
                            
                            {{-- Akses relasi: $s->kelas->nama_kelas --}}
                            {{-- 'kelas' adalah relasi yang didefinisikan di Model Santri --}}
                            {{-- Relasi belongsTo: satu santri punya satu kelas --}}
                            <td>{{ $s->kelas->nama_kelas }}</td>
                            
                            {{-- Operator ?? '-' = Null Coalescing --}}
                            {{-- Jika $s->jurusan null, tampilkan '-' --}}
                            {{-- Contoh: santri tidak memiliki jurusan akan tampil '-' --}}
                            <td>{{ $s->jurusan->nama_jurusan ?? '-' }}</td>
                            
                            <td>
                                {{-- ------------------------------------------------ --}}
                                {{-- BADGE STATUS DENGAN SWITCH --}}
                                {{-- ------------------------------------------------ --}}
                                {{-- @switch: Struktur kondisi mirip switch-case PHP --}}
                                {{-- Menampilkan badge berbeda berdasarkan status --}}
                                @switch($s->status)
                                    @case('aktif')
                                        {{-- badge badge-success: Badge hijau --}}
                                        {{-- CONTOH MODIFIKASI BADGE: --}}
                                        {{-- <span class="badge" style="background: #10b981; color: white;">Aktif</span> --}}
                                        <span class="badge badge-success">Aktif</span>
                                        {{-- @break: Keluar dari switch --}}
                                        @break
                                    @case('nonaktif')
                                        {{-- badge badge-warning: Badge kuning/oranye --}}
                                        <span class="badge badge-warning">Nonaktif</span>
                                        @break
                                    @case('lulus')
                                        {{-- badge badge-info: Badge biru muda --}}
                                        <span class="badge badge-info">Lulus</span>
                                        @break
                                    @case('pindah')
                                        {{-- badge badge-secondary: Badge abu-abu --}}
                                        <span class="badge badge-secondary">Pindah</span>
                                        @break
                                {{-- @endswitch: Penutup switch --}}
                                @endswitch
                            </td>
                            <td>
                                {{-- ------------------------------------------------ --}}
                                {{-- TOMBOL AKSI (VIEW, EDIT, DELETE) --}}
                                {{-- ------------------------------------------------ --}}
                                {{-- btn-group: Mengelompokkan tombol menjadi satu unit --}}
                                {{-- CONTOH: style="display: flex; gap: 4px;" --}}
                                <div class="btn-group">
                                    {{-- Tombol Detail/View --}}
                                    {{-- route('admin.santri.show', $s) = URL ke detail santri --}}
                                    {{-- Parameter $s akan otomatis diambil ID-nya (route model binding) --}}
                                    {{-- class 'btn btn-sm btn-info' = tombol kecil warna biru muda --}}
                                    {{-- title="Detail": Tooltip saat hover --}}
                                    <a href="{{ route('admin.santri.show', $s) }}" class="btn btn-sm btn-info" title="Detail">
                                        {{-- bi-eye: Ikon mata (lihat/detail) --}}
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    
                                    {{-- Tombol Edit --}}
                                    {{-- route('admin.santri.edit', $s) = URL ke form edit --}}
                                    {{-- btn-secondary: Tombol warna abu-abu --}}
                                    <a href="{{ route('admin.santri.edit', $s) }}" class="btn btn-sm btn-secondary" title="Edit">
                                        {{-- bi-pencil: Ikon pensil (edit) --}}
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    
                                    {{-- Form Delete --}}
                                    {{-- Menggunakan form karena method DELETE tidak support di HTML link --}}
                                    {{-- action: URL untuk hapus data --}}
                                    {{-- method="POST": HTML hanya support GET dan POST --}}
                                    {{-- style="display:inline": Agar form sejajar dengan tombol lain --}}
                                    {{-- onsubmit="return confirm(...)": Konfirmasi sebelum hapus --}}
                                    <form action="{{ route('admin.santri.destroy', $s) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin ingin menghapus santri ini?')">
                                        {{-- @csrf: Token keamanan Laravel (wajib untuk POST/PUT/DELETE) --}}
                                        {{-- Melindungi dari CSRF attack --}}
                                        @csrf
                                        {{-- @method('DELETE'): Spoofing method HTTP --}}
                                        {{-- Laravel akan memproses ini sebagai DELETE bukan POST --}}
                                        @method('DELETE')
                                        {{-- Tombol submit dengan ikon trash (sampah) --}}
                                        {{-- btn-danger: Tombol warna merah (untuk aksi berbahaya) --}}
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    {{-- @endforeach: Penutup loop --}}
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
{{-- @endsection: Penutup section content --}}
@endsection

{{-- ===================================================== --}}
{{-- PUSH SCRIPTS - JavaScript Tambahan --}}
{{-- ===================================================== --}}
{{-- @push('scripts'): Menambahkan script ke stack 'scripts' --}}
{{-- Stack ini akan dirender di layout parent (biasanya sebelum </body>) --}}
@push('scripts')
{{-- Script DataTables untuk fitur sort, search, pagination --}}
<script>
    // $(document).ready(): Menunggu DOM selesai dimuat
    $(document).ready(function() {
        // Inisialisasi DataTables pada tabel dengan id='dataTable'
        $('#dataTable').DataTable({
            // order: Mengatur urutan default tabel
            // [1, 'asc'] = Urutkan kolom ke-2 (index 1 = Nama Lengkap) secara ascending (A-Z)
            // CONTOH MODIFIKASI: [0, 'desc'] = Urutkan berdasarkan NIS terbesar
            order: [[1, 'asc']],
            
            // columnDefs: Konfigurasi khusus untuk kolom tertentu
            columnDefs: [
                {
                    // orderable: false = Kolom tidak bisa di-sort/urutkan
                    // targets: -1 = Target kolom terakhir (kolom Aksi)
                    // CONTOH: targets: [0, 5] = Kolom 1 dan 6 tidak bisa di-sort
                    orderable: false, 
                    targets: -1 
                }
            ]
            
            // CONTOH KONFIGURASI LAINNYA:
            // pageLength: 25, // Tampilkan 25 baris per halaman (default 10)
            // language: { url: '/js/indonesia.json' }, // Bahasa Indonesia
            // searching: false, // Matikan fitur search
            // paging: false, // Matikan pagination
        });
    });
</script>
@endpush
