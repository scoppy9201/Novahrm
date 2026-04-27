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
            <span class="logo-text">Nova<span>HRM</span></span>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}" class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" title="Bảng điều khiển">
                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
                <span class="sidebar-item-label">Bảng điều khiển</span>
            </a>
            <a href="#" class="sidebar-item" title="Nhân viên">
                <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                <span class="sidebar-item-label">Nhân viên</span>
            </a>
            <a href="#" class="sidebar-item" title="Sơ đồ tổ chức">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="5" r="2"/><circle cx="5" cy="19" r="2"/><circle cx="19" cy="19" r="2"/><line x1="12" y1="7" x2="12" y2="13"/><line x1="12" y1="13" x2="5" y2="17"/><line x1="12" y1="13" x2="19" y2="17"/></svg>
                <span class="sidebar-item-label">Sơ đồ tổ chức</span>
            </a>
            <a href="#" class="sidebar-item" title="Vị trí & Phòng ban">
                <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                <span class="sidebar-item-label">Vị trí & Phòng ban</span>
            </a>
            <a href="#" class="sidebar-item" title="Tài liệu">
                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                <span class="sidebar-item-label">Tài liệu</span>
            </a>
            <a href="#" class="sidebar-item" title="Chấm công">
                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <span class="sidebar-item-label">Chấm công</span>
            </a>
            <a href="#" class="sidebar-item" title="Bảng lương">
                <svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                <span class="sidebar-item-label">Bảng lương</span>
            </a>
            <a href="#" class="sidebar-item" title="Tuyển dụng">
                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <span class="sidebar-item-label">Tuyển dụng</span>
            </a>
            <a href="#" class="sidebar-item" title="Đào tạo">
                <svg viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                <span class="sidebar-item-label">Đào tạo</span>
            </a>
            <a href="#" class="sidebar-item" title="Chính sách">
                <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                <span class="sidebar-item-label">Chính sách</span>
            </a>
            <a href="#" class="sidebar-item" title="Cài đặt">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
                <span class="sidebar-item-label">Cài đặt</span>
            </a>
        </nav>

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

        <button class="sidebar-toggle" id="sidebar-toggle" type="button">
            <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        </button>

    </aside>

    <div class="hrm-main">
        @yield('content')
    </div>
</div>

@yield('scripts')
</body>
</html>
