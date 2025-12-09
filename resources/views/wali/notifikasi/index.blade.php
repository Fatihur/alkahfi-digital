@extends('layouts.wali')

@section('title', 'Notifikasi')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Notifikasi</h1>
            <p class="page-subtitle">Daftar semua notifikasi Anda.</p>
        </div>
        @if($notifikasi->where('is_read', false)->count() > 0)
        <div>
            <form action="{{ route('wali.notifikasi.mark-all-read') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-secondary">
                    <i class="bi bi-check-all"></i> Tandai Semua Dibaca
                </button>
            </form>
        </div>
        @endif
    </div>

    <div class="card">
        <div class="card-body p-0">
            @forelse($notifikasi as $item)
                <a href="{{ route('wali.notifikasi.show', $item) }}" class="notifikasi-item d-block {{ !$item->is_read ? 'unread' : '' }}">
                    <div class="d-flex align-items-start gap-3 p-3 border-bottom">
                        <div class="notifikasi-icon">
                            @if($item->tipe == 'tagihan')
                                <i class="bi bi-receipt text-warning"></i>
                            @elseif($item->tipe == 'pembayaran')
                                <i class="bi bi-check-circle text-success"></i>
                            @elseif($item->tipe == 'pengumuman')
                                <i class="bi bi-megaphone text-primary"></i>
                            @else
                                <i class="bi bi-info-circle text-info"></i>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <h6 class="mb-1 {{ !$item->is_read ? 'fw-bold' : '' }}">{{ $item->judul }}</h6>
                                <small class="text-muted">{{ $item->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-0 text-muted small">{{ Str::limit($item->pesan, 100) }}</p>
                        </div>
                        @if(!$item->is_read)
                            <span class="badge badge-primary">Baru</span>
                        @endif
                    </div>
                </a>
            @empty
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-bell-slash fs-1"></i>
                    <p class="mt-2">Tidak ada notifikasi</p>
                </div>
            @endforelse
        </div>
        @if($notifikasi->hasPages())
            <div class="card-footer">
                {{ $notifikasi->links() }}
            </div>
        @endif
    </div>

    <style>
        .notifikasi-item {
            text-decoration: none;
            color: inherit;
            transition: background-color 0.2s;
        }
        .notifikasi-item:hover {
            background-color: var(--bg-body);
        }
        .notifikasi-item.unread {
            background-color: var(--primary-subtle);
        }
        .notifikasi-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--bg-body);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
    </style>
@endsection
