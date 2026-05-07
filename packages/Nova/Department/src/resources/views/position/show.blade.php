@extends('nova-dashboard::layouts')

@section('title', $position->title . ' — NovaHRM')

@section('styles')
    @vite([
        'packages/Nova/Dashboard/src/resources/css/app.css',
        'packages/Nova/Department/src/resources/css/app.css',
    ])
@endsection

@section('content')
    <header class="dept-topbar">
        <div class="dept-topbar-row1">
            <div>
                <div class="dept-breadcrumb">
                    <a href="{{ route('dashboard') }}">@lang('nova-department::app.common.dashboard')</a>
                    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    <a href="{{ route('hr.positions.index') }}">@lang('nova-department::app.common.positions')</a>
                    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    <span>{{ $position->title }}</span>
                </div>
                <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap">
                    <div class="dept-page-title">{{ $position->title }}</div>
                    <span class="dept-table-code">{{ $position->code }}</span>
                    @if($position->level)
                        @php
                            $levelBadge = match($position->level) {
                                'intern'         => 'dept-badge-gray',
                                'junior'         => 'dept-badge-blue',
                                'mid'            => 'dept-badge-purple',
                                'senior', 'lead' => 'dept-badge-amber',
                                default          => 'dept-badge-amber',
                            };
                        @endphp
                        <span class="dept-badge {{ $levelBadge }}">
                            {{ \App\packages\Nova\Department\src\Models\Position::LEVELS[$position->level] ?? $position->level }}
                        </span>
                    @endif
                    <span class="dept-badge {{ $position->status === 'active' ? 'dept-badge-active' : 'dept-badge-inactive' }}">
                        <span class="dept-status-dot {{ $position->status }}"></span>
                        {{ $position->status === 'active' ? __('nova-department::app.common.active') : __('nova-department::app.common.inactive') }}
                    </span>
                </div>
                @if($position->department)
                    <div class="dept-page-subtitle" style="margin-top:4px;display:flex;align-items:center;gap:6px">
                        @if($position->department->color)
                            <span style="width:8px;height:8px;border-radius:50%;background:{{ $position->department->color }};display:inline-block"></span>
                        @endif
                        <a href="{{ route('hr.departments.show', $position->department) }}"
                           style="color:#94a3b8;text-decoration:none;font-weight:600;transition:color 0.15s"
                           onmouseover="this.style.color='#475569'" onmouseout="this.style.color='#94a3b8'">
                            {{ $position->department->name }}
                        </a>
                    </div>
                @endif
            </div>
            <div class="dept-actions">
                <a href="{{ route('hr.positions.index') }}" class="btn-dept-secondary">
                    <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    @lang('nova-department::app.common.back')
                </a>
                <a href="{{ route('hr.positions.edit', $position) }}" class="btn-dept-primary">
                    <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    @lang('nova-department::app.common.edit')
                </a>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="dept-tabs">
            <a class="dept-tab active" data-tab="tab-overview" href="#tab-overview">@lang('nova-department::app.positions.tabs.overview')</a>
            <a class="dept-tab" data-tab="tab-employees" href="#tab-employees">
                @lang('nova-department::app.positions.tabs.employees')
                <span class="dept-badge dept-badge-blue" style="margin-left:6px;padding:1px 7px">
                    {{ $position->employees->count() }}
                </span>
            </a>
        </div>
    </header>

    {{-- Flash --}}
    @if(session('success'))
        <div hidden data-nova-toast-message="{{ session('success') }}" data-nova-toast-type="success"></div>
    @endif
    @if(session('error'))
        <div hidden data-nova-toast-message="{{ session('error') }}" data-nova-toast-type="error"></div>
    @endif

    <div id="tab-overview" class="dept-tab-panel dept-show-body" style="display:grid">
        {{-- Sidebar --}}
        <div class="dept-show-side">
            {{-- Thông tin vị trí --}}
            <div class="dept-info-card">
                <div class="dept-info-card-head">
                    <div class="dept-info-card-title">@lang('nova-department::app.positions.position_info')</div>
                </div>
                <div class="dept-info-list">

                    <div class="dept-info-row">
                        <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                        <div>
                            <div class="dept-info-label">@lang('nova-department::app.positions.department_label')</div>
                            <div class="dept-info-val">
                                @if($position->department)
                                    <a href="{{ route('hr.departments.show', $position->department) }}"
                                       style="color:#1d4ed8;text-decoration:none;font-weight:700">
                                        {{ $position->department->name }}
                                    </a>
                                @else
                                    <span style="color:#94a3b8">@lang('nova-department::app.common.not_defined')</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="dept-info-row">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
                        <div>
                            <div class="dept-info-label">@lang('nova-department::app.positions.level_label')</div>
                            <div class="dept-info-val" style="margin-top:3px">
                                @if($position->level)
                                    <span class="dept-badge {{ $levelBadge ?? 'dept-badge-gray' }}">
                                        {{ \App\packages\Nova\Department\src\Models\Position::LEVELS[$position->level] ?? $position->level }}
                                    </span>
                                @else
                                    <span style="color:#94a3b8">@lang('nova-department::app.common.not_defined')</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="dept-info-row">
                        <svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        <div>
                            <div class="dept-info-label">@lang('nova-department::app.positions.salary_preview')</div>
                            <div class="dept-info-val" style="margin-top:2px">
                                @if($position->salary_min || $position->salary_max)
                                    <div class="dept-salary-range" style="font-size:13px;font-weight:700">
                                        {{ $position->salary_min ? number_format($position->salary_min) . ' ₫' : '?' }}
                                        <span class="sep">–</span>
                                        {{ $position->salary_max ? number_format($position->salary_max) . ' ₫' : '?' }}
                                    </div>
                                @else
                                    <span style="color:#94a3b8">@lang('nova-department::app.common.not_set')</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="dept-info-row">
                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        <div>
                            <div class="dept-info-label">@lang('nova-department::app.positions.headcount_plan')</div>
                            <div class="dept-info-val">
                                @if($position->headcount_plan)
                                    {{ __('nova-department::app.common.people_count', ['count' => $position->headcount_plan]) }}
                                @else
                                    <span style="color:#94a3b8">@lang('nova-department::app.common.not_set')</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="dept-info-row">
                        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <div>
                            <div class="dept-info-label">@lang('nova-department::app.common.created_at')</div>
                            <div class="dept-info-val">{{ $position->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>

                    <div class="dept-info-row">
                        <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        <div>
                            <div class="dept-info-label">@lang('nova-department::app.common.updated_at')</div>
                            <div class="dept-info-val">{{ $position->updated_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Stat cards --}}
            <div class="dept-stats-grid" style="grid-template-columns:1fr 1fr">
                <div class="dept-stat-card">
                    <div class="dept-stat-icon blue">
                        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <div class="dept-stat-label">@lang('nova-department::app.common.employees')</div>
                    <div class="dept-stat-value">{{ $position->employees->count() }}</div>
                    @if($position->headcount_plan)
                        <div class="dept-stat-sub">/ {{ __('nova-department::app.common.people_count', ['count' => $position->headcount_plan]) }}</div>
                    @endif
                </div>
                <div class="dept-stat-card">
                    <div class="dept-stat-icon green">
                        <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                    <div class="dept-stat-label">@lang('nova-department::app.positions.employee_status_active')</div>
                    <div class="dept-stat-value">{{ $position->employees->where('is_active', true)->count() }}</div>
                </div>
            </div>

            {{-- Headcount progress bar --}}
            @if($position->headcount_plan && $position->headcount_plan > 0)
                @php
                    $filled   = $position->employees->count();
                    $plan     = $position->headcount_plan;
                    $pct      = round($filled / $plan * 100);
                    $isOver   = $filled > $plan;
                    $barColor = $isOver ? '#ef4444' : ($pct >= 100 ? '#22c55e' : ($pct >= 70 ? '#f59e0b' : '#3b82f6'));
                    $barWidth = min(100, $pct);
                @endphp
                <div class="dept-info-card" style="padding:16px 18px">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
                        <span style="font-size:10px;font-weight:800;color:#94a3b8;letter-spacing:0.08em;text-transform:uppercase">
                            @lang('nova-department::app.positions.fill_rate')
                        </span>
                        <span style="font-size:13px;font-weight:900;color:{{ $isOver ? '#ef4444' : '#0f172a' }}">{{ $pct }}%</span>
                    </div>
                    <div style="height:8px;background:#f1f5f9;border-radius:99px;overflow:hidden">
                        <div style="height:100%;width:{{ $barWidth }}%;background:{{ $barColor }};border-radius:99px"></div>
                    </div>
                    <div style="display:flex;justify-content:space-between;margin-top:6px">
                        <span style="font-size:11px;color:#94a3b8;font-weight:500">{{ $filled }} / {{ __('nova-department::app.common.people_count', ['count' => $plan]) }}</span>
                        @if($isOver)
                            <span style="font-size:11px;color:#dc2626;font-weight:700">{{ __('nova-department::app.positions.over_capacity', ['count' => $filled - $plan]) }}</span>
                        @elseif($pct >= 100)
                            <span style="font-size:11px;color:#16a34a;font-weight:700">@lang('nova-department::app.positions.full_capacity')</span>
                        @elseif($pct >= 70)
                            <span style="font-size:11px;color:#b45309;font-weight:700">@lang('nova-department::app.positions.almost_full')</span>
                        @else
                            <span style="font-size:11px;color:#3b82f6;font-weight:700">{{ __('nova-department::app.positions.vacancies_left', ['count' => $plan - $filled]) }}</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        {{-- Main --}}
        <div class="dept-show-main">
            {{-- Mô tả --}}
            @if($position->description)
                <div class="dept-info-card">
                    <div class="dept-info-card-head">
                        <div class="dept-info-card-title">@lang('nova-department::app.positions.position_description')</div>
                    </div>
                    <div style="padding:16px 18px;font-size:13px;color:#334155;line-height:1.75;white-space:pre-line">
                        {{ $position->description }}
                    </div>
                </div>
            @endif

            {{-- Chi tiết lương --}}
            @if($position->salary_min || $position->salary_max)
                <div class="dept-info-card">
                    <div class="dept-info-card-head">
                        <div class="dept-info-card-title">@lang('nova-department::app.positions.salary_details')</div>
                    </div>
                    <div style="padding:16px 18px;display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px">
                        <div style="text-align:center;padding:14px;background:#f8fafc;border-radius:10px;border:1px solid #e2e8f0">
                            <div style="font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.07em;margin-bottom:6px">@lang('nova-department::app.positions.min')</div>
                            <div style="font-size:16px;font-weight:900;color:#0f172a">
                                {{ $position->salary_min ? number_format($position->salary_min) : '—' }}
                            </div>
                            @if($position->salary_min)
                                <div style="font-size:10px;color:#94a3b8;margin-top:2px">@lang('nova-department::app.positions.per_month')</div>
                            @endif
                        </div>
                        <div style="text-align:center;padding:14px;background:#eff6ff;border-radius:10px;border:1px solid #dbeafe">
                            <div style="font-size:10px;font-weight:700;color:#1d4ed8;text-transform:uppercase;letter-spacing:0.07em;margin-bottom:6px">@lang('nova-department::app.positions.average')</div>
                            <div style="font-size:16px;font-weight:900;color:#1d4ed8">
                                @if($position->salary_min && $position->salary_max)
                                    {{ number_format(($position->salary_min + $position->salary_max) / 2) }}
                                @else
                                    —
                                @endif
                            </div>
                            @if($position->salary_min && $position->salary_max)
                                <div style="font-size:10px;color:#93c5fd;margin-top:2px">@lang('nova-department::app.positions.per_month')</div>
                            @endif
                        </div>
                        <div style="text-align:center;padding:14px;background:#f8fafc;border-radius:10px;border:1px solid #e2e8f0">
                            <div style="font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.07em;margin-bottom:6px">@lang('nova-department::app.positions.max')</div>
                            <div style="font-size:16px;font-weight:900;color:#0f172a">
                                {{ $position->salary_max ? number_format($position->salary_max) : '—' }}
                            </div>
                            @if($position->salary_max)
                                <div style="font-size:10px;color:#94a3b8;margin-top:2px">@lang('nova-department::app.positions.per_month')</div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            {{-- Nhân viên preview --}}
            <div class="dept-info-card">
                <div class="dept-info-card-head">
                    <div class="dept-info-card-title">@lang('nova-department::app.positions.employees_in_position')</div>
                    @if($position->employees->count() > 5)
                        <a href="#tab-employees" class="dept-tab-link" data-goto-tab="tab-employees"
                           style="font-size:11.5px;font-weight:700;color:#1d4ed8;text-decoration:none">
                            @lang('nova-department::app.departments.view_all') →
                        </a>
                    @endif
                </div>

                @if($position->employees->isEmpty())
                    <div class="dept-empty" style="padding:28px 24px">
                        <div class="dept-empty-icon">
                            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                        <div class="dept-empty-title">@lang('nova-department::app.positions.no_employees_title')</div>
                        <div class="dept-empty-desc">@lang('nova-department::app.positions.no_employees_description')</div>
                    </div>
                @else
                    @foreach($position->employees->take(5) as $emp)
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
                                <div class="dept-emp-pos" style="display:flex;align-items:center;gap:6px">
                                    @if($emp->department)
                                        @if($emp->department->color)
                                            <span style="width:6px;height:6px;border-radius:50%;background:{{ $emp->department->color }};display:inline-block"></span>
                                        @endif
                                        {{ $emp->department->name }}
                                    @endif
                                    @if($emp->hire_date)
                                        &middot; @lang('nova-department::app.positions.table.hire_date') {{ \Carbon\Carbon::parse($emp->hire_date)->format('d/m/Y') }}
                                    @endif
                                </div>
                            </div>
                            <span class="dept-badge {{ $emp->is_active ? 'dept-badge-active' : 'dept-badge-gray' }}" style="font-size:10px">
                                {{ $emp->is_active ? __('nova-department::app.positions.employee_status_active') : __('nova-department::app.positions.employee_status_inactive') }}
                            </span>
                        </div>
                    @endforeach

                    @if($position->employees->count() > 5)
                        <div style="padding:10px 18px;font-size:12px;color:#94a3b8;font-weight:600;border-top:1px solid #f8fafc;text-align:center">
                            {{ __('nova-department::app.positions.other_employees', ['count' => $position->employees->count() - 5]) }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <div id="tab-employees" class="dept-tab-panel dept-body" style="display:none">
        <div class="dept-table-card">
            <div class="dept-table-header">
                <div>
                    <span class="dept-table-title">{{ __('nova-department::app.positions.preview_title', ['title' => $position->title]) }}</span>
                    <span class="dept-table-count" style="margin-left:8px">{{ __('nova-department::app.common.people_count', ['count' => $position->employees->count()]) }}</span>
                </div>
            </div>

            @if($position->employees->isEmpty())
                <div class="dept-empty">
                    <div class="dept-empty-icon">
                        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <div class="dept-empty-title">@lang('nova-department::app.positions.no_employees_title')</div>
                    <div class="dept-empty-desc">@lang('nova-department::app.positions.no_employees_description')</div>
                </div>
            @else
                <table class="dept-table">
                    <thead>
                        <tr>
                            <th>@lang('nova-department::app.common.employee')</th>
                            <th>@lang('nova-department::app.positions.table.department')</th>
                            <th>@lang('nova-department::app.positions.table.email')</th>
                            <th>@lang('nova-department::app.positions.table.hire_date')</th>
                            <th>@lang('nova-department::app.positions.table.status')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($position->employees as $emp)
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
                                    @if($emp->department)
                                        <div style="display:flex;align-items:center;gap:6px">
                                            @if($emp->department->color)
                                                <span style="width:8px;height:8px;border-radius:50%;background:{{ $emp->department->color }};display:inline-block;flex-shrink:0"></span>
                                            @endif
                                            <a href="{{ route('hr.departments.show', $emp->department) }}"
                                               style="font-size:12px;font-weight:600;color:#334155;text-decoration:none"
                                               onmouseover="this.style.color='#1d4ed8'" onmouseout="this.style.color='#334155'">
                                                {{ $emp->department->name }}
                                            </a>
                                        </div>
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
                                        {{ $emp->is_active ? __('nova-department::app.positions.employee_status_active') : __('nova-department::app.positions.employee_status_inactive') }}
                                    </span>
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
    @vite(['packages/Nova/Department/src/resources/js/app.js'])
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tabs   = document.querySelectorAll('.dept-tab[data-tab]');
            const panels = document.querySelectorAll('.dept-tab-panel');

            function switchTab(tabId) {
                tabs.forEach(t => t.classList.toggle('active', t.dataset.tab === tabId));
                panels.forEach(p => {
                    p.style.display = p.id === tabId
                        ? (p.id === 'tab-overview' ? 'grid' : 'flex')
                        : 'none';
                });
            }

            tabs.forEach(tab => {
                tab.addEventListener('click', e => {
                    e.preventDefault();
                    switchTab(tab.dataset.tab);
                });
            });

            // "Xem tất cả →" link
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

