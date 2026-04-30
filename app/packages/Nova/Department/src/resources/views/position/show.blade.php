@extends('nova-dashboard::layouts')

@section('title', $position->title . ' — NovaHRM')

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
                    <a href="{{ route('hr.positions.index') }}">Vị trí</a>
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
                        {{ $position->status === 'active' ? 'Hoạt động' : 'Không hoạt động' }}
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
                    Quay lại
                </a>
                <a href="{{ route('hr.positions.edit', $position) }}" class="btn-dept-primary">
                    <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Chỉnh sửa
                </a>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="dept-tabs">
            <a class="dept-tab active" data-tab="tab-overview" href="#tab-overview">Tổng quan</a>
            <a class="dept-tab" data-tab="tab-employees" href="#tab-employees">
                Nhân viên
                <span class="dept-badge dept-badge-blue" style="margin-left:6px;padding:1px 7px">
                    {{ $position->employees->count() }}
                </span>
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
    @if(session('error'))
        <div style="padding:14px 24px 0">
            <div class="dept-alert dept-alert-error" data-auto-close>
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <div id="tab-overview" class="dept-tab-panel dept-show-body" style="display:grid">
        {{-- Sidebar --}}
        <div class="dept-show-side">
            {{-- Thông tin vị trí --}}
            <div class="dept-info-card">
                <div class="dept-info-card-head">
                    <div class="dept-info-card-title">Thông tin vị trí</div>
                </div>
                <div class="dept-info-list">

                    <div class="dept-info-row">
                        <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                        <div>
                            <div class="dept-info-label">Phòng ban</div>
                            <div class="dept-info-val">
                                @if($position->department)
                                    <a href="{{ route('hr.departments.show', $position->department) }}"
                                       style="color:#1d4ed8;text-decoration:none;font-weight:700">
                                        {{ $position->department->name }}
                                    </a>
                                @else
                                    <span style="color:#94a3b8">Chưa xác định</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="dept-info-row">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
                        <div>
                            <div class="dept-info-label">Cấp bậc</div>
                            <div class="dept-info-val" style="margin-top:3px">
                                @if($position->level)
                                    <span class="dept-badge {{ $levelBadge ?? 'dept-badge-gray' }}">
                                        {{ \App\packages\Nova\Department\src\Models\Position::LEVELS[$position->level] ?? $position->level }}
                                    </span>
                                @else
                                    <span style="color:#94a3b8">Chưa xác định</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="dept-info-row">
                        <svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        <div>
                            <div class="dept-info-label">Dải lương</div>
                            <div class="dept-info-val" style="margin-top:2px">
                                @if($position->salary_min || $position->salary_max)
                                    <div class="dept-salary-range" style="font-size:13px;font-weight:700">
                                        {{ $position->salary_min ? number_format($position->salary_min) . ' ₫' : '?' }}
                                        <span class="sep">–</span>
                                        {{ $position->salary_max ? number_format($position->salary_max) . ' ₫' : '?' }}
                                    </div>
                                @else
                                    <span style="color:#94a3b8">Chưa đặt</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="dept-info-row">
                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        <div>
                            <div class="dept-info-label">Biên chế kế hoạch</div>
                            <div class="dept-info-val">
                                @if($position->headcount_plan)
                                    {{ $position->headcount_plan }} người
                                @else
                                    <span style="color:#94a3b8">Chưa đặt</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="dept-info-row">
                        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <div>
                            <div class="dept-info-label">Ngày tạo</div>
                            <div class="dept-info-val">{{ $position->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>

                    <div class="dept-info-row">
                        <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        <div>
                            <div class="dept-info-label">Cập nhật lần cuối</div>
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
                    <div class="dept-stat-label">Nhân viên</div>
                    <div class="dept-stat-value">{{ $position->employees->count() }}</div>
                    @if($position->headcount_plan)
                        <div class="dept-stat-sub">/ {{ $position->headcount_plan }} biên chế</div>
                    @endif
                </div>
                <div class="dept-stat-card">
                    <div class="dept-stat-icon green">
                        <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                    <div class="dept-stat-label">Đang làm</div>
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
                            Tỉ lệ lấp đầy biên chế
                        </span>
                        <span style="font-size:13px;font-weight:900;color:{{ $isOver ? '#ef4444' : '#0f172a' }}">{{ $pct }}%</span>
                    </div>
                    <div style="height:8px;background:#f1f5f9;border-radius:99px;overflow:hidden">
                        <div style="height:100%;width:{{ $barWidth }}%;background:{{ $barColor }};border-radius:99px"></div>
                    </div>
                    <div style="display:flex;justify-content:space-between;margin-top:6px">
                        <span style="font-size:11px;color:#94a3b8;font-weight:500">{{ $filled }} / {{ $plan }} người</span>
                        @if($isOver)
                            <span style="font-size:11px;color:#dc2626;font-weight:700">⚠ Vượt {{ $filled - $plan }} người</span>
                        @elseif($pct >= 100)
                            <span style="font-size:11px;color:#16a34a;font-weight:700">Đủ biên chế ✓</span>
                        @elseif($pct >= 70)
                            <span style="font-size:11px;color:#b45309;font-weight:700">Gần đủ</span>
                        @else
                            <span style="font-size:11px;color:#3b82f6;font-weight:700">Còn {{ $plan - $filled }} chỗ trống</span>
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
                        <div class="dept-info-card-title">Mô tả vị trí</div>
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
                        <div class="dept-info-card-title">Chi tiết lương</div>
                    </div>
                    <div style="padding:16px 18px;display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px">
                        <div style="text-align:center;padding:14px;background:#f8fafc;border-radius:10px;border:1px solid #e2e8f0">
                            <div style="font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.07em;margin-bottom:6px">Tối thiểu</div>
                            <div style="font-size:16px;font-weight:900;color:#0f172a">
                                {{ $position->salary_min ? number_format($position->salary_min) : '—' }}
                            </div>
                            @if($position->salary_min)
                                <div style="font-size:10px;color:#94a3b8;margin-top:2px">₫ / tháng</div>
                            @endif
                        </div>
                        <div style="text-align:center;padding:14px;background:#eff6ff;border-radius:10px;border:1px solid #dbeafe">
                            <div style="font-size:10px;font-weight:700;color:#1d4ed8;text-transform:uppercase;letter-spacing:0.07em;margin-bottom:6px">Trung bình</div>
                            <div style="font-size:16px;font-weight:900;color:#1d4ed8">
                                @if($position->salary_min && $position->salary_max)
                                    {{ number_format(($position->salary_min + $position->salary_max) / 2) }}
                                @else
                                    —
                                @endif
                            </div>
                            @if($position->salary_min && $position->salary_max)
                                <div style="font-size:10px;color:#93c5fd;margin-top:2px">₫ / tháng</div>
                            @endif
                        </div>
                        <div style="text-align:center;padding:14px;background:#f8fafc;border-radius:10px;border:1px solid #e2e8f0">
                            <div style="font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.07em;margin-bottom:6px">Tối đa</div>
                            <div style="font-size:16px;font-weight:900;color:#0f172a">
                                {{ $position->salary_max ? number_format($position->salary_max) : '—' }}
                            </div>
                            @if($position->salary_max)
                                <div style="font-size:10px;color:#94a3b8;margin-top:2px">₫ / tháng</div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            {{-- Nhân viên preview --}}
            <div class="dept-info-card">
                <div class="dept-info-card-head">
                    <div class="dept-info-card-title">Nhân viên giữ vị trí này</div>
                    @if($position->employees->count() > 5)
                        <a href="#tab-employees" class="dept-tab-link" data-goto-tab="tab-employees"
                           style="font-size:11.5px;font-weight:700;color:#1d4ed8;text-decoration:none">
                            Xem tất cả →
                        </a>
                    @endif
                </div>

                @if($position->employees->isEmpty())
                    <div class="dept-empty" style="padding:28px 24px">
                        <div class="dept-empty-icon">
                            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                        <div class="dept-empty-title">Chưa có nhân viên</div>
                        <div class="dept-empty-desc">Chưa có ai được gán vào vị trí này</div>
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
                                        &middot; Vào {{ \Carbon\Carbon::parse($emp->hire_date)->format('d/m/Y') }}
                                    @endif
                                </div>
                            </div>
                            <span class="dept-badge {{ $emp->is_active ? 'dept-badge-active' : 'dept-badge-gray' }}" style="font-size:10px">
                                {{ $emp->is_active ? 'Đang làm' : 'Đã nghỉ' }}
                            </span>
                        </div>
                    @endforeach

                    @if($position->employees->count() > 5)
                        <div style="padding:10px 18px;font-size:12px;color:#94a3b8;font-weight:600;border-top:1px solid #f8fafc;text-align:center">
                            và {{ $position->employees->count() - 5 }} nhân viên khác…
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
                    <span class="dept-table-title">Nhân viên — {{ $position->title }}</span>
                    <span class="dept-table-count" style="margin-left:8px">{{ $position->employees->count() }} người</span>
                </div>
            </div>

            @if($position->employees->isEmpty())
                <div class="dept-empty">
                    <div class="dept-empty-icon">
                        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <div class="dept-empty-title">Chưa có nhân viên</div>
                    <div class="dept-empty-desc">Chưa có ai được gán vào vị trí này</div>
                </div>
            @else
                <table class="dept-table">
                    <thead>
                        <tr>
                            <th>Nhân viên</th>
                            <th>Phòng ban</th>
                            <th>Email</th>
                            <th>Ngày vào làm</th>
                            <th>Trạng thái</th>
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

@endsection

@section('scripts')
    @vite(['app/packages/Nova/Department/src/resources/js/app.js'])
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