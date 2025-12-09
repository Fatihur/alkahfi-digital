@extends('layouts.app')

@section('sidebar-menu')
    <div class="menu-label">Menu Utama</div>
    <div class="nav-item">
        <a href="{{ route('bendahara.dashboard') }}" class="nav-link {{ request()->routeIs('bendahara.dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-door"></i>
            <span>Dashboard</span>
        </a>
    </div>

    <div class="menu-label">Keuangan</div>
    <div class="nav-item">
        <a href="{{ route('bendahara.tagihan.index') }}" class="nav-link {{ request()->routeIs('bendahara.tagihan.*') ? 'active' : '' }}">
            <i class="bi bi-receipt"></i>
            <span>Tagihan</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="{{ route('bendahara.pembayaran.index') }}" class="nav-link {{ request()->routeIs('bendahara.pembayaran.*') ? 'active' : '' }}">
            <i class="bi bi-credit-card"></i>
            <span>Pembayaran</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="{{ route('bendahara.laporan.index') }}" class="nav-link {{ request()->routeIs('bendahara.laporan.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-bar-graph"></i>
            <span>Laporan</span>
        </a>
    </div>
@endsection
