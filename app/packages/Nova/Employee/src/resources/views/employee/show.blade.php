@extends('nova-dashboard::layouts')

@section('title', $employee->name . ' — NovaHRM')

@section('styles')
    @vite([
        'app/packages/Nova/Dashboard/src/resources/css/app.css',
        'app/packages/Nova/Employee/src/resources/css/app.css',
    ])
@endsection

@section('scripts')
    @vite([
        'app/packages/Nova/Dashboard/src/resources/js/app.js',
        'app/packages/Nova/Employee/src/resources/js/si_app.js',
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
                <a href="{{ route('hr.employees.index') }}">Nhân viên</a>
                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                <span>{{ $employee->name }}</span>
            </div>
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap">
                <div class="emp-page-title">{{ $employee->name }}</div>
                <span style="font-size:11px;font-weight:700;color:#94a3b8;font-family:'Courier New',monospace;background:#f8fafc;padding:2px 9px;border-radius:5px;border:1px solid #e2e8f0">
                    {{ $employee->employee_code }}
                </span>
                @php
                    $stClass = match($employee->status) {
                        'active'                    => 'emp-badge-active',
                        'probation'                 => 'emp-badge-probation',
                        'on_leave','maternity_leave',
                        'paternity_leave'           => 'emp-badge-blue',
                        'suspended'                 => 'emp-badge-danger',
                        'resigned','terminated',
                        'retired','deceased'        => 'emp-badge-inactive',
                        default                     => 'emp-badge-gray',
                    };
                    $stDot = match($employee->status) {
                        'active'                              => 'active',
                        'probation'                           => 'probation',
                        'on_leave','maternity_leave',
                        'paternity_leave','sick_leave'        => 'on_leave',
                        'suspended'                           => 'suspended',
                        default                               => 'inactive',
                    };
                @endphp
                <span class="emp-badge {{ $stClass }}">
                    <span class="emp-status-dot {{ $stDot }}"></span>
                    {{ \Nova\Auth\Models\Employee::STATUSES[$employee->status] ?? $employee->status }}
                </span>
                @if($employee->employment_type)
                    <span class="emp-badge emp-badge-gray">
                        {{ \Nova\Auth\Models\Employee::EMPLOYMENT_TYPES[$employee->employment_type] ?? $employee->employment_type }}
                    </span>
                @endif
                @if($employee->is_contract_expiring)
                    <span class="emp-badge emp-badge-danger">
                        <svg viewBox="0 0 24 24" style="width:11px;height:11px;stroke:currentColor;fill:none;stroke-width:2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        HĐ hết {{ $employee->contract_end_date->diffForHumans() }}
                    </span>
                @endif
            </div>
            @if($employee->position || $employee->department)
            <div class="emp-page-subtitle" style="margin-top:4px;display:flex;align-items:center;gap:6px">
                @if($employee->department?->color)
                    <span style="width:7px;height:7px;border-radius:50%;background:{{ $employee->department->color }};display:inline-block"></span>
                @endif
                @if($employee->department)
                    <a href="{{ route('hr.departments.show', $employee->department) }}"
                       style="color:#94a3b8;text-decoration:none;font-weight:600;transition:color 0.15s"
                       onmouseover="this.style.color='#475569'" onmouseout="this.style.color='#94a3b8'">
                        {{ $employee->department->name }}
                    </a>
                @endif
                @if($employee->position)
                    <span style="color:#cbd5e1">·</span>
                    <span style="color:#94a3b8;font-weight:600">{{ $employee->position->title }}</span>
                @endif
            </div>
            @endif
        </div>

        <div class="emp-actions">
            <a href="{{ route('hr.employees.index') }}" class="btn-emp-secondary">
                <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Quay lại
            </a>
            @if($employee->is_active)
                <button type="button" class="btn-emp-amber" id="btn-transfer">
                    <svg viewBox="0 0 24 24"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
                    Chuyển phòng
                </button>
                <button type="button" class="btn-emp-danger" id="btn-terminate">
                    <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Nghỉ việc
                </button>
            @else
                <form method="POST" action="{{ route('hr.employees.reinstate', $employee) }}" style="display:inline">
                    @csrf
                    <button type="submit" class="btn-emp-secondary">
                        <svg viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4.41"/></svg>
                        Khôi phục
                    </button>
                </form>
            @endif
            <a href="{{ route('hr.employees.edit', $employee) }}" class="btn-emp-primary">
                <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Chỉnh sửa
            </a>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="emp-tabs">
        <a class="emp-tab active" data-tab="tab-overview" href="#tab-overview">Tổng quan</a>
        <a class="emp-tab" data-tab="tab-personal" href="#tab-personal">Thông tin cá nhân</a>
        <a class="emp-tab" data-tab="tab-contract" href="#tab-contract">Hợp đồng</a>
        <a class="emp-tab" data-tab="tab-documents" href="#tab-documents">Tài liệu</a>
        <a class="emp-tab" data-tab="tab-subordinates" href="#tab-subordinates">
            Cấp dưới
            @if($employee->subordinates->count() > 0)
                <span class="emp-badge emp-badge-blue" style="margin-left:4px;padding:1px 7px">
                    {{ $employee->subordinates->count() }}
                </span>
            @endif
        </a>
    </div>
</header>

{{-- Flash --}}
@if(session('success'))
<div style="padding:14px 24px 0">
    <div class="emp-alert emp-alert-success" data-auto-close>
        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
        {{ session('success') }}
    </div>
</div>
@endif
@if(session('error'))
<div style="padding:14px 24px 0">
    <div class="emp-alert emp-alert-danger" data-auto-close>
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        {{ session('error') }}
    </div>
</div>
@endif

@include('nova-employee::employee.partials.tabs_si.modal_terminate')
@include('nova-employee::employee.partials.tabs_si.tab_overview')
@include('nova-employee::employee.partials.tabs_si.tab_personal')
@include('nova-employee::employee.partials.tabs_si.tab_contract')
@include('nova-employee::employee.partials.tabs_si.tab_documents')
@include('nova-employee::employee.partials.tabs_si.tab_subordinates')

@endsection