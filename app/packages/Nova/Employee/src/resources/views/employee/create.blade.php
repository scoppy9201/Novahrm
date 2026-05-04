@extends('nova-dashboard::layouts')

@section('title', 'Thêm nhân viên — NovaHRM')

@section('styles')
    @vite([
        'app/packages/Nova/Dashboard/src/resources/css/app.css',
        'app/packages/Nova/Employee/src/resources/css/app.css',
    ])
@endsection

@section('scripts')
    @vite([
        'app/packages/Nova/Dashboard/src/resources/js/app.js',
        'app/packages/Nova/Employee/src/resources/js/ce_app.js',
    ])
@endsection

@section('content')

<header class="emp-topbar">
    <div class="emp-topbar-row1">
        <div>
            <div class="emp-breadcrumb">
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <svg viewBox="0 0 24 24"><polyline points="7 8 12 13 17 8"/></svg>
                <a href="#">Nova HRM+</a>
                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                <a href="{{ route('hr.employees.index') }}">Nhân viên</a>
                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                <span>Thêm mới</span>
            </div>
            <div class="emp-page-title">Thêm nhân viên mới</div>
            <div class="emp-page-subtitle">Điền đầy đủ thông tin để tạo hồ sơ nhân viên</div>
        </div>
        <div class="emp-actions">
            <a href="{{ route('hr.employees.index') }}" class="btn-emp-secondary">
                <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Huỷ
            </a>
            <button type="submit" form="emp-create-form" class="btn-emp-primary">
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                Lưu nhân viên
            </button>
        </div>
    </div>

    {{-- Tab navigation --}}
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

{{-- Flash errors --}}
@if(session('error'))
<div hidden data-nova-toast-message="{{ session('error') }}" data-nova-toast-type="error"></div>
@endif

{{-- Flash success --}}
@if(session('success'))
<div hidden data-nova-toast-message="{{ session('success') }}" data-nova-toast-type="success"></div>
@endif

{{-- Validation errors từ Laravel Request --}}
@if($errors->any())
<div style="padding:14px 24px 0">
    <div class="emp-alert emp-alert-danger" data-auto-close>
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

<form id="emp-create-form" method="POST"
      action="{{ route('hr.employees.store') }}"
      enctype="multipart/form-data">
    @csrf

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
