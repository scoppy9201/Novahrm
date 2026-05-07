@extends('nova-dashboard::layouts')

@section('title', 'Chỉnh sửa — ' . $employee->name . ' — NovaHRM')

@section('styles')
    @vite([
        'packages/Nova/Dashboard/src/resources/css/app.css',
        'packages/Nova/Employee/src/resources/css/app.css',
    ])
@endsection

@section('scripts')
    @vite([
        'packages/Nova/Dashboard/src/resources/js/app.js',
        'packages/Nova/Employee/src/resources/js/ce_app.js',
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
                <a href="{{ route('hr.employees.show', $employee) }}">{{ $employee->name }}</a>
                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                <span>Chỉnh sửa</span>
            </div>
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap">
                <div class="emp-page-title">Chỉnh sửa nhân viên</div>
                <span style="font-size:11px;font-weight:700;color:#94a3b8;font-family:'Courier New',monospace;background:#f8fafc;padding:2px 9px;border-radius:5px;border:1px solid #e2e8f0">
                    {{ $employee->employee_code }}
                </span>
                @php
                    $stClass = match($employee->status) {
                        'active'          => 'emp-badge-active',
                        'probation'       => 'emp-badge-probation',
                        'on_leave'        => 'emp-badge-blue',
                        'suspended'       => 'emp-badge-danger',
                        'resigned',
                        'terminated',
                        'retired'         => 'emp-badge-inactive',
                        default           => 'emp-badge-gray',
                    };
                    $stDot = match($employee->status) {
                        'active'    => 'active',
                        'probation' => 'probation',
                        'on_leave'  => 'on_leave',
                        'suspended' => 'suspended',
                        default     => 'inactive',
                    };
                @endphp
                <span class="emp-badge {{ $stClass }}">
                    <span class="emp-status-dot {{ $stDot }}"></span>
                    {{ \Nova\Auth\Models\Employee::STATUSES[$employee->status] ?? $employee->status }}
                </span>
            </div>
            <div class="emp-page-subtitle" style="margin-top:4px">
                {{ $employee->department?->name ?? 'Chưa có phòng ban' }}
                @if($employee->position) · {{ $employee->position->title }} @endif
            </div>
        </div>
        <div class="emp-actions">
            <a href="{{ route('hr.employees.show', $employee) }}" class="btn-emp-secondary">
                <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Huỷ
            </a>
            <button type="submit" form="emp-edit-form" class="btn-emp-primary">
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                Lưu thay đổi
            </button>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="emp-tabs">
        <a class="emp-tab active" data-tab="tab-personal" href="#tab-personal">
            <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Cá nhân
        </a>
        <a class="emp-tab" data-tab="tab-work" href="#tab-work">
            <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
            Công việc
        </a>
        <a class="emp-tab" data-tab="tab-contract" href="#tab-contract">
            <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            Hợp đồng
        </a>
        <a class="emp-tab" data-tab="tab-salary" href="#tab-salary">
            <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            Lương & Tài chính
        </a>
        <a class="emp-tab" data-tab="tab-education" href="#tab-education">
            <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
            Học vấn
        </a>
    </div>
</header>

{{-- Flash --}}
@if(session('success'))
<div hidden data-nova-toast-message="{{ session('success') }}" data-nova-toast-type="success"></div>
@endif

@if($errors->any())
<div style="padding:14px 24px 0">
    <div class="emp-alert emp-alert-danger">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <div>
            <div style="font-weight:700;margin-bottom:4px">Vui lòng kiểm tra lại:</div>
            <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:2px">
                @foreach($errors->all() as $err)
                    <li>• {{ $err }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

<form id="emp-edit-form" method="POST"
    action="{{ route('hr.employees.update', $employee) }}"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="emp-form-body">
        <div class="emp-form-main">
            @include('nova-employee::employee.partials.tabs_ce.tab-personal')
            @include('nova-employee::employee.partials.tabs_ce.tab-work')
            @include('nova-employee::employee.partials.tabs_ce.tab-contract')
            @include('nova-employee::employee.partials.tabs_ce.tab-salary')
            @include('nova-employee::employee.partials.tabs_ce.tab-education')
        </div>
        @include('nova-employee::employee.partials.sidebar')
    </div>
</form>
@include('nova-employee::employee.partials.tabs_si.modal_terminate')
@endsection

@push('scripts')
<script>
    window.EMP_DATA = {
        provincesNew:    @json($provincesNew),
        provincesOld:    @json($provincesOld),
        educationMajors: @json($educationMajors),
        universities:    @json($universities),
        educationLevels: @json($educationLevels),
    };
</script>
@endpush

