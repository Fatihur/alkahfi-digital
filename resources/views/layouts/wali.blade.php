@extends('layouts.app')

@section('sidebar-menu')
    <div class="menu-label">Menu Utama</div>
    <div class="nav-item">
        <a href="{{ route('wali.dashboard') }}" class="nav-link {{ request()->routeIs('wali.dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-door"></i>
            <span>Dashboard</span>
        </a>
    </div>

    <div class="menu-label">Pembayaran SPP</div>
    <div class="nav-item">
        <a href="{{ route('wali.tagihan.index') }}" class="nav-link {{ request()->routeIs('wali.tagihan.*') ? 'active' : '' }}">
            <i class="bi bi-receipt"></i>
            <span>Tagihan</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="{{ route('wali.pembayaran.index') }}" class="nav-link {{ request()->routeIs('wali.pembayaran.*') ? 'active' : '' }}">
            <i class="bi bi-credit-card"></i>
            <span>Riwayat Pembayaran</span>
        </a>
    </div>

    <div class="menu-label">Informasi Sekolah</div>
    <div class="nav-item">
        <a href="{{ route('wali.pengumuman.index') }}" class="nav-link {{ request()->routeIs('wali.pengumuman.*') ? 'active' : '' }}">
            <i class="bi bi-megaphone"></i>
            <span>Pengumuman</span>
        </a>
    </div>

    <div class="nav-item">
        <a href="{{ route('wali.kegiatan.index') }}" class="nav-link {{ request()->routeIs('wali.kegiatan.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-check"></i>
            <span>Kegiatan</span>
        </a>
    </div>

    <div class="menu-label">Lainnya</div>
    <div class="nav-item">
        <a href="{{ route('wali.notifikasi.index') }}" class="nav-link {{ request()->routeIs('wali.notifikasi.*') ? 'active' : '' }}">
            <i class="bi bi-bell"></i>
            <span>Notifikasi</span>
            @php
                $unreadCount = \App\Models\Notifikasi::where('user_id', auth()->id())->where('is_read', false)->count();
            @endphp
            @if($unreadCount > 0)
                <span class="badge badge-danger ms-auto">{{ $unreadCount }}</span>
            @endif
        </a>
    </div>
@endsection
