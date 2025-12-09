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
                <button class="btn-icon" id="notificationBtn">
                    <i class="bi bi-bell"></i>
                </button>
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
    @stack('scripts')
</body>
</html>
