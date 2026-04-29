<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'NovaHRM')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=be-vietnam-pro:400,500,600,700,800,900" rel="stylesheet"/>
    @yield('styles')
</head>
<body>

<div class="hrm-layout">
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <div class="logo-icon">
                <svg viewBox="0 0 16 16"><path d="M8 1L14 4V8C14 11.3 11.3 13.8 8 15C4.7 13.8 2 11.3 2 8V4L8 1Z"/></svg>
            </div>
            <div class="logo-text">
                <span class="logo-eyebrow">Nền tảng</span>
                <span class="logo-name">Nova<span>HRM</span></span>
            </div>
        </div>

        <div class="sidebar-search" id="sidebar-search-wrap">
            <svg viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/>
                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input
                id="sidebar-search-input"
                type="text"
                placeholder="Tìm tính năng..."
                autocomplete="off"
            />
        </div>

        <div class="sidebar-nav-wrap">
            <nav class="sidebar-nav">
                <div class="sidebar-group is-active" data-sidebar-group data-group-name="Nova HRM+">
                    <button class="sidebar-group-trigger" type="button" title="Nova HRM+">
                        <span class="sidebar-group-icon">
                            <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </span>
                        <span class="sidebar-group-text">
                            <span class="sidebar-group-title">Nova HRM+</span>
                            <span class="sidebar-group-subtitle">Quản trị nhân sự cốt lõi</span>
                        </span>
                    </button>
                    <div class="sidebar-submenu">
                        <a href="{{ route('dashboard') }}" class="sidebar-submenu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" data-sidebar-search-item data-search-label="Bảng điều khiển">
                            <span class="submenu-bullet"></span>
                            <span class="sidebar-submenu-label">Bảng điều khiển</span>
                        </a>
                        <a href="#" class="sidebar-submenu-item" data-sidebar-search-item data-search-label="Nhân viên">
                            <span class="submenu-bullet"></span>
                            <span class="sidebar-submenu-label">Nhân viên</span>
                        </a>
                        <a href="{{ route('org-chart.index') }}" class="sidebar-submenu-item" data-sidebar-search-item data-search-label="Sơ đồ tổ chức">
                            <span class="submenu-bullet"></span>
                            <span class="sidebar-submenu-label">Sơ đồ tổ chức</span>
                        </a>
                        <a href="#" class="sidebar-submenu-item" data-sidebar-search-item data-search-label="Vị trí và phòng ban">
                            <span class="submenu-bullet"></span>
                            <span class="sidebar-submenu-label">Vị trí &amp; Phòng ban</span>
                        </a>
                        <a href="{{ route('documents.index') }}" class="sidebar-submenu-item {{ request()->routeIs('documents.*') ? 'active' : '' }}" data-sidebar-search-item data-search-label="Tài liệu">
                            <span class="submenu-bullet"></span>
                            <span class="sidebar-submenu-label">Tài liệu</span>
                        </a>
                    </div>
                </div>

                <div class="sidebar-group" data-sidebar-group data-group-name="Nova Phát Triển">
                    <button class="sidebar-group-trigger" type="button" title="Nova Phát Triển">
                        <span class="sidebar-group-icon accent-purple">
                            <svg viewBox="0 0 24 24"><path d="M12 20V10"/><path d="M18 20V4"/><path d="M6 20v-6"/><path d="M4 20h16"/></svg>
                        </span>
                        <span class="sidebar-group-text">
                            <span class="sidebar-group-title">Nova Phát Triển</span>
                            <span class="sidebar-group-subtitle">Tuyển dụng và nâng lực đội ngũ</span>
                        </span>
                    </button>
                    <div class="sidebar-submenu">
                        <a href="#" class="sidebar-submenu-item" data-sidebar-search-item data-search-label="Tuyển dụng">
                            <span class="submenu-bullet"></span>
                            <span class="sidebar-submenu-label">Tuyển dụng</span>
                        </a>
                        <a href="#" class="sidebar-submenu-item" data-sidebar-search-item data-search-label="Đào tạo">
                            <span class="submenu-bullet"></span>
                            <span class="sidebar-submenu-label">Đào tạo</span>
                        </a>
                        <a href="#" class="sidebar-submenu-item" data-sidebar-search-item data-search-label="Chính sách">
                            <span class="submenu-bullet"></span>
                            <span class="sidebar-submenu-label">Chính sách</span>
                        </a>
                    </div>
                </div>

                <div class="sidebar-group" data-sidebar-group data-group-name="Nova Vận Hành">
                    <button class="sidebar-group-trigger" type="button" title="Nova Vận Hành">
                        <span class="sidebar-group-icon accent-amber">
                            <svg viewBox="0 0 24 24"><path d="M4 13h5l2-8 4 14 2-6h3"/></svg>
                        </span>
                        <span class="sidebar-group-text">
                            <span class="sidebar-group-title">Nova Vận Hành</span>
                            <span class="sidebar-group-subtitle">Công, lương và vận hành nội bộ</span>
                        </span>
                    </button>
                    <div class="sidebar-submenu">
                        <a href="#" class="sidebar-submenu-item" data-sidebar-search-item data-search-label="Chấm công">
                            <span class="submenu-bullet"></span>
                            <span class="sidebar-submenu-label">Chấm công</span>
                        </a>
                        <a href="#" class="sidebar-submenu-item" data-sidebar-search-item data-search-label="Bảng lương">
                            <span class="submenu-bullet"></span>
                            <span class="sidebar-submenu-label">Bảng lương</span>
                        </a>
                    </div>
                </div>

                <div class="sidebar-group sidebar-group-settings" data-sidebar-group data-group-name="Cấu hình">
                    <button class="sidebar-group-trigger" type="button" title="Cấu hình">
                        <span class="sidebar-group-icon accent-slate">
                            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82 2 2 0 1 1-2.83 2.83 1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51 2 2 0 1 1-4 0 1.65 1.65 0 0 0-1-1.51 1.65 1.65 0 0 0-1.82.33 2 2 0 1 1-2.83-2.83 1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1 2 2 0 1 1 0-4 1.65 1.65 0 0 0 1.51-1 1.65 1.65 0 0 0-.33-1.82 2 2 0 1 1 2.83-2.83 1.65 1.65 0 0 0 1.82.33h0A1.65 1.65 0 0 0 10 2.6a2 2 0 1 1 4 0 1.65 1.65 0 0 0 1 1.51h0a1.65 1.65 0 0 0 1.82-.33 2 2 0 1 1 2.83 2.83 1.65 1.65 0 0 0-.33 1.82v0A1.65 1.65 0 0 0 21.4 10a2 2 0 1 1 0 4 1.65 1.65 0 0 0-1.51 1z"/></svg>
                        </span>
                        <span class="sidebar-group-text">
                            <span class="sidebar-group-title">Cấu hình</span>
                            <span class="sidebar-group-subtitle">Thiết lập hệ thống và tài khoản</span>
                        </span>
                    </button>
                    <div class="sidebar-submenu">
                        <a href="{{ route('profile.index') }}" class="sidebar-submenu-item {{ request()->routeIs('profile.*') ? 'active' : '' }}" data-sidebar-search-item data-search-label="Tài khoản của tôi">
                            <span class="submenu-bullet"></span>
                            <span class="sidebar-submenu-label">Tài khoản của tôi</span>
                        </a>
                        <a href="#" class="sidebar-submenu-item" data-sidebar-search-item data-search-label="Cài đặt hệ thống">
                            <span class="submenu-bullet"></span>
                            <span class="sidebar-submenu-label">Cài đặt hệ thống</span>
                        </a>
                    </div>
                </div>
            </nav>
        </div>

        <div class="sidebar-avatar-btn" id="sidebar-avatar-btn">
            <div class="av-circle">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
            </div>
            <div class="av-info">
                <div class="av-name">{{ Auth::user()->name }}</div>
                <div class="av-role">{{ Auth::user()->role ?? 'Quản trị viên' }}</div>
            </div>
        </div>

        <div class="user-menu" id="user-menu">
            <a href="{{ route('profile.index') }}" class="user-menu-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Tài khoản của tôi
            </a>
            <a href="#" class="user-menu-item danger" data-logout data-logout-form="logout-form">
                <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Đăng xuất
            </a>
        </div>
        <form id="logout-form" action="/logout" method="POST" style="display:none">
            @csrf
        </form>

        <button class="sidebar-toggle" id="sidebar-toggle" type="button" aria-label="Mở rộng thanh bên">
            <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        </button>
    </aside>

    <div class="hrm-main">
        @yield('content')
    </div>
</div>
<div class="sidebar-tooltip" id="sidebar-tooltip"></div>
@yield('scripts')
</body>
</html>
