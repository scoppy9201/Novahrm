@extends('nova-dashboard::layouts')

@section('title', 'Quản lý nhân viên — NovaHRM')

@section('styles')
    @vite([
        'app/packages/Nova/Dashboard/src/resources/css/app.css',
        'app/packages/Nova/Employee/src/resources/css/app.css',
        'app/packages/Nova/Employee/src/resources/js/app.js',
        "app/packages/Nova/Employee/src/resources/js/si_app.js",
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