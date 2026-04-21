{{-- ===================================================== --}}
{{-- FILE: admin.blade.php --}}
{{-- DESKRIPSI: Layout khusus untuk halaman Admin Panel --}}
{{--          Berisi sidebar menu navigasi admin --}}
{{-- LOKASI: resources/views/layouts/admin.blade.php --}}
{{-- PARENT: Extends dari layouts/app.blade.php --}}
{{-- ===================================================== --}}

{{-- @extends('layouts.app') - Mewarisi layout utama dari app.blade.php --}}
{{-- Artinya: Semua konten dari app.blade.php akan dimasukkan, --}}
{{-- dan section 'sidebar-menu' di bawah akan menggantikan @yield('sidebar-menu') di parent --}}
@extends('layouts.app')

{{-- ===================================================== --}}
{{-- SECTION: SIDEBAR MENU --}}
{{-- ===================================================== --}}
{{-- @section('sidebar-menu') mendefinisikan bagian konten yang akan --}}
{{-- dimasukkan ke @yield('sidebar-menu') di layout parent --}}
@section('sidebar-menu')

    {{-- ---------------------------------------------------- --}}
    {{-- BAGIAN 1: MENU UTAMA --}}
    {{-- ---------------------------------------------------- --}}
    {{-- Label grup menu untuk mengelompokkan menu --}}
    {{-- CSS class 'menu-label' biasanya memiliki styling: --}}
    {{-- - Font kecil, bold, warna abu-abu --}}
    {{-- - Uppercase text --}}
    {{-- - Margin bawah untuk spacing --}}
    <div class="menu-label">Menu Utama</div>
    
    {{-- Container untuk item menu navigasi --}}
    {{-- Struktur: div.nav-item > a.nav-link --}}
    <div class="nav-item">
        {{-- Link navigasi ke halaman Dashboard Admin --}}
        {{-- route('admin.dashboard') menghasilkan URL: /admin/dashboard --}}
        {{-- URL ini didefinisikan di routes/web.php dengan name('admin.dashboard') --}}
        <a href="{{ route('admin.dashboard') }}" 
           {{-- Class 'nav-link' adalah styling dasar untuk link menu --}}
           {{-- Conditional: Jika route saat ini adalah admin.dashboard, --}}
           {{-- tambahkan class 'active' untuk highlight menu yang sedang aktif --}}
           {{-- request()->routeIs('admin.dashboard') return true jika URL sesuai --}}
           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            
            {{-- Ikon menggunakan Bootstrap Icons --}}
            {{-- 'bi bi-house-door' = ikon rumah/pintu --}}
            {{-- Bootstrap Icons adalah library icon SVG gratis --}}
            {{-- Dokumentasi: https://icons.getbootstrap.com/ --}}
            <i class="bi bi-house-door"></i>
            
            {{-- Teks label menu yang ditampilkan --}}
            <span>Dashboard</span>
        </a>
    </div>

    {{-- ---------------------------------------------------- --}}
    {{-- BAGIAN 2: MANAJEMEN DATA --}}
    {{-- ---------------------------------------------------- --}}
    {{-- Grup menu untuk fitur pengelolaan data master --}}
    <div class="menu-label">Manajemen Data</div>
    
    {{-- Menu Pengguna (Users) --}}
    <div class="nav-item">
        <a href="{{ route('admin.users.index') }}" 
           {{-- routeIs('admin.users.*') = aktif untuk SEMUA route yang diawali 'admin.users.' --}}
           {{-- Contoh: admin.users.index, admin.users.create, admin.users.edit --}}
           class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            {{-- 'bi bi-people' = ikon grup orang --}}
            <i class="bi bi-people"></i>
            <span>Pengguna</span>
        </a>
    </div>
    
    {{-- Menu Santri --}}
    <div class="nav-item">
        <a href="{{ route('admin.santri.index') }}" 
           class="nav-link {{ request()->routeIs('admin.santri.*') ? 'active' : '' }}">
            {{-- 'bi bi-person-badge' = ikon badge/kartu identitas orang --}}
            <i class="bi bi-person-badge"></i>
            <span>Santri</span>
        </a>
    </div>
    
    {{-- Menu Wali Santri --}}
    <div class="nav-item">
        <a href="{{ route('admin.wali-santri.index') }}" 
           class="nav-link {{ request()->routeIs('admin.wali-santri.*') ? 'active' : '' }}">
            {{-- 'bi bi-people-fill' = ikon grup orang (filled/terisi) --}}
            <i class="bi bi-people-fill"></i>
            <span>Wali Santri</span>
        </a>
    </div>
    
    {{-- Menu Kelas --}}
    <div class="nav-item">
        <a href="{{ route('admin.kelas.index') }}" 
           class="nav-link {{ request()->routeIs('admin.kelas.*') ? 'active' : '' }}">
            {{-- 'bi bi-building' = ikon gedung --}}
            <i class="bi bi-building"></i>
            <span>Kelas</span>
        </a>
    </div>
    
    {{-- Menu Jurusan --}}
    <div class="nav-item">
        <a href="{{ route('admin.jurusan.index') }}" 
           class="nav-link {{ request()->routeIs('admin.jurusan.*') ? 'active' : '' }}">
            {{-- 'bi bi-mortarboard' = ikon topi wisuda --}}
            <i class="bi bi-mortarboard"></i>
            <span>Jurusan</span>
        </a>
    </div>

    {{-- ---------------------------------------------------- --}}
    {{-- BAGIAN 3: KEUANGAN --}}
    {{-- ---------------------------------------------------- --}}
    <div class="menu-label">Keuangan</div>
    
    {{-- Menu Pembayaran --}}
    <div class="nav-item">
        <a href="{{ route('admin.pembayaran.index') }}" 
           class="nav-link {{ request()->routeIs('admin.pembayaran.*') ? 'active' : '' }}">
            {{-- 'bi bi-credit-card' = ikon kartu kredit --}}
            <i class="bi bi-credit-card"></i>
            <span>Pembayaran</span>
        </a>
    </div>
    
    {{-- Menu Laporan --}}
    <div class="nav-item">
        <a href="{{ route('admin.laporan.index') }}" 
           class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
            {{-- 'bi bi-file-earmark-bar-graph' = ikon file dengan grafik --}}
            <i class="bi bi-file-earmark-bar-graph"></i>
            <span>Laporan</span>
        </a>
    </div>

    {{-- ---------------------------------------------------- --}}
    {{-- BAGIAN 4: INFORMASI --}}
    {{-- ---------------------------------------------------- --}}
    <div class="menu-label">Informasi</div>
    
    {{-- Menu Pengumuman --}}
    <div class="nav-item">
        <a href="{{ route('admin.pengumuman.index') }}" 
           class="nav-link {{ request()->routeIs('admin.pengumuman.*') ? 'active' : '' }}">
            {{-- 'bi bi-megaphone' = ikon megafon/pengeras suara --}}
            <i class="bi bi-megaphone"></i>
            <span>Pengumuman</span>
        </a>
    </div>

    {{-- Menu Kegiatan --}}
    <div class="nav-item">
        <a href="{{ route('admin.kegiatan.index') }}" 
           class="nav-link {{ request()->routeIs('admin.kegiatan.*') ? 'active' : '' }}">
            {{-- 'bi bi-calendar-check' = ikon kalender dengan centang --}}
            <i class="bi bi-calendar-check"></i>
            <span>Kegiatan</span>
        </a>
    </div>

    {{-- ---------------------------------------------------- --}}
    {{-- BAGIAN 5: LANDING PAGE --}}
    {{-- Menu untuk mengelola konten website publik --}}
    {{-- ---------------------------------------------------- --}}
    <div class="menu-label">Landing Page</div>
    
    {{-- Menu Profil Sekolah --}}
    <div class="nav-item">
        <a href="{{ route('admin.landing.profil.index') }}" 
           class="nav-link {{ request()->routeIs('admin.landing.profil.*') ? 'active' : '' }}">
            {{-- 'bi bi-building' = ikon gedung --}}
            <i class="bi bi-building"></i>
            <span>Profil Sekolah</span>
        </a>
    </div>
    
    {{-- Menu Berita --}}
    <div class="nav-item">
        <a href="{{ route('admin.landing.berita.index') }}" 
           class="nav-link {{ request()->routeIs('admin.landing.berita.*') ? 'active' : '' }}">
            {{-- 'bi bi-newspaper' = ikon koran/surat kabar --}}
            <i class="bi bi-newspaper"></i>
            <span>Berita</span>
        </a>
    </div>
    
    {{-- Menu Galeri --}}
    <div class="nav-item">
        <a href="{{ route('admin.landing.galeri.index') }}" 
           class="nav-link {{ request()->routeIs('admin.landing.galeri.*') ? 'active' : '' }}">
            {{-- 'bi bi-images' = ikon beberapa gambar --}}
            <i class="bi bi-images"></i>
            <span>Galeri</span>
        </a>
    </div>
    
    {{-- Menu Slider --}}
    <div class="nav-item">
        <a href="{{ route('admin.landing.slider.index') }}" 
           class="nav-link {{ request()->routeIs('admin.landing.slider.*') ? 'active' : '' }}">
            {{-- 'bi bi-collection-play' = ikon koleksi/slideshow --}}
            <i class="bi bi-collection-play"></i>
            <span>Slider</span>
        </a>
    </div>

    {{-- ---------------------------------------------------- --}}
    {{-- BAGIAN 6: SISTEM --}}
    {{-- Menu untuk pengaturan sistem --}}
    {{-- ---------------------------------------------------- --}}
    <div class="menu-label">Sistem</div>
    
    {{-- Menu Payment Gateway --}}
    <div class="nav-item">
        <a href="{{ route('admin.pengaturan.payment.index') }}" 
           class="nav-link {{ request()->routeIs('admin.pengaturan.payment.*') ? 'active' : '' }}">
            {{-- 'bi bi-gear' = ikon gear/pengaturan --}}
            <i class="bi bi-gear"></i>
            <span>Payment Gateway</span>
        </a>
    </div>
    
    {{-- Menu Log Aktivitas --}}
    <div class="nav-item">
        <a href="{{ route('admin.log-aktivitas.index') }}" 
           class="nav-link {{ request()->routeIs('admin.log-aktivitas.*') ? 'active' : '' }}">
            {{-- 'bi bi-clock-history' = ikon jam dengan riwayat --}}
            <i class="bi bi-clock-history"></i>
            <span>Log Aktivitas</span>
        </a>
    </div>
    
{{-- @endsection menutup section 'sidebar-menu' --}}
{{-- Konten setelah ini akan kembali ke layout parent --}}
@endsection
