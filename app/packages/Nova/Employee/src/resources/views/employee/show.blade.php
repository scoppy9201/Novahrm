@extends('nova-dashboard::layouts')

@section('title', $employee->name . ' — NovaHRM')

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

<div id="tab-overview" class="emp-tab-panel emp-show-body" style="display:grid">
    {{-- Sidebar --}}
    <div class="emp-show-side">
        {{-- Avatar card --}}
        <div class="emp-info-card">
            <div style="padding:24px 20px;display:flex;flex-direction:column;align-items:center;gap:10px;border-bottom:1px solid #f1f5f9">
                <div class="emp-avatar-lg">
                    @if($employee->avatar)
                        <img src="{{ $employee->avatar_url }}" alt="{{ $employee->name }}"/>
                    @else
                        {{ strtoupper(substr($employee->first_name,0,1).substr($employee->last_name,0,1)) }}
                    @endif
                </div>
                <div style="font-size:15px;font-weight:900;color:#0f172a;text-align:center">{{ $employee->name }}</div>
                <div style="font-size:11px;color:#2563eb;font-weight:700;text-align:center">
                    {{ $employee->position?->title ?? 'Chưa có vị trí' }}
                </div>
                <div style="font-size:10px;color:#94a3b8;font-weight:700;font-family:'Courier New',monospace;background:#f8fafc;padding:2px 10px;border-radius:5px;border:1px solid #e2e8f0">
                    {{ $employee->employee_code }}
                </div>
                <span class="emp-badge {{ $stClass }}">
                    <span class="emp-status-dot {{ $stDot }}"></span>
                    {{ \Nova\Auth\Models\Employee::STATUSES[$employee->status] ?? $employee->status }}
                </span>
            </div>

            {{-- Meta info --}}
            <div class="emp-info-list">
                @if($employee->department)
                <div class="emp-info-row">
                    <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    <div>
                        <div class="emp-info-label">Phòng ban</div>
                        <div class="emp-info-val">
                            <a href="{{ route('hr.departments.show', $employee->department) }}"
                               style="color:#1d4ed8;text-decoration:none;font-weight:700">
                                {{ $employee->department->name }}
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                @if($employee->manager)
                <div class="emp-info-row">
                    <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <div>
                        <div class="emp-info-label">Quản lý trực tiếp</div>
                        <div class="emp-info-val">
                            <a href="{{ route('hr.employees.show', $employee->manager) }}"
                               style="color:#1d4ed8;text-decoration:none;font-weight:700">
                                {{ $employee->manager->name }}
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                @if($employee->email || $employee->work_email)
                <div class="emp-info-row">
                    <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    <div>
                        <div class="emp-info-label">Email</div>
                        <div class="emp-info-val" style="font-size:11.5px">{{ $employee->work_email ?? $employee->email }}</div>
                    </div>
                </div>
                @endif

                @if($employee->phone)
                <div class="emp-info-row">
                    <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.58 3.32 2 2 0 0 1 3.55 1h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.91 8.54a16 16 0 0 0 6 6l.91-.91a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    <div>
                        <div class="emp-info-label">Điện thoại</div>
                        <div class="emp-info-val">{{ $employee->phone }}</div>
                    </div>
                </div>
                @endif

                @if($employee->hire_date)
                <div class="emp-info-row">
                    <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <div>
                        <div class="emp-info-label">Ngày vào làm</div>
                        <div class="emp-info-val">{{ $employee->hire_date->format('d/m/Y') }}</div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Stat cards --}}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
            <div class="emp-info-card" style="padding:14px;text-align:center">
                <div style="font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.07em;margin-bottom:6px">Thâm niên</div>
                <div style="font-size:16px;font-weight:900;color:#0f172a">{{ $employee->tenure ?? '—' }}</div>
            </div>
            <div class="emp-info-card" style="padding:14px;text-align:center">
                <div style="font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.07em;margin-bottom:6px">Tuổi</div>
                <div style="font-size:16px;font-weight:900;color:#0f172a">{{ $employee->age ? $employee->age . ' tuổi' : '—' }}</div>
            </div>
        </div>

        {{-- Cảnh báo --}}
        @if($employee->is_contract_expiring)
        <div class="emp-alert emp-alert-danger">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <div>
                <div style="font-weight:700;font-size:12px">HĐ sắp hết hạn</div>
                <div style="font-size:11px;margin-top:2px">{{ $employee->contract_end_date->format('d/m/Y') }}</div>
            </div>
        </div>
        @endif

        @if($employee->is_probation_ending)
        <div class="emp-alert emp-alert-warning">
            <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            <div>
                <div style="font-weight:700;font-size:12px">Thử việc sắp kết thúc</div>
                <div style="font-size:11px;margin-top:2px">{{ $employee->probation_end_date->format('d/m/Y') }}</div>
            </div>
        </div>
        @endif
    </div>

    {{-- Main --}}
    <div class="emp-show-main">
        {{-- Thông tin công việc --}}
        <div class="emp-info-card">
            <div class="emp-info-card-head">
                <div class="emp-info-card-title">Thông tin công việc</div>
            </div>
            <div style="padding:16px 18px;display:grid;grid-template-columns:1fr 1fr;gap:16px">

                <div>
                    <div class="emp-info-label">Loại nhân viên</div>
                    <div class="emp-info-val" style="margin-top:4px">
                        <span class="emp-badge emp-badge-blue">
                            {{ \Nova\Auth\Models\Employee::EMPLOYMENT_TYPES[$employee->employment_type] ?? '—' }}
                        </span>
                    </div>
                </div>

                <div>
                    <div class="emp-info-label">Ngày vào làm</div>
                    <div class="emp-info-val" style="margin-top:4px">
                        {{ $employee->hire_date?->format('d/m/Y') ?? '—' }}
                    </div>
                </div>

                @if($employee->probation_start_date || $employee->probation_end_date)
                <div>
                    <div class="emp-info-label">Thời gian thử việc</div>
                    <div class="emp-info-val" style="margin-top:4px">
                        {{ $employee->probation_start_date?->format('d/m/Y') ?? '?' }}
                        →
                        {{ $employee->probation_end_date?->format('d/m/Y') ?? '?' }}
                    </div>
                </div>
                @endif

                @if($employee->official_start_date)
                <div>
                    <div class="emp-info-label">Ngày chính thức</div>
                    <div class="emp-info-val" style="margin-top:4px">{{ $employee->official_start_date->format('d/m/Y') }}</div>
                </div>
                @endif

                @if($employee->basic_salary)
                <div>
                    <div class="emp-info-label">Lương cơ bản</div>
                    <div class="emp-info-val" style="margin-top:4px;font-weight:800;color:#1d4ed8">
                        {{ number_format($employee->basic_salary) }} ₫
                        <span style="font-size:10.5px;color:#94a3b8;font-weight:500">
                            / {{ match($employee->salary_type) { 'daily' => 'ngày', 'hourly' => 'giờ', default => 'tháng' } }}
                        </span>
                    </div>
                </div>
                @endif

                @if(!$employee->is_active && $employee->termination_date)
                <div class="emp-col-full" style="grid-column:1/-1;padding-top:12px;border-top:1px solid #f1f5f9;margin-top:4px">
                    <div class="emp-info-label" style="color:#dc2626">Thông tin nghỉ việc</div>
                    <div style="margin-top:8px;display:flex;gap:16px;flex-wrap:wrap">
                        <div>
                            <div class="emp-info-label">Ngày nghỉ</div>
                            <div class="emp-info-val">{{ $employee->termination_date->format('d/m/Y') }}</div>
                        </div>
                        @if($employee->termination_type)
                        <div>
                            <div class="emp-info-label">Loại</div>
                            <div class="emp-info-val">
                                {{ \Nova\Auth\Models\Employee::TERMINATION_TYPES[$employee->termination_type] ?? $employee->termination_type }}
                            </div>
                        </div>
                        @endif
                        @if($employee->termination_reason)
                        <div style="flex:1;min-width:200px">
                            <div class="emp-info-label">Lý do</div>
                            <div class="emp-info-val">{{ $employee->termination_reason }}</div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Hợp đồng --}}
        @if($employee->contract_type || $employee->contract_number)
        <div class="emp-info-card">
            <div class="emp-info-card-head">
                <div class="emp-info-card-title">Hợp đồng hiện tại</div>
                <a href="#tab-contract" data-goto-tab="tab-contract"
                   style="font-size:11.5px;font-weight:700;color:#1d4ed8;text-decoration:none">
                    Chi tiết →
                </a>
            </div>
            <div style="padding:16px 18px;display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px">

                <div>
                    <div class="emp-info-label">Loại HĐ</div>
                    <div class="emp-info-val" style="margin-top:4px">
                        <span class="emp-badge emp-badge-purple">
                            {{ \Nova\Auth\Models\Employee::CONTRACT_TYPES[$employee->contract_type] ?? '—' }}
                        </span>
                    </div>
                </div>

                @if($employee->contract_number)
                <div>
                    <div class="emp-info-label">Số HĐ</div>
                    <div class="emp-info-val" style="margin-top:4px;font-family:'Courier New',monospace">
                        {{ $employee->contract_number }}
                    </div>
                </div>
                @endif

                @if($employee->contract_start_date || $employee->contract_end_date)
                <div>
                    <div class="emp-info-label">Thời hạn</div>
                    <div class="emp-info-val" style="margin-top:4px">
                        {{ $employee->contract_start_date?->format('d/m/Y') ?? '?' }}
                        →
                        {{ $employee->contract_end_date?->format('d/m/Y') ?? 'Không xác định' }}
                    </div>
                </div>
                @endif
            </div>

            {{-- Progress bar thời gian HĐ --}}
            @if($employee->contract_start_date && $employee->contract_end_date)
                @php
                    $totalDays   = $employee->contract_start_date->diffInDays($employee->contract_end_date);
                    $passedDays  = $employee->contract_start_date->diffInDays(now());
                    $pct         = $totalDays > 0 ? min(100, round($passedDays / $totalDays * 100)) : 0;
                    $remaining   = max(0, now()->diffInDays($employee->contract_end_date, false));
                    $barColor    = $pct >= 90 ? '#ef4444' : ($pct >= 70 ? '#f59e0b' : '#3b82f6');
                @endphp
                <div style="padding:0 18px 16px">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px">
                        <span style="font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.07em">
                            Tiến độ hợp đồng
                        </span>
                        <span style="font-size:12px;font-weight:800;color:{{ $barColor }}">{{ $pct }}%</span>
                    </div>
                    <div style="height:6px;background:#f1f5f9;border-radius:99px;overflow:hidden">
                        <div style="height:100%;width:{{ $pct }}%;background:{{ $barColor }};border-radius:99px;transition:width 0.3s"></div>
                    </div>
                    <div style="display:flex;justify-content:space-between;margin-top:5px">
                        <span style="font-size:11px;color:#94a3b8;font-weight:500">{{ $passedDays }} ngày đã qua</span>
                        @if($remaining > 0)
                            <span style="font-size:11px;font-weight:700;color:{{ $barColor }}">Còn {{ $remaining }} ngày</span>
                        @else
                            <span style="font-size:11px;font-weight:700;color:#dc2626">Đã hết hạn</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
        @endif

        {{-- Bio / Ghi chú --}}
        @if($employee->bio)
        <div class="emp-info-card">
            <div class="emp-info-card-head">
                <div class="emp-info-card-title">Giới thiệu</div>
            </div>
            <div style="padding:14px 18px;font-size:13px;color:#334155;line-height:1.75;white-space:pre-line">
                {{ $employee->bio }}
            </div>
        </div>
        @endif
    </div>
</div>

<div id="tab-personal" class="emp-tab-panel" style="display:none">
    <div style="padding:22px 24px;display:flex;flex-direction:column;gap:14px">

        {{-- Thông tin cơ bản --}}
        <div class="emp-info-card">
            <div class="emp-info-card-head">
                <div class="emp-info-card-title">Thông tin cơ bản</div>
            </div>
            <div style="padding:16px 18px;display:grid;grid-template-columns:repeat(3,1fr);gap:16px">

                <div>
                    <div class="emp-info-label">Họ và tên</div>
                    <div class="emp-info-val" style="margin-top:3px">{{ $employee->name }}</div>
                </div>
                <div>
                    <div class="emp-info-label">Giới tính</div>
                    <div class="emp-info-val" style="margin-top:3px">
                        {{ \Nova\Auth\Models\Employee::GENDERS[$employee->gender] ?? '—' }}
                    </div>
                </div>
                <div>
                    <div class="emp-info-label">Ngày sinh</div>
                    <div class="emp-info-val" style="margin-top:3px">
                        {{ $employee->date_of_birth?->format('d/m/Y') ?? '—' }}
                        @if($employee->age) <span style="color:#94a3b8;font-size:11px">({{ $employee->age }} tuổi)</span> @endif
                    </div>
                </div>
                <div>
                    <div class="emp-info-label">Nơi sinh</div>
                    <div class="emp-info-val" style="margin-top:3px">{{ $employee->place_of_birth ?? '—' }}</div>
                </div>
                <div>
                    <div class="emp-info-label">Quốc tịch</div>
                    <div class="emp-info-val" style="margin-top:3px">{{ $employee->nationality ?? '—' }}</div>
                </div>
                <div>
                    <div class="emp-info-label">Dân tộc</div>
                    <div class="emp-info-val" style="margin-top:3px">{{ $employee->ethnicity ?? '—' }}</div>
                </div>
                <div>
                    <div class="emp-info-label">Tôn giáo</div>
                    <div class="emp-info-val" style="margin-top:3px">{{ $employee->religion ?? '—' }}</div>
                </div>
            </div>
        </div>

        {{-- CCCD / Hộ chiếu --}}
        <div class="emp-info-card">
            <div class="emp-info-card-head">
                <div class="emp-info-card-title">CCCD / Hộ chiếu</div>
            </div>
            <div style="padding:16px 18px;display:grid;grid-template-columns:repeat(3,1fr);gap:16px">
                <div>
                    <div class="emp-info-label">Số CCCD/CMND</div>
                    <div class="emp-info-val" style="margin-top:3px;font-family:'Courier New',monospace">{{ $employee->national_id ?? '—' }}</div>
                </div>
                <div>
                    <div class="emp-info-label">Ngày cấp</div>
                    <div class="emp-info-val" style="margin-top:3px">{{ $employee->national_id_issued_date?->format('d/m/Y') ?? '—' }}</div>
                </div>
                <div>
                    <div class="emp-info-label">Nơi cấp</div>
                    <div class="emp-info-val" style="margin-top:3px">{{ $employee->national_id_issued_place ?? '—' }}</div>
                </div>
                @if($employee->passport_number)
                <div>
                    <div class="emp-info-label">Số hộ chiếu</div>
                    <div class="emp-info-val" style="margin-top:3px;font-family:'Courier New',monospace">{{ $employee->passport_number }}</div>
                </div>
                <div>
                    <div class="emp-info-label">Hết hạn hộ chiếu</div>
                    <div class="emp-info-val" style="margin-top:3px">{{ $employee->passport_expiry_date?->format('d/m/Y') ?? '—' }}</div>
                </div>
                @endif
            </div>
        </div>

        {{-- Địa chỉ --}}
        <div class="emp-info-card">
            <div class="emp-info-card-head">
                <div class="emp-info-card-title">Địa chỉ</div>
            </div>
            <div style="padding:16px 18px;display:grid;grid-template-columns:1fr 1fr;gap:20px">
                <div>
                    <div class="emp-info-label" style="margin-bottom:8px">Địa chỉ thường trú</div>
                    <div class="emp-info-val">{{ $employee->permanent_address ?? '—' }}</div>
                    @if($employee->permanent_ward || $employee->permanent_district)
                        <div style="font-size:11.5px;color:#64748b;margin-top:3px">
                            {{ collect([$employee->permanent_ward, $employee->permanent_district, $employee->permanent_province])->filter()->join(', ') }}
                        </div>
                    @endif
                </div>
                <div>
                    <div class="emp-info-label" style="margin-bottom:8px">Địa chỉ hiện tại</div>
                    <div class="emp-info-val">{{ $employee->current_address ?? '—' }}</div>
                    @if($employee->current_ward || $employee->current_district)
                        <div style="font-size:11.5px;color:#64748b;margin-top:3px">
                            {{ collect([$employee->current_ward, $employee->current_district, $employee->current_province])->filter()->join(', ') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Liên hệ & Khẩn cấp --}}
        <div class="emp-info-card">
            <div class="emp-info-card-head">
                <div class="emp-info-card-title">Liên hệ khẩn cấp</div>
            </div>
            <div style="padding:16px 18px;display:grid;grid-template-columns:repeat(3,1fr);gap:16px">
                <div>
                    <div class="emp-info-label">Họ tên</div>
                    <div class="emp-info-val" style="margin-top:3px">{{ $employee->emergency_contact_name ?? '—' }}</div>
                </div>
                <div>
                    <div class="emp-info-label">Số điện thoại</div>
                    <div class="emp-info-val" style="margin-top:3px">{{ $employee->emergency_contact_phone ?? '—' }}</div>
                </div>
                <div>
                    <div class="emp-info-label">Quan hệ</div>
                    <div class="emp-info-val" style="margin-top:3px">{{ $employee->emergency_contact_relation ?? '—' }}</div>
                </div>
            </div>
        </div>

        {{-- Học vấn --}}
        @if($employee->education_level || $employee->education_school)
        <div class="emp-info-card">
            <div class="emp-info-card-head">
                <div class="emp-info-card-title">Học vấn</div>
            </div>
            <div style="padding:16px 18px;display:grid;grid-template-columns:repeat(3,1fr);gap:16px">
                <div>
                    <div class="emp-info-label">Trình độ</div>
                    <div class="emp-info-val" style="margin-top:3px">
                        {{ \Nova\Auth\Models\Employee::EDUCATION_LEVELS[$employee->education_level] ?? '—' }}
                    </div>
                </div>
                <div>
                    <div class="emp-info-label">Chuyên ngành</div>
                    <div class="emp-info-val" style="margin-top:3px">{{ $employee->education_major ?? '—' }}</div>
                </div>
                <div>
                    <div class="emp-info-label">Trường</div>
                    <div class="emp-info-val" style="margin-top:3px">{{ $employee->education_school ?? '—' }}</div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<div id="tab-contract" class="emp-tab-panel" style="display:none">
    <div style="padding:22px 24px;display:flex;flex-direction:column;gap:14px">

        <div class="emp-info-card">
            <div class="emp-info-card-head">
                <div class="emp-info-card-title">Chi tiết hợp đồng</div>
                <a href="{{ route('hr.employees.edit', $employee) }}#tab-contract"
                   class="btn-emp-secondary" style="font-size:11px;padding:5px 12px">
                    Chỉnh sửa
                </a>
            </div>
            <div style="padding:16px 18px;display:grid;grid-template-columns:repeat(3,1fr);gap:16px">

                <div>
                    <div class="emp-info-label">Loại hợp đồng</div>
                    <div class="emp-info-val" style="margin-top:4px">
                        @if($employee->contract_type)
                            <span class="emp-badge emp-badge-purple">
                                {{ \Nova\Auth\Models\Employee::CONTRACT_TYPES[$employee->contract_type] ?? $employee->contract_type }}
                            </span>
                        @else
                            <span style="color:#94a3b8">Chưa có</span>
                        @endif
                    </div>
                </div>

                <div>
                    <div class="emp-info-label">Số hợp đồng</div>
                    <div class="emp-info-val" style="margin-top:4px;font-family:'Courier New',monospace">
                        {{ $employee->contract_number ?? '—' }}
                    </div>
                </div>

                <div>
                    <div class="emp-info-label">Số lần gia hạn</div>
                    <div class="emp-info-val" style="margin-top:4px">{{ $employee->contract_renewal_count ?? 0 }} lần</div>
                </div>

                <div>
                    <div class="emp-info-label">Ngày bắt đầu</div>
                    <div class="emp-info-val" style="margin-top:4px">{{ $employee->contract_start_date?->format('d/m/Y') ?? '—' }}</div>
                </div>

                <div>
                    <div class="emp-info-label">Ngày kết thúc</div>
                    <div class="emp-info-val" style="margin-top:4px">
                        {{ $employee->contract_end_date?->format('d/m/Y') ?? 'Không xác định' }}
                        @if($employee->is_contract_expiring)
                            <div style="margin-top:4px">
                                <span class="emp-badge emp-badge-danger" style="font-size:10px">
                                    Hết hạn {{ $employee->contract_end_date->diffForHumans() }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Lương & Tài chính --}}
        <div class="emp-info-card">
            <div class="emp-info-card-head">
                <div class="emp-info-card-title">Lương & Tài chính</div>
            </div>
            <div style="padding:16px 18px;display:grid;grid-template-columns:repeat(3,1fr);gap:16px">

                <div style="grid-column:1/-1;padding:14px;background:#eff6ff;border-radius:10px;border:1px solid #dbeafe;text-align:center">
                    <div style="font-size:10px;font-weight:700;color:#1d4ed8;text-transform:uppercase;letter-spacing:0.07em;margin-bottom:4px">Lương cơ bản</div>
                    <div style="font-size:22px;font-weight:900;color:#1d4ed8">
                        {{ $employee->basic_salary ? number_format($employee->basic_salary) . ' ₫' : '—' }}
                    </div>
                    <div style="font-size:11px;color:#93c5fd;margin-top:2px">
                        / {{ match($employee->salary_type ?? 'monthly') { 'daily' => 'ngày', 'hourly' => 'giờ', default => 'tháng' } }}
                    </div>
                </div>

                <div>
                    <div class="emp-info-label">Ngân hàng</div>
                    <div class="emp-info-val" style="margin-top:3px">{{ $employee->bank_name ?? '—' }}</div>
                </div>
                <div>
                    <div class="emp-info-label">Số tài khoản</div>
                    <div class="emp-info-val" style="margin-top:3px;font-family:'Courier New',monospace">{{ $employee->bank_account ?? '—' }}</div>
                </div>
                <div>
                    <div class="emp-info-label">Tên chủ TK</div>
                    <div class="emp-info-val" style="margin-top:3px">{{ $employee->bank_account_name ?? '—' }}</div>
                </div>
                <div>
                    <div class="emp-info-label">Mã số thuế</div>
                    <div class="emp-info-val" style="margin-top:3px;font-family:'Courier New',monospace">{{ $employee->tax_code ?? '—' }}</div>
                </div>
                <div>
                    <div class="emp-info-label">Mã BHXH</div>
                    <div class="emp-info-val" style="margin-top:3px;font-family:'Courier New',monospace">{{ $employee->social_insurance_code ?? '—' }}</div>
                </div>
                <div>
                    <div class="emp-info-label">Mã BHYT</div>
                    <div class="emp-info-val" style="margin-top:3px;font-family:'Courier New',monospace">{{ $employee->health_insurance_code ?? '—' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="tab-documents" class="emp-tab-panel" style="display:none">
    <div style="padding:22px 24px;display:flex;flex-direction:column;gap:14px">

        <div class="emp-info-card">
            <div class="emp-info-card-head">
                <div class="emp-info-card-title">Tài liệu đính kèm</div>
            </div>

            @if(!$employee->cv_path && !$employee->signature_path && !$employee->avatar)
                <div class="emp-empty">
                    <div class="emp-empty-icon">
                        <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    </div>
                    <div class="emp-empty-title">Chưa có tài liệu</div>
                    <div class="emp-empty-desc">Tải lên CV, chữ ký trong trang chỉnh sửa</div>
                    <a href="{{ route('hr.employees.edit', $employee) }}" class="btn-emp-secondary" style="margin-top:8px">
                        Thêm tài liệu
                    </a>
                </div>
            @else
                <div style="padding:16px 18px;display:flex;flex-direction:column;gap:12px">

                    @if($employee->cv_path)
                    <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 14px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px">
                        <div style="display:flex;align-items:center;gap:10px">
                            <div style="width:36px;height:36px;border-radius:8px;background:#eff6ff;display:flex;align-items:center;justify-content:center">
                                <svg viewBox="0 0 24 24" style="width:18px;height:18px;stroke:#1d4ed8;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>
                                </svg>
                            </div>
                            <div>
                                <div style="font-size:12.5px;font-weight:700;color:#0f172a">CV / Hồ sơ</div>
                                <div style="font-size:11px;color:#94a3b8">{{ basename($employee->cv_path) }}</div>
                            </div>
                        </div>
                        <a href="{{ asset('storage/'.$employee->cv_path) }}" target="_blank" class="btn-emp-secondary" style="font-size:11px;padding:5px 12px">
                            Tải xuống
                        </a>
                    </div>
                    @endif

                    @if($employee->signature_path)
                    <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 14px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px">
                        <div style="display:flex;align-items:center;gap:10px">
                            <div style="width:36px;height:36px;border-radius:8px;background:#f5f3ff;display:flex;align-items:center;justify-content:center">
                                <svg viewBox="0 0 24 24" style="width:18px;height:18px;stroke:#7c3aed;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round">
                                    <path d="M12 19l7-7 3 3-7 7-3-3z"/><path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"/>
                                </svg>
                            </div>
                            <div>
                                <div style="font-size:12.5px;font-weight:700;color:#0f172a">Chữ ký</div>
                                <div>
                                    <img src="{{ asset('storage/'.$employee->signature_path) }}"
                                         style="height:32px;margin-top:4px;border:1px solid #e2e8f0;border-radius:4px;padding:2px"/>
                                </div>
                            </div>
                        </div>
                        <a href="{{ asset('storage/'.$employee->signature_path) }}" target="_blank" class="btn-emp-secondary" style="font-size:11px;padding:5px 12px">
                            Xem
                        </a>
                    </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<div id="tab-subordinates" class="emp-tab-panel" style="display:none">
    <div style="padding:22px 24px">
        <div class="emp-info-card">
            <div class="emp-info-card-head">
                <div class="emp-info-card-title">
                    Nhân viên cấp dưới
                    <span class="emp-table-count" style="margin-left:6px">{{ $employee->subordinates->count() }} người</span>
                </div>
            </div>

            @if($employee->subordinates->isEmpty())
                <div class="emp-empty">
                    <div class="emp-empty-icon">
                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div class="emp-empty-title">Chưa có cấp dưới</div>
                    <div class="emp-empty-desc">Nhân viên này chưa quản lý ai</div>
                </div>
            @else
                <table class="emp-table">
                    <thead>
                        <tr>
                            <th>Nhân viên</th>
                            <th>Phòng ban</th>
                            <th>Vị trí</th>
                            <th>Ngày vào làm</th>
                            <th>Trạng thái</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employee->subordinates as $sub)
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px">
                                    <div class="emp-avatar">
                                        @if($sub->avatar)
                                            <img src="{{ $sub->avatar_url }}" alt="{{ $sub->name }}"/>
                                        @else
                                            {{ strtoupper(substr($sub->first_name,0,1).substr($sub->last_name,0,1)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <div class="emp-table-name">{{ $sub->name }}</div>
                                        <div class="emp-table-code">{{ $sub->employee_code }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="font-size:12.5px;color:#334155;font-weight:600">{{ $sub->department?->name ?? '—' }}</td>
                            <td style="font-size:12.5px;color:#334155">{{ $sub->position?->title ?? '—' }}</td>
                            <td style="font-size:12.5px;color:#475569">{{ $sub->hire_date?->format('d/m/Y') ?? '—' }}</td>
                            <td>
                                @php
                                    $subStClass = match($sub->status) {
                                        'active'    => 'emp-badge-active',
                                        'probation' => 'emp-badge-probation',
                                        default     => 'emp-badge-inactive',
                                    };
                                @endphp
                                <span class="emp-badge {{ $subStClass }}">
                                    <span class="emp-status-dot {{ $sub->is_active ? 'active' : 'inactive' }}"></span>
                                    {{ \Nova\Auth\Models\Employee::STATUSES[$sub->status] ?? $sub->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('hr.employees.show', $sub) }}" class="btn-emp-icon" title="Xem">
                                    <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>

<div class="emp-modal-overlay" id="terminate-modal">
    <div class="emp-modal">
        <div class="emp-modal-header">
            <div class="emp-modal-title">Xác nhận nghỉ việc — {{ $employee->name }}</div>
            <button type="button" class="emp-modal-close" id="close-terminate">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('hr.employees.terminate', $employee) }}">
            @csrf
            <div class="emp-modal-body">
                <div class="emp-alert emp-alert-warning">
                    <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    Hành động này sẽ đánh dấu nhân viên là đã nghỉ việc.
                </div>
                <div class="emp-form-group">
                    <label class="emp-form-label">Loại nghỉ việc <span class="required">*</span></label>
                    <select name="status" class="emp-select" required>
                        <option value="resigned">Tự nghỉ việc</option>
                        <option value="terminated">Bị sa thải</option>
                        <option value="retired">Nghỉ hưu</option>
                        <option value="deceased">Qua đời</option>
                    </select>
                </div>
                <div class="emp-form-group">
                    <label class="emp-form-label">Loại hình chấm dứt <span class="required">*</span></label>
                    <select name="termination_type" class="emp-select" required>
                        @foreach(\Nova\Auth\Models\Employee::TERMINATION_TYPES as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="emp-form-group">
                    <label class="emp-form-label">Ngày nghỉ việc <span class="required">*</span></label>
                    <input type="date" name="termination_date" class="emp-input"
                           value="{{ now()->format('Y-m-d') }}" required/>
                </div>
                <div class="emp-form-group">
                    <label class="emp-form-label">Lý do</label>
                    <textarea name="termination_reason" class="emp-textarea" rows="3"
                              placeholder="Mô tả lý do nghỉ việc..."></textarea>
                </div>
            </div>
            <div class="emp-modal-footer">
                <button type="button" class="btn-emp-secondary" id="cancel-terminate">Huỷ</button>
                <button type="submit" class="btn-emp-danger">
                    <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Xác nhận nghỉ việc
                </button>
            </div>
        </form>
    </div>
</div>

<div class="emp-modal-overlay" id="transfer-modal">
    <div class="emp-modal">
        <div class="emp-modal-header">
            <div class="emp-modal-title">Chuyển phòng / Đổi vị trí</div>
            <button type="button" class="emp-modal-close" id="close-transfer">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('hr.employees.transfer', $employee) }}">
            @csrf
            <div class="emp-modal-body">
                <div class="emp-form-group">
                    <label class="emp-form-label">Phòng ban mới</label>
                    <select name="department_id" class="emp-select">
                        <option value="">— Giữ nguyên —</option>
                        @foreach($departments ?? [] as $dept)
                            <option value="{{ $dept->id }}" {{ $employee->department_id == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="emp-form-group">
                    <label class="emp-form-label">Vị trí mới</label>
                    <select name="position_id" class="emp-select">
                        <option value="">— Giữ nguyên —</option>
                        @foreach($positions ?? [] as $pos)
                            <option value="{{ $pos->id }}" {{ $employee->position_id == $pos->id ? 'selected' : '' }}>
                                {{ $pos->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="emp-form-group">
                    <label class="emp-form-label">Quản lý mới</label>
                    <div class="emp-autocomplete">
                        <input type="text" id="transfer-manager-search" class="emp-input"
                               value="{{ $employee->manager?->name }}"
                               placeholder="Tìm quản lý..." autocomplete="off"/>
                        <input type="hidden" name="manager_id" id="transfer-manager-id"
                               value="{{ $employee->manager_id }}"/>
                        <div class="emp-autocomplete-dropdown" id="transfer-manager-dropdown"></div>
                    </div>
                </div>
            </div>
            <div class="emp-modal-footer">
                <button type="button" class="btn-emp-secondary" id="cancel-transfer">Huỷ</button>
                <button type="submit" class="btn-emp-primary">
                    <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/></svg>
                    Xác nhận chuyển
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
    @vite(['app/packages/Nova/Employee/src/resources/js/app.js'])
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        // Tab switching 
        const tabs   = document.querySelectorAll('.emp-tab[data-tab]');
        const panels = document.querySelectorAll('.emp-tab-panel');

        function switchTab(tabId) {
            tabs.forEach(t => t.classList.toggle('active', t.dataset.tab === tabId));
            panels.forEach(p => {
                if (p.id === tabId) {
                    p.style.display = p.id === 'tab-overview' ? 'grid' : 'block';
                } else {
                    p.style.display = 'none';
                }
            });
        }

        tabs.forEach(tab => tab.addEventListener('click', e => {
            e.preventDefault();
            switchTab(tab.dataset.tab);
        }));

        document.querySelectorAll('[data-goto-tab]').forEach(el => {
            el.addEventListener('click', e => {
                e.preventDefault();
                switchTab(el.dataset.gotoTab);
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });

        const hash = location.hash.replace('#', '');
        if (hash && document.getElementById(hash)) switchTab(hash);
        else switchTab('tab-overview');

        // Terminate modal 
        const terminateModal = document.getElementById('terminate-modal');
        document.getElementById('btn-terminate')?.addEventListener('click',   () => terminateModal.classList.add('open'));
        document.getElementById('close-terminate')?.addEventListener('click', () => terminateModal.classList.remove('open'));
        document.getElementById('cancel-terminate')?.addEventListener('click',() => terminateModal.classList.remove('open'));

        // ransfer modal 
        const transferModal = document.getElementById('transfer-modal');
        document.getElementById('btn-transfer')?.addEventListener('click',   () => transferModal.classList.add('open'));
        document.getElementById('close-transfer')?.addEventListener('click', () => transferModal.classList.remove('open'));
        document.getElementById('cancel-transfer')?.addEventListener('click',() => transferModal.classList.remove('open'));

        // Đóng modal khi click overlay
        [terminateModal, transferModal].forEach(modal => {
            modal?.addEventListener('click', e => {
                if (e.target === modal) modal.classList.remove('open');
            });
        });

        // Autocomplete transfer manager
        const tSearch   = document.getElementById('transfer-manager-search');
        const tIdInput  = document.getElementById('transfer-manager-id');
        const tDropdown = document.getElementById('transfer-manager-dropdown');
        let tTimer;

        tSearch?.addEventListener('input', function () {
            const q = this.value.trim();
            if (q.length < 2) { tDropdown.classList.remove('open'); return; }
            clearTimeout(tTimer);
            tTimer = setTimeout(async () => {
                try {
                    const res  = await fetch(`{{ route('hr.employees.search') }}?q=${encodeURIComponent(q)}`);
                    const data = await res.json();
                    tDropdown.innerHTML = data.length
                        ? data.map(e => `
                            <div class="emp-autocomplete-item" data-id="${e.id}" data-name="${e.name}">
                                <img src="${e.avatar}" style="width:28px;height:28px;border-radius:50%;object-fit:cover;flex-shrink:0" onerror="this.style.display='none'"/>
                                <div>
                                    <div class="emp-autocomplete-item-name">${e.name}</div>
                                    <div class="emp-autocomplete-item-sub">${e.position || ''} ${e.department ? '· '+e.department : ''}</div>
                                </div>
                            </div>`).join('')
                        : `<div style="padding:12px;font-size:12px;color:#94a3b8">Không tìm thấy</div>`;
                    tDropdown.classList.add('open');
                    tDropdown.querySelectorAll('.emp-autocomplete-item').forEach(item => {
                        item.addEventListener('click', () => {
                            tSearch.value  = item.dataset.name;
                            tIdInput.value = item.dataset.id;
                            tDropdown.classList.remove('open');
                        });
                    });
                } catch(e) { console.error(e); }
            }, 300);
        });

        document.addEventListener('click', e => {
            if (!e.target.closest('.emp-autocomplete')) {
                tDropdown?.classList.remove('open');
            }
        });

        //  Flash auto close 
        document.querySelectorAll('[data-auto-close]').forEach(el => {
            setTimeout(() => {
                el.style.transition = 'opacity 0.4s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 400);
            }, 4000);
        });
    });
    </script>
@endsection