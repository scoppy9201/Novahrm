@extends('nova-dashboard::layouts')

@section('title', $department->name . ' — NovaHRM')

@section('styles')
    @vite([
        'app/packages/Nova/Dashboard/src/resources/css/app.css',
        'app/packages/Nova/Department/src/resources/css/app.css',
    ])
@endsection

@section('content')
    <header class="dept-topbar">
        <div class="dept-topbar-row1">
            <div>
                <div class="dept-breadcrumb">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    <a href="{{ route('hr.departments.index') }}">Phòng ban</a>
                    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    <span>{{ $department->name }}</span>
                </div>
                <div style="display:flex;align-items:center;gap:10px">
                    @if($department->color)
                        <span style="width:14px;height:14px;border-radius:50%;background:{{ $department->color }};flex-shrink:0;display:inline-block;box-shadow:0 0 0 3px {{ $department->color }}22"></span>
                    @endif
                    <div class="dept-page-title">{{ $department->name }}</div>
                    <span class="dept-table-code">{{ $department->code }}</span>
                    <span class="dept-badge {{ $department->status === 'active' ? 'dept-badge-active' : 'dept-badge-inactive' }}">
                        <span class="dept-status-dot {{ $department->status }}"></span>
                        {{ $department->status === 'active' ? 'Hoạt động' : 'Không hoạt động' }}
                    </span>
                </div>
                @if($department->description)
                    <div class="dept-page-subtitle" style="margin-top:4px;max-width:500px">{{ $department->description }}</div>
                @endif
            </div>
            <div class="dept-actions">
                <a href="{{ route('hr.departments.index') }}" class="btn-dept-secondary">
                    <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    Quay lại
                </a>
                <a href="{{ route('hr.departments.edit', $department) }}" class="btn-dept-primary">
                    <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Chỉnh sửa
                </a>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="dept-tabs">
            <a class="dept-tab active" data-tab="tab-overview" href="#tab-overview">Tổng quan</a>
            <a class="dept-tab" data-tab="tab-employees" href="#tab-employees">
                Nhân sự
                <span class="dept-badge dept-badge-blue" style="margin-left:6px;padding:1px 7px">{{ $department->employees->count() }}</span>
            </a>
            <a class="dept-tab" data-tab="tab-positions" href="#tab-positions">
                Vị trí
                <span class="dept-badge dept-badge-gray" style="margin-left:6px;padding:1px 7px">{{ $department->positions->count() }}</span>
            </a>
            <a class="dept-tab" data-tab="tab-children" href="#tab-children">
                Phòng ban con
                <span class="dept-badge dept-badge-gray" style="margin-left:6px;padding:1px 7px">{{ $department->children->count() }}</span>
            </a>
        </div>
    </header>

    {{-- Flash --}}
    @if(session('success'))
        <div style="padding:14px 24px 0">
            <div class="dept-alert dept-alert-success" data-auto-close>
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    {{-- Tab: Tổng quan --}}
    <div id="tab-overview" class="dept-tab-panel dept-show-body" style="display:grid">
        {{-- Sidebar trái --}}
        <div class="dept-show-side">

            {{-- Thông tin chung --}}
            <div class="dept-info-card">
                <div class="dept-info-card-head">
                    <div class="dept-info-card-title">Thông tin chung</div>
                </div>
                <div class="dept-info-list">
                    <div class="dept-info-row">
                        <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                        <div>
                            <div class="dept-info-label">Phòng ban cha</div>
                            <div class="dept-info-val">
                                @if($department->parent)
                                    <a href="{{ route('hr.departments.show', $department->parent) }}"
                                       style="color:#1d4ed8;text-decoration:none;font-weight:700">
                                        {{ $department->parent->name }}
                                    </a>
                                @else
                                    <span style="color:#94a3b8">Cấp gốc</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="dept-info-row">
                        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <div>
                            <div class="dept-info-label">Trưởng phòng</div>
                            <div class="dept-info-val">
                                @if($department->manager)
                                    <div style="display:flex;align-items:center;gap:8px;margin-top:2px">
                                        <div class="dept-avatar" style="width:28px;height:28px;font-size:10px">
                                            @if($department->manager->avatar)
                                                <img src="{{ $department->manager->avatar_url }}" alt="">
                                            @else
                                                {{ strtoupper(substr($department->manager->first_name,0,1).substr($department->manager->last_name,0,1)) }}
                                            @endif
                                        </div>
                                        <span>{{ $department->manager->name }}</span>
                                    </div>
                                @else
                                    <span style="color:#94a3b8">Chưa xác định</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="dept-info-row">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M12 1v4M12 19v4M4.22 4.22l2.83 2.83M16.95 16.95l2.83 2.83M1 12h4M19 12h4M4.22 19.78l2.83-2.83M16.95 7.05l2.83-2.83"/></svg>
                        <div>
                            <div class="dept-info-label">Màu nhận diện</div>
                            <div class="dept-info-val" style="display:flex;align-items:center;gap:8px;margin-top:2px">
                                @if($department->color)
                                    <span style="width:18px;height:18px;border-radius:5px;background:{{ $department->color }};display:inline-block;border:1px solid #e2e8f0"></span>
                                    <span style="font-family:'Courier New',monospace;font-size:12px">{{ $department->color }}</span>
                                @else
                                    <span style="color:#94a3b8">Chưa đặt</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="dept-info-row">
                        <svg viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                        <div>
                            <div class="dept-info-label">Thứ tự hiển thị</div>
                            <div class="dept-info-val">{{ $department->order ?? 0 }}</div>
                        </div>
                    </div>

                    <div class="dept-info-row">
                        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <div>
                            <div class="dept-info-label">Ngày tạo</div>
                            <div class="dept-info-val">{{ $department->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>

                    <div class="dept-info-row">
                        <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        <div>
                            <div class="dept-info-label">Cập nhật lần cuối</div>
                            <div class="dept-info-val">{{ $department->updated_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Stat nhanh --}}
            <div class="dept-stats-grid" style="grid-template-columns:1fr 1fr">
                <div class="dept-stat-card">
                    <div class="dept-stat-icon blue">
                        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <div class="dept-stat-label">Nhân sự</div>
                    <div class="dept-stat-value">{{ $department->employees->count() }}</div>
                </div>
                <div class="dept-stat-card">
                    <div class="dept-stat-icon purple">
                        <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    </div>
                    <div class="dept-stat-label">Vị trí</div>
                    <div class="dept-stat-value">{{ $department->positions->count() }}</div>
                </div>
                <div class="dept-stat-card">
                    <div class="dept-stat-icon green">
                        <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                    </div>
                    <div class="dept-stat-label">Phòng con</div>
                    <div class="dept-stat-value">{{ $department->children->count() }}</div>
                </div>
                <div class="dept-stat-card">
                    <div class="dept-stat-icon amber">
                        <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    </div>
                    <div class="dept-stat-label">Trạng thái</div>
                    <div class="dept-stat-value" style="font-size:13px;margin-top:2px">
                        <span class="dept-badge {{ $department->status === 'active' ? 'dept-badge-active' : 'dept-badge-inactive' }}">
                            {{ $department->status === 'active' ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main --}}
        <div class="dept-show-main">

            {{-- Nhân sự mới nhất (preview 5) --}}
            <div class="dept-info-card">
                <div class="dept-info-card-head">
                    <div class="dept-info-card-title">Nhân sự gần đây</div>
                    <a href="#tab-employees" class="dept-tab-link" data-goto-tab="tab-employees"
                    style="font-size:11.5px;font-weight:700;color:#1d4ed8;text-decoration:none;display:inline-flex;align-items:center;gap:4px">
                        Xem tất cả
                        <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:#1d4ed8;fill:none;stroke-width:2.5;stroke-linecap:round;stroke-linejoin:round">
                            <line x1="5" y1="12" x2="19" y2="12"/>
                            <polyline points="12 5 19 12 12 19"/>
                        </svg>
                    </a>
                </div>
                @if($department->employees->isEmpty())
                    <div class="dept-empty" style="padding:28px 24px">
                        <div class="dept-empty-icon">
                            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                        <div class="dept-empty-title">Chưa có nhân sự</div>
                        <div class="dept-empty-desc">Phòng ban này chưa có nhân viên nào</div>
                    </div>
                @else
                    @foreach($department->employees->take(5) as $emp)
                        <div class="dept-emp-row">
                            <div class="dept-avatar">
                                @if($emp->avatar)
                                    <img src="{{ $emp->avatar_url }}" alt="">
                                @else
                                    {{ strtoupper(substr($emp->first_name,0,1).substr($emp->last_name,0,1)) }}
                                @endif
                            </div>
                            <div class="dept-emp-info">
                                <div class="dept-emp-name">{{ $emp->name }}</div>
                                <div class="dept-emp-pos">{{ $emp->position?->title ?? 'Chưa có vị trí' }}</div>
                            </div>
                            <span class="dept-badge {{ $emp->is_active ? 'dept-badge-active' : 'dept-badge-gray' }}" style="font-size:10px">
                                {{ $emp->is_active ? 'Đang làm' : 'Nghỉ' }}
                            </span>
                        </div>
                    @endforeach
                    @if($department->employees->count() > 5)
                        <div style="padding:10px 18px;font-size:12px;color:#94a3b8;font-weight:600;border-top:1px solid #f8fafc;text-align:center">
                            và {{ $department->employees->count() - 5 }} nhân viên khác…
                        </div>
                    @endif
                @endif
            </div>

            {{-- Phòng ban con --}}
            @if($department->children->isNotEmpty())
                <div class="dept-info-card">
                    <div class="dept-info-card-head">
                        <div class="dept-info-card-title">Phòng ban con trực tiếp</div>
                        <span class="dept-badge dept-badge-gray">{{ $department->children->count() }}</span>
                    </div>
                    @foreach($department->children as $child)
                        <div class="dept-emp-row">
                            @if($child->color)
                                <span style="width:10px;height:10px;border-radius:50%;background:{{ $child->color }};flex-shrink:0;display:inline-block"></span>
                            @endif
                            <div class="dept-emp-info">
                                <div class="dept-emp-name">{{ $child->name }}</div>
                                <div class="dept-emp-pos">
                                    <span class="dept-table-code" style="font-size:10px">{{ $child->code }}</span>
                                    @if($child->manager)
                                        &nbsp;· Trưởng: {{ $child->manager->name }}
                                    @endif
                                </div>
                            </div>
                            <div style="display:flex;align-items:center;gap:6px">
                                <span class="dept-badge dept-badge-blue" style="font-size:10px">{{ $child->employee_count }} người</span>
                                <a href="{{ route('hr.departments.show', $child) }}" class="btn-dept-icon view">
                                    <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>

    {{-- Tab: Nhân sự --}}
    <div id="tab-employees" class="dept-tab-panel dept-body" style="display:none">
        <div class="dept-table-card">
            <div class="dept-table-header">
                <div>
                    <span class="dept-table-title">Danh sách nhân sự</span>
                    <span class="dept-table-count" style="margin-left:8px">{{ $department->employees->count() }} người</span>
                </div>
                <a href="#" class="btn-dept-primary" style="font-size:11.5px;padding:6px 13px">
                    <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Thêm nhân viên
                </a>
            </div>
            @if($department->employees->isEmpty())
                <div class="dept-empty">
                    <div class="dept-empty-icon">
                        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <div class="dept-empty-title">Chưa có nhân sự</div>
                    <div class="dept-empty-desc">Phòng ban này chưa có nhân viên nào</div>
                </div>
            @else
                <table class="dept-table">
                    <thead>
                        <tr>
                            <th>Nhân viên</th>
                            <th>Vị trí</th>
                            <th>Email</th>
                            <th>Ngày vào</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($department->employees as $emp)
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:10px">
                                        <div class="dept-avatar">
                                            @if($emp->avatar)
                                                <img src="{{ $emp->avatar_url }}" alt="">
                                            @else
                                                {{ strtoupper(substr($emp->first_name,0,1).substr($emp->last_name,0,1)) }}
                                            @endif
                                        </div>
                                        <div>
                                            <div class="dept-table-name">{{ $emp->name }}</div>
                                            <div style="font-size:10.5px;color:#94a3b8">{{ $emp->employee_code ?? '' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($emp->position)
                                        <span class="dept-badge dept-badge-purple">{{ $emp->position->title }}</span>
                                    @else
                                        <span style="color:#cbd5e1;font-size:12px">—</span>
                                    @endif
                                </td>
                                <td style="font-size:12px;color:#475569">{{ $emp->email ?? '—' }}</td>
                                <td style="font-size:12px;color:#475569">
                                    {{ $emp->hire_date ? \Carbon\Carbon::parse($emp->hire_date)->format('d/m/Y') : '—' }}
                                </td>
                                <td>
                                    <span class="dept-badge {{ $emp->is_active ? 'dept-badge-active' : 'dept-badge-inactive' }}">
                                        <span class="dept-status-dot {{ $emp->is_active ? 'active' : 'inactive' }}"></span>
                                        {{ $emp->is_active ? 'Đang làm' : 'Đã nghỉ' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    {{-- Tab: Vị trí --}}
    <div id="tab-positions" class="dept-tab-panel dept-body" style="display:none">
        <div class="dept-table-card">
            <div class="dept-table-header">
                <div>
                    <span class="dept-table-title">Danh sách vị trí</span>
                    <span class="dept-table-count" style="margin-left:8px">{{ $department->positions->count() }} vị trí</span>
                </div>
                <a href="{{ route('hr.positions.create', ['department_id' => $department->id]) }}" class="btn-dept-primary" style="font-size:11.5px;padding:6px 13px">
                    <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Thêm vị trí
                </a>
            </div>
            @if($department->positions->isEmpty())
                <div class="dept-empty">
                    <div class="dept-empty-icon">
                        <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    </div>
                    <div class="dept-empty-title">Chưa có vị trí nào</div>
                    <div class="dept-empty-desc">Thêm vị trí công việc cho phòng ban này</div>
                </div>
            @else
                <table class="dept-table">
                    <thead>
                        <tr>
                            <th>Vị trí</th>
                            <th>Mã</th>
                            <th>Cấp bậc</th>
                            <th>Lương</th>
                            <th>Biên chế</th>
                            <th>Trạng thái</th>
                            <th style="text-align:right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($department->positions as $pos)
                            <tr>
                                <td>
                                    <div class="dept-table-name">{{ $pos->title }}</div>
                                    @if($pos->description)
                                        <div style="font-size:11px;color:#94a3b8;margin-top:1px">{{ Str::limit($pos->description, 50) }}</div>
                                    @endif
                                </td>
                                <td><span class="dept-table-code">{{ $pos->code }}</span></td>
                                <td>
                                    @if($pos->level)
                                        <span class="dept-badge dept-badge-amber">{{ \App\packages\Nova\Department\src\Models\Position::LEVELS[$pos->level] ?? $pos->level }}</span>
                                    @else
                                        <span style="color:#cbd5e1;font-size:12px">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($pos->salary_min || $pos->salary_max)
                                        <div class="dept-salary-range">
                                            {{ $pos->salary_min ? number_format($pos->salary_min) : '?' }}
                                            <span class="sep">–</span>
                                            {{ $pos->salary_max ? number_format($pos->salary_max) : '?' }}
                                        </div>
                                    @else
                                        <span style="color:#cbd5e1;font-size:12px">Chưa đặt</span>
                                    @endif
                                </td>
                                <td>
                                    @if($pos->headcount_plan)
                                        <span class="dept-badge dept-badge-gray">{{ $pos->headcount_plan }} người</span>
                                    @else
                                        <span style="color:#cbd5e1;font-size:12px">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="dept-badge {{ $pos->status === 'active' ? 'dept-badge-active' : 'dept-badge-inactive' }}">
                                        <span class="dept-status-dot {{ $pos->status }}"></span>
                                        {{ $pos->status === 'active' ? 'Hoạt động' : 'Không hoạt động' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="dept-table-actions">
                                        <a href="{{ route('hr.positions.show', $pos) }}" class="btn-dept-icon view" title="Xem chi tiết">
                                            <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </a>
                                        <a href="{{ route('hr.positions.edit', $pos) }}" class="btn-dept-icon edit" title="Chỉnh sửa">
                                            <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    {{-- Tab: Phòng ban con --}}
    <div id="tab-children" class="dept-tab-panel dept-body" style="display:none">
        <div class="dept-table-card">
            <div class="dept-table-header">
                <div>
                    <span class="dept-table-title">Phòng ban con</span>
                    <span class="dept-table-count" style="margin-left:8px">{{ $department->children->count() }} phòng ban</span>
                </div>
                <a href="{{ route('hr.departments.create', ['parent_id' => $department->id]) }}" class="btn-dept-primary" style="font-size:11.5px;padding:6px 13px">
                    <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Thêm phòng ban con
                </a>
            </div>
            @if($department->children->isEmpty())
                <div class="dept-empty">
                    <div class="dept-empty-icon">
                        <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                    </div>
                    <div class="dept-empty-title">Chưa có phòng ban con</div>
                    <div class="dept-empty-desc">Phòng ban này chưa có đơn vị trực thuộc nào</div>
                </div>
            @else
                <table class="dept-table">
                    <thead>
                        <tr>
                            <th>Phòng ban</th>
                            <th>Mã</th>
                            <th>Trưởng phòng</th>
                            <th>Nhân sự</th>
                            <th>Trạng thái</th>
                            <th style="text-align:right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($department->children as $child)
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:8px">
                                        @if($child->color)
                                            <span style="width:10px;height:10px;border-radius:50%;background:{{ $child->color }};flex-shrink:0;display:inline-block"></span>
                                        @endif
                                        <div class="dept-table-name">{{ $child->name }}</div>
                                    </div>
                                </td>
                                <td><span class="dept-table-code">{{ $child->code }}</span></td>
                                <td>
                                    @if($child->manager)
                                        <div style="display:flex;align-items:center;gap:8px">
                                            <div class="dept-avatar" style="width:26px;height:26px;font-size:9px">
                                                @if($child->manager->avatar)
                                                    <img src="{{ $child->manager->avatar_url }}" alt="">
                                                @else
                                                    {{ strtoupper(substr($child->manager->first_name,0,1).substr($child->manager->last_name,0,1)) }}
                                                @endif
                                            </div>
                                            <span style="font-size:12px;font-weight:600;color:#334155">{{ $child->manager->name }}</span>
                                        </div>
                                    @else
                                        <span style="color:#cbd5e1;font-size:12px">Chưa có</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="dept-badge dept-badge-blue">{{ $child->employee_count }} người</span>
                                </td>
                                <td>
                                    <span class="dept-badge {{ $child->status === 'active' ? 'dept-badge-active' : 'dept-badge-inactive' }}">
                                        <span class="dept-status-dot {{ $child->status }}"></span>
                                        {{ $child->status === 'active' ? 'Hoạt động' : 'Không hoạt động' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="dept-table-actions">
                                        <a href="{{ route('hr.departments.show', $child) }}" class="btn-dept-icon view" title="Xem chi tiết">
                                            <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </a>
                                        <a href="{{ route('hr.departments.edit', $child) }}" class="btn-dept-icon edit" title="Chỉnh sửa">
                                            <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    @vite(['app/packages/Nova/Department/src/resources/js/app.js'])
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Tab switching
            const tabs   = document.querySelectorAll('.dept-tab[data-tab]');
            const panels = document.querySelectorAll('.dept-tab-panel');

            function switchTab(tabId) {
                tabs.forEach(t => t.classList.toggle('active', t.dataset.tab === tabId));
                panels.forEach(p => p.style.display = p.id === tabId ? (p.id === 'tab-overview' ? 'grid' : 'flex') : 'none');
            }

            tabs.forEach(tab => {
                tab.addEventListener('click', e => {
                    e.preventDefault();
                    switchTab(tab.dataset.tab);
                });
            });

            // "Xem tất cả →" link trong overview
            document.querySelectorAll('[data-goto-tab]').forEach(el => {
                el.addEventListener('click', e => {
                    e.preventDefault();
                    switchTab(el.dataset.gotoTab);
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            });

            // Mở đúng tab nếu URL có hash
            const hash = location.hash.replace('#', '');
            if (hash && document.getElementById(hash)) switchTab(hash);
        });
    </script>
@endsection