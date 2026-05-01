@extends('nova-dashboard::layouts')

@section('title', 'Quản lý nhân viên — NovaHRM')

@section('styles')
    @vite([
        'app/packages/Nova/Dashboard/src/resources/css/app.css',
        'app/packages/Nova/Employee/src/resources/css/app.css',
    ])
@endsection

@section('content')

<header class="emp-topbar">
    <div class="emp-topbar-row1">
        <div>
            <div class="emp-breadcrumb">
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                <a href="#">Nova HRM+</a>
                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                <span>Nhân viên</span>
            </div>
            <div class="emp-page-title">Quản lý nhân viên</div>
            <div class="emp-page-subtitle">Tổng quan toàn bộ nhân sự trong hệ thống</div>
        </div>
        <div class="emp-actions">
            <a href="{{ route('hr.employees.export') }}" class="btn-emp-secondary" id="btn-export">
                <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Xuất Excel
            </a>
            <a href="{{ route('hr.employees.create') }}" class="btn-emp-primary">
                <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Thêm nhân viên
            </a>
        </div>
    </div>

    {{-- Tabs: All / Active / Resigned / Trash --}}
    <div class="emp-tabs">
        <a href="{{ route('hr.employees.index') }}"
           class="emp-tab {{ request('tab', 'all') === 'all' ? 'active' : '' }}">
            Tất cả
            <span class="emp-table-count">{{ $counts['all'] ?? 0 }}</span>
        </a>
        <a href="{{ route('hr.employees.index', ['tab' => 'active']) }}"
           class="emp-tab {{ request('tab') === 'active' ? 'active' : '' }}">
            <span class="emp-status-dot active" style="display:inline-block"></span>
            Đang làm
            <span class="emp-table-count">{{ $counts['active'] ?? 0 }}</span>
        </a>
        <a href="{{ route('hr.employees.index', ['tab' => 'resigned']) }}"
           class="emp-tab {{ request('tab') === 'resigned' ? 'active' : '' }}">
            Đã nghỉ
            <span class="emp-table-count">{{ $counts['resigned'] ?? 0 }}</span>
        </a>
        <a href="{{ route('hr.employees.index', ['tab' => 'trash']) }}"
           class="emp-tab {{ request('tab') === 'trash' ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" style="width:12px;height:12px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round">
                <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/>
            </svg>
            Thùng rác
            <span class="emp-table-count">{{ $counts['trash'] ?? 0 }}</span>
        </a>
    </div>
</header>

<div id="spa-content">
    @include('nova-employee::employee.partials.content')
</div>

@endsection

@section('scripts')
    @vite([
        'app/packages/Nova/Employee/src/resources/js/app.js',
    ])

    <script>
    document.addEventListener('DOMContentLoaded', function () {

        // Check All Checkbox 
        const checkAll = document.getElementById('check-all');
        if (checkAll) {
            checkAll.addEventListener('change', function () {
                document.querySelectorAll('.row-check').forEach(cb => {
                    cb.checked = this.checked;
                });
            });

            document.querySelectorAll('.row-check').forEach(cb => {
                cb.addEventListener('change', function () {
                    const all = document.querySelectorAll('.row-check');
                    const checked = document.querySelectorAll('.row-check:checked');
                    checkAll.indeterminate = checked.length > 0 && checked.length < all.length;
                    checkAll.checked = checked.length === all.length;
                });
            });
        }

        // Search debounce (auto-submit sau 500ms) 
        const searchInput = document.getElementById('search-input');
        if (searchInput) {
            let debounceTimer;
            searchInput.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    document.getElementById('filter-form').submit();
                }, 500);
            });
        }

        // Flash message tự đóng sau 4s 
        const flashMsgs = document.querySelectorAll('.emp-alert[data-auto-close]');
        flashMsgs.forEach(el => {
            setTimeout(() => {
                el.style.transition = 'opacity 0.4s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 400);
            }, 4000);
        });

    });

    document.addEventListener('DOMContentLoaded', function () {
        function spaNavigate(url) {
            const spaContent = document.getElementById('spa-content');
            spaContent.style.opacity = '0.5';
            spaContent.style.pointerEvents = 'none';

            fetch(url, {
                headers: { 'X-SPA-Request': '1' }
            })
            .then(res => res.text())
            .then(html => {
                spaContent.innerHTML = html;
                spaContent.style.opacity = '1';
                spaContent.style.pointerEvents = '';
                history.pushState({ url }, '', url);
                updateActiveTab(url);
                bindContentEvents();
            })
            .catch(() => {
                window.location.href = url;
            });
        }

        function updateActiveTab(url) {
            document.querySelectorAll('.emp-tab').forEach(tab => {
                const tabUrl = tab.getAttribute('href');
                tab.classList.toggle('active', url === tabUrl || url.includes(tabUrl.split('?')[1] ?? '____'));
            });
        }

        // Intercept tab clicks
        document.querySelectorAll('.emp-tab').forEach(tab => {
            tab.addEventListener('click', function (e) {
                e.preventDefault();
                spaNavigate(this.href);
            });
        });

        // Browser back/forward
        window.addEventListener('popstate', function (e) {
            if (e.state?.url) spaNavigate(e.state.url);
        });

        // Bind events cho content (cần gọi lại sau mỗi lần swap)
        function bindContentEvents() {

            // Checkbox select all
            const checkAll = document.getElementById('check-all');
            if (checkAll) {
                checkAll.addEventListener('change', function () {
                    document.querySelectorAll('.row-check').forEach(cb => cb.checked = this.checked);
                });
                document.querySelectorAll('.row-check').forEach(cb => {
                    cb.addEventListener('change', function () {
                        const all  = document.querySelectorAll('.row-check');
                        const checked = document.querySelectorAll('.row-check:checked');
                        checkAll.indeterminate = checked.length > 0 && checked.length < all.length;
                        checkAll.checked = checked.length === all.length;
                    });
                });
            }

            // Search debounce
            const searchInput = document.getElementById('search-input');
            if (searchInput) {
                let timer;
                searchInput.addEventListener('input', function () {
                    clearTimeout(timer);
                    timer = setTimeout(() => {
                        document.getElementById('filter-form').submit();
                    }, 500);
                });
            }

            // Filter selects → intercept submit bằng SPA
            const filterForm = document.getElementById('filter-form');
            if (filterForm) {
                filterForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const url = this.action + '?' + new URLSearchParams(new FormData(this)).toString();
                    spaNavigate(url);
                });
            }

            // Pagination links → intercept bằng SPA
            document.querySelectorAll('.emp-pagination a').forEach(link => {
                link.addEventListener('click', function (e) {
                    if (this.getAttribute('href') === '#') return;
                    e.preventDefault();
                    spaNavigate(this.href);
                });
            });
        }

        // Bind lần đầu khi load trang
        bindContentEvents();
    });
    </script>
@endsection