@extends('nova-dashboard::layouts')

@section('title', 'Vị trí — NovaHRM')

@section('styles')
    @vite([
        'app/packages/Nova/Dashboard/src/resources/css/app.css',
        'app/packages/Nova/Department/src/resources/css/app.css',
    ])
@endsection

@section('content')
    {{-- Topbar --}}
    <header class="dept-topbar">
        <div class="dept-topbar-row1">
            <div>
                <div class="dept-breadcrumb">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    <a href="#">Nova HRM+</a>
                    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    <span>Vị trí &amp; Phòng ban</span>
                </div>
                <div class="dept-page-title">Vị trí công việc</div>
                <div class="dept-page-subtitle">Quản lý các vị trí trong tổ chức</div>
            </div>
            <div class="dept-actions">
                <a href="{{ route('hr.departments.index') }}" class="btn-dept-secondary">
                    <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                    Phòng ban
                </a>
                <a href="{{ route('hr.positions.create') }}" class="btn-dept-primary">
                    <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Thêm vị trí
                </a>
            </div>
        </div>
    </header>

    <div class="dept-body">
        {{-- Flash alerts --}}
        @if(session('success'))
            <div class="dept-alert dept-alert-success" data-auto-close>
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="dept-alert dept-alert-error" data-auto-close>
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- Stat cards --}}
        <div class="dept-stats-grid">
            <div class="dept-stat-card" style="flex-direction:row;align-items:center;justify-content:space-between;gap:12px">
                <div>
                    <div class="dept-stat-icon purple" style="margin-bottom:8px">
                        <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    </div>
                    <div class="dept-stat-label">Tổng vị trí</div>
                    <div class="dept-stat-value">{{ $positions->total() }}</div>
                </div>
                <div style="position:relative;width:90px;height:48px;flex-shrink:0">
                    <canvas id="chart-total" role="img" aria-label="Biểu đồ tổng vị trí"></canvas>
                </div>
            </div>

            <div class="dept-stat-card" style="flex-direction:row;align-items:center;justify-content:space-between;gap:12px">
                <div>
                    <div class="dept-stat-icon green" style="margin-bottom:8px">
                        <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                    <div class="dept-stat-label">Đang hoạt động</div>
                    <div class="dept-stat-value">{{ $positions->getCollection()->where('status','active')->count() }}</div>
                    <div class="dept-stat-sub">trên trang này</div>
                </div>
                <div style="position:relative;width:90px;height:48px;flex-shrink:0">
                    <canvas id="chart-active" role="img" aria-label="Biểu đồ vị trí hoạt động"></canvas>
                </div>
            </div>

            <div class="dept-stat-card" style="flex-direction:row;align-items:center;justify-content:space-between;gap:12px">
                <div>
                    <div class="dept-stat-icon blue" style="margin-bottom:8px">
                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div class="dept-stat-label">Phòng ban</div>
                    <div class="dept-stat-value">{{ $departments->count() }}</div>
                </div>
                <div style="position:relative;width:90px;height:48px;flex-shrink:0">
                    <canvas id="chart-dept" role="img" aria-label="Biểu đồ phòng ban"></canvas>
                </div>
            </div>
        </div>

        {{-- Toolbar --}}
        <form method="GET" action="{{ route('hr.positions.index') }}">
            <div class="dept-toolbar">
                <div class="dept-search-wrap">
                    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="dept-search-input" placeholder="Tìm tên, mã vị trí..."/>
                </div>

                <select name="department_id" class="dept-filter-select" data-filter-form>
                    <option value="">Tất cả phòng ban</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>

                <select name="level" class="dept-filter-select" data-filter-form>
                    <option value="">Tất cả cấp bậc</option>
                    @foreach(\App\packages\Nova\Department\src\Models\Position::LEVELS as $key => $label)
                        <option value="{{ $key }}" {{ request('level') === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>

                <select name="status" class="dept-filter-select" data-filter-form>
                    <option value="">Tất cả trạng thái</option>
                    <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Hoạt động</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                </select>

                @if(request()->hasAny(['search','department_id','level','status']))
                    <a href="{{ route('hr.positions.index') }}" class="btn-dept-secondary">Xóa bộ lọc</a>
                @endif

                <button type="submit" class="btn-dept-secondary">
                    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Tìm
                </button>
            </div>
        </form>

        {{-- Table --}}
        <div class="dept-table-card">
            <div class="dept-table-header">
                <div>
                    <span class="dept-table-title">Danh sách vị trí</span>
                    <span class="dept-table-count" style="margin-left:8px">{{ $positions->total() }} vị trí</span>
                </div>
            </div>

            @if($positions->isEmpty())
                <div class="dept-empty">
                    <div class="dept-empty-icon">
                        <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    </div>
                    <div class="dept-empty-title">Chưa có vị trí nào</div>
                    <div class="dept-empty-desc">
                        @if(request()->hasAny(['search','department_id','level','status']))
                            Không tìm thấy vị trí nào khớp với bộ lọc hiện tại
                        @else
                            Bắt đầu bằng cách thêm vị trí công việc đầu tiên
                        @endif
                    </div>
                    @if(!request()->hasAny(['search','department_id','level','status']))
                        <a href="{{ route('hr.positions.create') }}" class="btn-dept-primary" style="margin-top:4px">
                            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Thêm vị trí
                        </a>
                    @endif
                </div>
            @else
                <table class="dept-table">
                    <thead>
                        <tr>
                            <th>Vị trí</th>
                            <th>Mã</th>
                            <th>Phòng ban</th>
                            <th>Cấp bậc</th>
                            <th>Lương</th>
                            <th>Biên chế</th>
                            <th>Trạng thái</th>
                            <th style="text-align:right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($positions as $pos)
                            <tr>
                                {{-- Tên vị trí --}}
                                <td>
                                    <div class="dept-table-name">{{ $pos->title }}</div>
                                    @if($pos->description)
                                        <div style="font-size:11px;color:#94a3b8;margin-top:1px">
                                            {{ Str::limit($pos->description, 55) }}
                                        </div>
                                    @endif
                                </td>

                                {{-- Mã --}}
                                <td><span class="dept-table-code">{{ $pos->code }}</span></td>

                                {{-- Phòng ban --}}
                                <td>
                                    @if($pos->department)
                                        <div style="display:flex;align-items:center;gap:6px">
                                            @if($pos->department->color)
                                                <span style="width:8px;height:8px;border-radius:50%;background:{{ $pos->department->color }};flex-shrink:0;display:inline-block"></span>
                                            @endif
                                            <a href="{{ route('hr.departments.show', $pos->department) }}"
                                               style="font-size:12.5px;font-weight:600;color:#334155;text-decoration:none;transition:color 0.15s"
                                               onmouseover="this.style.color='#1d4ed8'" onmouseout="this.style.color='#334155'">
                                                {{ $pos->department->name }}
                                            </a>
                                        </div>
                                    @else
                                        <span style="color:#cbd5e1;font-size:12px">—</span>
                                    @endif
                                </td>

                                {{-- Cấp bậc --}}
                                <td>
                                    @if($pos->level)
                                        @php
                                            $levelColor = match($pos->level) {
                                                'intern'    => 'dept-badge-gray',
                                                'junior'    => 'dept-badge-blue',
                                                'mid'       => 'dept-badge-purple',
                                                'senior'    => 'dept-badge-amber',
                                                'lead'      => 'dept-badge-amber',
                                                'manager'   => 'dept-badge-amber',
                                                'director'  => 'dept-badge-amber',
                                                'executive' => 'dept-badge-amber',
                                                default     => 'dept-badge-gray',
                                            };
                                        @endphp
                                        <span class="dept-badge {{ $levelColor }}">
                                            {{ \App\packages\Nova\Department\src\Models\Position::LEVELS[$pos->level] ?? $pos->level }}
                                        </span>
                                    @else
                                        <span style="color:#cbd5e1;font-size:12px">—</span>
                                    @endif
                                </td>

                                {{-- Lương --}}
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

                                {{-- Biên chế --}}
                                <td>
                                    @if($pos->headcount_plan)
                                        <span class="dept-badge dept-badge-gray">{{ $pos->headcount_plan }} người</span>
                                    @else
                                        <span style="color:#cbd5e1;font-size:12px">—</span>
                                    @endif
                                </td>

                                {{-- Trạng thái --}}
                                <td>
                                    <span class="dept-badge {{ $pos->status === 'active' ? 'dept-badge-active' : 'dept-badge-inactive' }}">
                                        <span class="dept-status-dot {{ $pos->status }}"></span>
                                        {{ $pos->status === 'active' ? 'Hoạt động' : 'Không hoạt động' }}
                                    </span>
                                </td>

                                {{-- Thao tác --}}
                                <td>
                                    <div class="dept-table-actions">
                                        <a href="{{ route('hr.positions.show', $pos) }}"
                                           class="btn-dept-icon view" title="Xem chi tiết">
                                            <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </a>
                                        <a href="{{ route('hr.positions.edit', $pos) }}"
                                           class="btn-dept-icon edit" title="Chỉnh sửa">
                                            <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        </a>

                                        <form id="delete-pos-{{ $pos->id }}" method="POST"
                                              action="{{ route('hr.positions.destroy', $pos) }}" style="display:none">
                                            @csrf @method('DELETE')
                                        </form>
                                        <button type="button" class="btn-dept-icon delete" title="Xóa"
                                                data-delete-form="delete-pos-{{ $pos->id }}"
                                                data-name="{{ $pos->title }}">
                                            <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                @if($positions->hasPages())
                    <div class="dept-pagination">
                        <div class="dept-pagination-info">
                            Hiển thị {{ $positions->firstItem() }}–{{ $positions->lastItem() }}
                            trong {{ $positions->total() }} vị trí
                        </div>
                        <div class="dept-pagination-links">
                            {{ $positions->withQueryString()->links() }}
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    @vite(['app/packages/Nova/Department/src/resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const labels      = @json($monthLabels);
            const trendTotal  = @json($trendTotal);
            const trendActive = @json($trendActive);
            const trendDept   = @json($trendDept);

            const sparkLine = (id, data, color, fill) => {
                new Chart(document.getElementById(id), {
                    type: 'line',
                    data: {
                        labels,
                        datasets: [{
                            data,
                            borderColor: color,
                            backgroundColor: fill,
                            fill: true,
                            tension: 0.4,
                            borderWidth: 2,
                            pointRadius: 0,
                            pointHoverRadius: 0,
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: { duration: 800, easing: 'easeOutQuart' },
                        plugins: { legend: { display: false }, tooltip: { enabled: false } },
                        scales: {
                            x: { display: false },
                            y: { display: false, min: 0 },
                        },
                    },
                });
            };

            sparkLine('chart-total',  trendTotal,  '#7c3aed', 'rgba(124,58,237,0.1)');
            sparkLine('chart-active', trendActive, '#16a34a', 'rgba(22,163,74,0.1)');

            // Bar chart cho phòng ban
            new Chart(document.getElementById('chart-dept'), {
                type: 'bar',
                data: {
                    labels,
                    datasets: [{
                        data: trendDept,
                        backgroundColor: trendDept.map((_, i) =>
                            `rgba(29,78,216,${0.15 + (i / trendDept.length) * 0.75})`
                        ),
                        borderRadius: 3,
                        borderSkipped: false,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: { duration: 800, easing: 'easeOutQuart' },
                    plugins: { legend: { display: false }, tooltip: { enabled: false } },
                    scales: {
                        x: { display: false },
                        y: { display: false, min: 0 },
                    },
                },
            });
        });
    </script>
@endsection