<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="#" class="sidebar-logo">
                <i class="bi bi-mortarboard-fill"></i>
                <span class="sidebar-brand">ALKAHFI DIGITAL</span>
            </a>
        </div>

        <div class="sidebar-menu">
            @yield('sidebar-menu')
        </div>

        <div class="sidebar-footer">
            <div class="user-profile">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=eef2ff&color=4f46e5" alt="User" class="user-avatar">
                <div class="user-info">
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">{{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}</div>
                </div>
            </div>
        </div>
    </aside>

    <main class="main-content">
        <nav class="top-navbar">
            <button class="btn-icon" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>

            <div class="search-box">
                <i class="bi bi-search" style="color: var(--text-muted)"></i>
                <input type="text" placeholder="Cari...">
            </div>

            <div class="navbar-actions">
                <button class="btn-icon" id="themeToggle">
                    <i class="bi bi-moon"></i>
                </button>
                @if(auth()->user()->isWaliSantri())
                <div class="notification-dropdown">
                    <button class="btn-icon" id="notificationBtn" onclick="toggleNotificationDropdown()">
                        <i class="bi bi-bell"></i>
                        @php
                            $unreadNotifCount = \App\Models\Notifikasi::where('user_id', auth()->id())->where('is_read', false)->count();
                        @endphp
                        @if($unreadNotifCount > 0)
                            <span class="notification-badge">{{ $unreadNotifCount > 9 ? '9+' : $unreadNotifCount }}</span>
                        @endif
                    </button>
                    <div class="notification-menu" id="notificationMenu">
                        <div class="notification-header">
                            <span class="fw-bold">Notifikasi</span>
                            @if($unreadNotifCount > 0)
                                <span class="badge badge-primary">{{ $unreadNotifCount }} baru</span>
                            @endif
                        </div>
                        <div class="notification-body" id="notificationBody">
                            @php
                                $latestNotif = \App\Models\Notifikasi::where('user_id', auth()->id())->latest()->take(5)->get();
                            @endphp
                            @forelse($latestNotif as $notif)
                                <a href="{{ route('wali.notifikasi.show', $notif) }}" class="notification-item {{ !$notif->is_read ? 'unread' : '' }}">
                                    <div class="notification-icon">
                                        @if($notif->tipe == 'tagihan')
                                            <i class="bi bi-receipt text-warning"></i>
                                        @elseif($notif->tipe == 'pembayaran')
                                            <i class="bi bi-check-circle text-success"></i>
                                        @else
                                            <i class="bi bi-info-circle text-info"></i>
                                        @endif
                                    </div>
                                    <div class="notification-content">
                                        <div class="notification-title">{{ $notif->judul }}</div>
                                        <div class="notification-text">{{ Str::limit($notif->pesan, 50) }}</div>
                                        <div class="notification-time">{{ $notif->created_at->diffForHumans() }}</div>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-4 text-muted">
                                    <i class="bi bi-bell-slash"></i>
                                    <p class="mb-0 small">Tidak ada notifikasi</p>
                                </div>
                            @endforelse
                        </div>
                        <div class="notification-footer">
                            <a href="{{ route('wali.notifikasi.index') }}">Lihat Semua Notifikasi</a>
                        </div>
                    </div>
                </div>
                @else
                <button class="btn-icon" id="notificationBtn">
                    <i class="bi bi-bell"></i>
                </button>
                @endif
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-icon" title="Logout">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </nav>

        <div class="page-content">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <button class="btn-icon mobile-toggle" id="mobileToggle" style="position: fixed; bottom: 20px; right: 20px; background: var(--primary-color); color: white; width: 48px; height: 48px; border-radius: 50%; display: none; z-index: 100; box-shadow: 0 4px 12px rgba(79,70,229,0.3);">
        <i class="bi bi-list"></i>
    </button>

    <style>
        /* Notification Dropdown */
        .notification-dropdown {
            position: relative;
        }
        .notification-badge {
            position: absolute;
            top: 4px;
            right: 4px;
            background: var(--danger-color, #ef4444);
            color: white;
            font-size: 10px;
            padding: 2px 5px;
            border-radius: 10px;
            min-width: 16px;
            text-align: center;
        }
        .notification-menu {
            position: absolute;
            top: 100%;
            right: 0;
            width: 320px;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            display: none;
            z-index: 1000;
            overflow: hidden;
        }
        .notification-menu.show {
            display: block;
        }
        .notification-header {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .notification-body {
            max-height: 300px;
            overflow-y: auto;
        }
        .notification-item {
            display: flex;
            gap: 12px;
            padding: 12px 16px;
            text-decoration: none;
            color: inherit;
            border-bottom: 1px solid var(--border-color);
            transition: background 0.2s;
        }
        .notification-item:hover {
            background: var(--bg-body);
        }
        .notification-item.unread {
            background: var(--primary-subtle);
        }
        .notification-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--bg-body);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .notification-content {
            flex: 1;
            min-width: 0;
        }
        .notification-title {
            font-weight: 600;
            font-size: 0.875rem;
            margin-bottom: 2px;
        }
        .notification-text {
            font-size: 0.75rem;
            color: var(--text-muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .notification-time {
            font-size: 0.7rem;
            color: var(--text-muted);
            margin-top: 4px;
        }
        .notification-footer {
            padding: 12px 16px;
            text-align: center;
            border-top: 1px solid var(--border-color);
        }
        .notification-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        @media(max-width: 768px) { .mobile-toggle { display: flex !important; } }
        
        /* Pagination Styles */
        nav[role="navigation"] {
            display: flex;
            justify-content: center;
        }
        
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            gap: 4px;
            flex-wrap: wrap;
        }
        
        .page-item {
            margin: 0;
        }
        
        .page-item .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 38px;
            height: 38px;
            padding: 0 12px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background: var(--bg-card);
            color: var(--text-color);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        
        .page-item .page-link:hover:not(.disabled) {
            background: var(--primary-subtle);
            border-color: var(--primary-color);
            color: var(--primary-color);
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(79, 70, 229, 0.15);
        }
        
        .page-item.active .page-link {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(79, 70, 229, 0.3);
        }
        
        .page-item.disabled .page-link {
            background: var(--bg-body);
            color: var(--text-muted);
            cursor: not-allowed;
            opacity: 0.6;
        }
        
        .page-item.disabled .page-link:hover {
            transform: none;
            box-shadow: none;
        }
        
        /* Pagination arrows */
        .page-item:first-child .page-link,
        .page-item:last-child .page-link {
            font-weight: 600;
        }
        
        /* Responsive pagination */
        @media (max-width: 576px) {
            .pagination {
                gap: 2px;
            }
            
            .page-item .page-link {
                min-width: 32px;
                height: 32px;
                padding: 0 8px;
                font-size: 0.8rem;
            }
        }
    </style>

    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        function toggleNotificationDropdown() {
            const menu = document.getElementById('notificationMenu');
            menu.classList.toggle('show');
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const dropdown = document.querySelector('.notification-dropdown');
            const menu = document.getElementById('notificationMenu');
            if (dropdown && menu && !dropdown.contains(e.target)) {
                menu.classList.remove('show');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
