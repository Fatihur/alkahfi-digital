<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="#" class="sidebar-logo">
                <img src="{{ asset('logo-alkahfi.png') }}" alt="Logo" class="sidebar-logo-img">
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
        
        /* DataTables Custom Styling - Override Default */
        .dataTables_wrapper {
            font-family: 'Inter', sans-serif;
        }
        
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }
        
        .dataTables_wrapper .dataTables_length label,
        .dataTables_wrapper .dataTables_filter label {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
            font-size: 0.875rem;
            color: var(--text-main);
        }
        
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 8px 32px 8px 12px;
            background: var(--bg-card);
            color: var(--text-main);
            font-size: 0.875rem;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 8px center;
            background-size: 12px;
        }
        
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 8px 14px;
            background: var(--bg-card);
            color: var(--text-main);
            font-size: 0.875rem;
            min-width: 220px;
            margin-left: 8px;
        }
        
        .dataTables_wrapper .dataTables_filter input:focus,
        .dataTables_wrapper .dataTables_length select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
        
        .dataTables_wrapper .dataTables_info {
            color: var(--text-muted);
            font-size: 0.875rem;
            padding-top: 1rem;
        }
        
        .dataTables_wrapper .dataTables_paginate {
            padding-top: 1rem;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border: 1px solid var(--border-color) !important;
            border-radius: 6px !important;
            background: var(--bg-card) !important;
            color: var(--text-main) !important;
            padding: 6px 12px !important;
            margin: 0 3px !important;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.disabled):not(.current) {
            background: var(--primary-subtle) !important;
            border-color: var(--primary-color) !important;
            color: var(--primary-color) !important;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: white !important;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
            background: var(--bg-body) !important;
            border-color: var(--border-color) !important;
            color: var(--text-muted) !important;
            cursor: not-allowed;
            opacity: 0.6;
        }
        
        /* Table Styling */
        table.dataTable {
            border-collapse: separate !important;
            border-spacing: 0;
            width: 100% !important;
        }
        
        table.dataTable thead th {
            background: var(--bg-body) !important;
            border-bottom: 1px solid var(--border-color) !important;
            border-top: none !important;
            color: var(--text-muted);
            font-weight: 500;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 12px 16px !important;
            white-space: nowrap;
        }
        
        table.dataTable thead th:first-child {
            border-radius: 8px 0 0 0;
        }
        
        table.dataTable thead th:last-child {
            border-radius: 0 8px 0 0;
        }
        
        table.dataTable tbody td {
            padding: 14px 16px !important;
            border-bottom: 1px solid var(--border-color) !important;
            color: var(--text-main);
            vertical-align: middle;
        }
        
        table.dataTable tbody tr:hover {
            background-color: var(--bg-body) !important;
        }
        
        table.dataTable tbody tr:last-child td {
            border-bottom: none !important;
        }
        
        table.dataTable.no-footer {
            border-bottom: none !important;
        }
        
        /* Sorting Icons */
        table.dataTable thead .sorting,
        table.dataTable thead .sorting_asc,
        table.dataTable thead .sorting_desc {
            cursor: pointer;
            position: relative;
            padding-right: 26px !important;
        }
        
        table.dataTable thead .sorting:before,
        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting_asc:before,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_desc:before,
        table.dataTable thead .sorting_desc:after {
            position: absolute;
            right: 8px;
            font-size: 0.65rem;
            opacity: 0.3;
        }
        
        table.dataTable thead .sorting:before,
        table.dataTable thead .sorting_asc:before,
        table.dataTable thead .sorting_desc:before {
            content: "▲";
            top: 50%;
            transform: translateY(-80%);
        }
        
        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_desc:after {
            content: "▼";
            top: 50%;
            transform: translateY(20%);
        }
        
        table.dataTable thead .sorting_asc:before {
            opacity: 1;
            color: var(--primary-color);
        }
        
        table.dataTable thead .sorting_desc:after {
            opacity: 1;
            color: var(--primary-color);
        }
        
        /* Dark mode support */
        [data-theme="dark"] .dataTables_wrapper .dataTables_length select,
        [data-theme="dark"] .dataTables_wrapper .dataTables_filter input {
            background: var(--bg-card);
            color: var(--text-main);
            border-color: var(--border-color);
        }
        
        [data-theme="dark"] table.dataTable thead th {
            background: var(--bg-body) !important;
            color: var(--text-muted);
        }
        
        [data-theme="dark"] table.dataTable tbody td {
            color: var(--text-main);
        }
        
        [data-theme="dark"] .dataTables_wrapper .dataTables_paginate .paginate_button {
            background: var(--bg-card) !important;
            color: var(--text-main) !important;
            border-color: var(--border-color) !important;
        }
        
        /* Button Group */
        .btn-group {
            display: inline-flex;
            gap: 4px;
        }
        
        .btn-group .btn {
            border-radius: 6px;
        }
        
        /* Sidebar Logo Image */
        .sidebar-logo-img {
            width: 36px;
            height: 36px;
            object-fit: contain;
        }
        
        /* Button Colors */
        .btn-info {
            background: var(--info-color);
            color: white;
            border: none;
        }
        
        .btn-info:hover {
            background: #0284c7;
        }
        
        .btn-warning {
            background: var(--warning-color);
            color: white;
            border: none;
        }
        
        .btn-warning:hover {
            background: #d97706;
        }
        
        .btn-success {
            background: var(--success-color);
            color: white;
            border: none;
        }
        
        .btn-success:hover {
            background: #059669;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
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

        // DataTables default configuration
        $.extend(true, $.fn.dataTable.defaults, {
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                infoFiltered: "(disaring dari _MAX_ total data)",
                zeroRecords: "Tidak ada data yang cocok",
                emptyTable: "Tidak ada data tersedia",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            },
            responsive: true,
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]]
        });
    </script>
    @stack('scripts')
</body>
</html>
