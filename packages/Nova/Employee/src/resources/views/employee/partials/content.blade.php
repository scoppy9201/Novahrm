<div class="emp-stats-row">
    <div class="emp-stat-card">
        <div class="emp-stat-top">
            <div>
                <div class="emp-stat-label">Tổng nhân viên</div>
                <div class="emp-stat-value">{{ $stats['total'] ?? 0 }}</div>
            </div>
            <div class="emp-stat-icon blue">
                <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
        </div>
        <div class="emp-stat-sub">Toàn bộ hệ thống</div>
        <div class="emp-sparkline">
            @foreach($stats['sparkline_total'] ?? [40,55,48,62,58,70,65] as $h)
            <div class="emp-sparkline-bar" style="height:{{ $h }}%;background:#bfdbfe;"></div>
            @endforeach
        </div>
    </div>

    <div class="emp-stat-card">
        <div class="emp-stat-top">
            <div>
                <div class="emp-stat-label">Đang làm việc</div>
                <div class="emp-stat-value">{{ $stats['active'] ?? 0 }}</div>
            </div>
            <div class="emp-stat-icon green">
                <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
        </div>
        <div class="emp-stat-sub">
            @php $pct = $stats['total'] > 0 ? round($stats['active'] / $stats['total'] * 100) : 0; @endphp
            {{ $pct }}% tổng nhân viên
        </div>
        <div class="emp-sparkline">
            @foreach($stats['sparkline_active'] ?? [60,65,70,68,75,72,80] as $h)
            <div class="emp-sparkline-bar" style="height:{{ $h }}%;background:#bbf7d0;"></div>
            @endforeach
        </div>
    </div>

    <div class="emp-stat-card">
        <div class="emp-stat-top">
            <div>
                <div class="emp-stat-label">Tuyển tháng này</div>
                <div class="emp-stat-value">{{ $stats['hired_this_month'] ?? 0 }}</div>
            </div>
            <div class="emp-stat-icon purple">
                <svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
            </div>
        </div>
        <div class="emp-stat-sub">{{ now()->format('m/Y') }}</div>
        <div class="emp-sparkline">
            @foreach($stats['sparkline_hired'] ?? [20,35,15,45,30,55,40] as $h)
            <div class="emp-sparkline-bar" style="height:{{ $h }}%;background:#ddd6fe;"></div>
            @endforeach
        </div>
    </div>

    <div class="emp-stat-card">
        <div class="emp-stat-top">
            <div>
                <div class="emp-stat-label">HĐ sắp hết hạn</div>
                <div class="emp-stat-value" style="color:{{ ($stats['contract_expiring'] ?? 0) > 0 ? '#dc2626' : '#0f172a' }}">
                    {{ $stats['contract_expiring'] ?? 0 }}
                </div>
            </div>
            <div class="emp-stat-icon {{ ($stats['contract_expiring'] ?? 0) > 0 ? 'red' : 'gray' }}">
                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
        </div>
        <div class="emp-stat-sub">Trong 30 ngày tới</div>
        <div class="emp-sparkline">
            @foreach($stats['sparkline_expiring'] ?? [80,60,70,90,50,75,65] as $h)
            <div class="emp-sparkline-bar" style="height:{{ $h }}%;background:#fecaca;"></div>
            @endforeach
        </div>
    </div>
</div>

@if(($alerts['contract_expiring'] ?? 0) > 0 || ($alerts['probation_ending'] ?? 0) > 0)
<div class="emp-alert-bar">

    @if(($alerts['contract_expiring'] ?? 0) > 0)
    <div class="emp-alert emp-alert-danger">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <span>
            <strong>{{ $alerts['contract_expiring'] }} hợp đồng</strong> sắp hết hạn trong <strong>30 ngày</strong> tới — cần gia hạn hoặc xử lý kịp thời.
        </span>
        <a href="{{ route('hr.employees.index', ['tab' => 'active', 'filter' => 'contract_expiring']) }}">Xem ngay →</a>
    </div>
    @endif

    @if(($alerts['probation_ending'] ?? 0) > 0)
    <div class="emp-alert emp-alert-warning">
        <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        <span>
            <strong>{{ $alerts['probation_ending'] }} nhân viên</strong> thử việc kết thúc trong <strong>7 ngày</strong> — cần xác nhận kết quả thử việc.
        </span>
        <a href="{{ route('hr.employees.index', ['tab' => 'active', 'filter' => 'probation_ending']) }}">Xem ngay →</a>
    </div>
    @endif
</div>
@endif

<form method="GET" action="{{ route('hr.employees.index') }}" id="filter-form">
    {{-- Giữ lại tab hiện tại --}}
    @if(request('tab'))
        <input type="hidden" name="tab" value="{{ request('tab') }}">
    @endif

    <div class="emp-toolbar">
        {{-- Search --}}
        <div class="emp-search-wrap">
            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input
                type="text"
                name="search"
                class="emp-search-input"
                placeholder="Tìm tên, mã NV, email..."
                value="{{ request('search') }}"
                autocomplete="off"
                id="search-input"
            />
        </div>

        {{-- Filter: Phòng ban --}}
        <select name="department_id" class="emp-filter-select" onchange="document.getElementById('filter-form').submit()">
            <option value="">Tất cả phòng ban</option>
            @foreach($departments ?? [] as $dept)
                <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                    {{ $dept->name }}
                </option>
            @endforeach
        </select>

        {{-- Filter: Trạng thái --}}
        <select name="status" class="emp-filter-select" onchange="document.getElementById('filter-form').submit()">
            <option value="">Tất cả trạng thái</option>
            <option value="active"     {{ request('status') === 'active'     ? 'selected' : '' }}>Đang làm</option>
            <option value="probation"  {{ request('status') === 'probation'  ? 'selected' : '' }}>Thử việc</option>
            <option value="on_leave"   {{ request('status') === 'on_leave'   ? 'selected' : '' }}>Nghỉ phép</option>
            <option value="terminated" {{ request('status') === 'terminated' ? 'selected' : '' }}>Đã nghỉ việc</option>
        </select>

        {{-- Filter: Loại HĐ --}}
        <select name="employment_type" class="emp-filter-select" onchange="document.getElementById('filter-form').submit()">
            <option value="">Loại hợp đồng</option>
            <option value="fulltime"   {{ request('employment_type') === 'fulltime'   ? 'selected' : '' }}>Toàn thời gian</option>
            <option value="parttime"   {{ request('employment_type') === 'parttime'   ? 'selected' : '' }}>Bán thời gian</option>
            <option value="contract"   {{ request('employment_type') === 'contract'   ? 'selected' : '' }}>Hợp đồng</option>
            <option value="internship" {{ request('employment_type') === 'internship' ? 'selected' : '' }}>Thực tập</option>
        </select>

        {{-- Reset filter --}}
        @if(request()->hasAny(['search','department_id','status','employment_type']))
        <a href="{{ route('hr.employees.index', request()->only('tab')) }}" class="btn-emp-secondary">
            <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            Xoá bộ lọc
        </a>
        @endif

        {{-- Search submit --}}
        <button type="submit" class="btn-emp-secondary">
            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            Tìm kiếm
        </button>
    </div>
</form>

{{--EMPLOYEE TABLE --}}
<div class="emp-table-card">
    <div class="emp-table-header">
        <div style="display:flex;align-items:center;gap:10px">
            <span class="emp-table-title">
                @if(request('tab') === 'trash')
                    Nhân viên đã xoá
                @elseif(request('tab') === 'resigned')
                    Đã nghỉ việc
                @elseif(request('tab') === 'active')
                    Đang làm việc
                @else
                    Danh sách nhân viên
                @endif
            </span>
            <span class="emp-table-count">{{ $employees->total() ?? 0 }} người</span>
        </div>

        {{-- Column visibility toggle (optional UX) --}}
        <div style="display:flex;align-items:center;gap:8px">
            @if(request('tab') === 'trash')
            <span style="font-size:11px;color:#94a3b8;font-weight:600">
                <svg viewBox="0 0 24 24" style="width:12px;height:12px;stroke:#94a3b8;fill:none;stroke-width:2;vertical-align:middle;margin-right:3px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                Nhân viên bị xoá mềm — có thể khôi phục
            </span>
            @endif
        </div>
    </div>

    @if($employees->isEmpty())
        {{-- Empty state --}}
        <div class="emp-empty">
            <div class="emp-empty-icon">
                <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div class="emp-empty-title">
                @if(request()->hasAny(['search','department_id','status','employment_type']))
                    Không tìm thấy kết quả
                @else
                    Chưa có nhân viên nào
                @endif
            </div>
            <div class="emp-empty-desc">
                @if(request()->hasAny(['search','department_id','status','employment_type']))
                    Thử thay đổi bộ lọc hoặc từ khoá tìm kiếm
                @else
                    Bắt đầu bằng cách thêm nhân viên đầu tiên vào hệ thống
                @endif
            </div>
            @if(!request()->hasAny(['search','department_id','status','employment_type']))
            <a href="{{ route('hr.employees.create') }}" class="btn-emp-primary" style="margin-top:8px">
                <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Thêm nhân viên
            </a>
            @endif
        </div>
    @else
        <table class="emp-table">
            <thead>
                <tr>
                    <th style="width:40px">
                        <input type="checkbox" id="check-all" style="cursor:pointer;accent-color:#1d4ed8"/>
                    </th>
                    <th>Nhân viên</th>
                    <th>Phòng ban</th>
                    <th>Vị trí</th>
                    <th>Loại HĐ</th>
                    <th>Ngày vào làm</th>
                    <th>Trạng thái</th>
                    <th style="width:120px;text-align:right">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                <tr>
                    {{-- Checkbox --}}
                    <td>
                        <input type="checkbox" class="row-check" value="{{ $employee->id }}"
                               style="cursor:pointer;accent-color:#1d4ed8"/>
                    </td>

                    {{-- Avatar + Tên + Mã NV --}}
                    <td>
                        <div style="display:flex;align-items:center;gap:10px">
                            <div class="emp-avatar">
                                @if($employee->avatar)
                                    <img src="{{ asset('storage/'.$employee->avatar) }}" alt="{{ $employee->name }}"/>
                                @else
                                    {{ strtoupper(substr($employee->full_name ?? 'NN', 0, 2)) }}
                                @endif
                            </div>
                            <div>
                                <div class="emp-table-name">
                                    <a href="{{ route('hr.employees.show', $employee) }}"
                                       style="color:inherit;text-decoration:none;transition:color 0.15s"
                                       onmouseover="this.style.color='#1d4ed8'"
                                       onmouseout="this.style.color='inherit'">
                                        {{ $employee->name }}
                                    </a>
                                </div>
                                <div class="emp-table-code">{{ $employee->employee_code ?? '—' }}</div>
                                <div style="font-size:11px;color:#94a3b8;margin-top:1px">{{ $employee->company_email ?? $employee->email ?? '' }}</div>
                            </div>
                        </div>
                    </td>

                    {{-- Phòng ban --}}
                    <td>
                        <span style="font-size:12.5px;color:#334155;font-weight:600">
                            {{ $employee->department->name ?? '—' }}
                        </span>
                    </td>

                    {{-- Vị trí --}}
                    <td>
                        <span style="font-size:12.5px;color:#334155">
                            {{ $employee->position->name ?? '—' }}
                        </span>
                    </td>

                    {{-- Loại HĐ --}}
                    <td>
                        @php
                            $typeMap = [
                                'fulltime'   => ['label' => 'Toàn thời gian', 'class' => 'emp-badge-blue'],
                                'parttime'   => ['label' => 'Bán thời gian',  'class' => 'emp-badge-gray'],
                                'contract'   => ['label' => 'Hợp đồng',       'class' => 'emp-badge-purple'],
                                'internship' => ['label' => 'Thực tập',        'class' => 'emp-badge-amber'],
                            ];
                            $type = $typeMap[$employee->employment_type] ?? ['label' => $employee->employment_type ?? '—', 'class' => 'emp-badge-gray'];
                        @endphp
                        <span class="emp-badge {{ $type['class'] }}">{{ $type['label'] }}</span>
                    </td>

                    {{-- Ngày vào làm --}}
                    <td>
                        <span style="font-size:12.5px;color:#334155">
                            {{ $employee->hire_date ? \Carbon\Carbon::parse($employee->hire_date)->format('d/m/Y') : '—' }}
                        </span>
                        @if($employee->hire_date)
                        <div style="font-size:10.5px;color:#94a3b8;margin-top:1px">
                            {{ \Carbon\Carbon::parse($employee->hire_date)->diffForHumans(null, true, true, 1) }}
                        </div>
                        @endif
                    </td>

                    {{-- Trạng thái --}}
                    <td>
                        @php
                            $statusMap = [
                                'active'     => ['label' => 'Đang làm',   'class' => 'emp-badge-active',   'dot' => 'active'],
                                'probation'  => ['label' => 'Thử việc',   'class' => 'emp-badge-probation', 'dot' => 'probation'],
                                'on_leave'   => ['label' => 'Nghỉ phép',  'class' => 'emp-badge-blue',      'dot' => 'on_leave'],
                                'terminated' => ['label' => 'Đã nghỉ',    'class' => 'emp-badge-inactive',  'dot' => 'inactive'],
                                'suspended'  => ['label' => 'Đình chỉ',   'class' => 'emp-badge-danger',    'dot' => 'suspended'],
                            ];
                            $st = $statusMap[$employee->status] ?? ['label' => $employee->status ?? '—', 'class' => 'emp-badge-gray', 'dot' => 'inactive'];
                        @endphp
                        <span class="emp-badge {{ $st['class'] }}">
                            <span class="emp-status-dot {{ $st['dot'] }}"></span>
                            {{ $st['label'] }}
                        </span>

                        {{-- Badge cảnh báo HĐ sắp hết --}}
                        @if($employee->contract_end_date && \Carbon\Carbon::parse($employee->contract_end_date)->diffInDays(now()) <= 30 && \Carbon\Carbon::parse($employee->contract_end_date)->isFuture())
                        <div style="margin-top:4px">
                            <span class="emp-badge emp-badge-danger" style="font-size:9.5px">
                                <svg viewBox="0 0 24 24" style="width:10px;height:10px;stroke:currentColor;fill:none;stroke-width:2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                HĐ hết {{ \Carbon\Carbon::parse($employee->contract_end_date)->diffForHumans() }}
                            </span>
                        </div>
                        @endif
                    </td>

                    {{-- Actions --}}
                    <td>
                        <div style="display:flex;align-items:center;gap:4px;justify-content:flex-end">
                            @if(request('tab') === 'trash')
                                {{-- Restore --}}
                                <form method="POST"
                                    action="{{ route('hr.employees.restore', $employee->id) }}"
                                    style="display:inline"
                                    data-nova-confirm-message="Khôi phục nhân viên này?"
                                    data-nova-confirm-title="Khôi phục nhân viên"
                                    data-nova-confirm-text="Khôi phục"
                                    data-nova-confirm-cancel="Huỷ"
                                    data-nova-confirm-type="info">
                                    @csrf
                                    <button type="submit" class="btn-emp-icon" title="Khôi phục">
                                        <svg viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4.41"/></svg>
                                    </button>
                                </form>
                                {{-- Force Delete --}}
                                <form method="POST"
                                      action="{{ route('hr.employees.force-delete', $employee->id) }}"
                                      style="display:inline"
                                      data-nova-confirm-message="XOÁ VĨNH VIỄN nhân viên này? Không thể hoàn tác!"
                                      data-nova-confirm-title="Xoá vĩnh viễn"
                                      data-nova-confirm-text="Xoá vĩnh viễn"
                                      data-nova-confirm-cancel="Huỷ"
                                      data-nova-confirm-type="danger">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-emp-icon" title="Xoá vĩnh viễn"
                                            style="border-color:#fecaca">
                                        <svg viewBox="0 0 24 24" style="stroke:#dc2626"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                                    </button>
                                </form>
                            @else
                                {{-- View --}}
                                <a href="{{ route('hr.employees.show', $employee) }}" class="btn-emp-icon" title="Xem chi tiết">
                                    <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </a>
                                {{-- Edit --}}
                                <a href="{{ route('hr.employees.edit', $employee) }}" class="btn-emp-icon" title="Chỉnh sửa">
                                    <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </a>
                                {{-- Soft Delete --}}
                                <form method="POST"
                                      action="{{ route('hr.employees.destroy', $employee) }}"
                                      style="display:inline"
                                      data-nova-confirm-message="Xoá nhân viên {{ addslashes($employee->name) }}?"
                                      data-nova-confirm-title="Xác nhận xoá nhân viên"
                                      data-nova-confirm-text="Xoá"
                                      data-nova-confirm-cancel="Huỷ"
                                      data-nova-confirm-type="danger">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-emp-icon" title="Xoá">
                                        <svg viewBox="0 0 24 24" style="stroke:#dc2626"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        @if($employees->hasPages())
        <div class="emp-pagination">
            <div>
                Hiển thị <strong>{{ $employees->firstItem() }}–{{ $employees->lastItem() }}</strong>
                trong tổng số <strong>{{ $employees->total() }}</strong> nhân viên
            </div>
            <div class="emp-pagination-links">
                {{-- Prev --}}
                @if($employees->onFirstPage())
                    <span style="opacity:0.4;cursor:not-allowed" class="emp-pagination-links">
                        <a href="#" onclick="return false">‹</a>
                    </span>
                @else
                    <a href="{{ $employees->previousPageUrl() . '&' . http_build_query(request()->except('page')) }}">‹</a>
                @endif

                {{-- Pages --}}
                @foreach($employees->getUrlRange(1, $employees->lastPage()) as $page => $url)
                    @if($page == $employees->currentPage())
                        <span class="active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $employees->lastPage() || abs($page - $employees->currentPage()) <= 2)
                        <a href="{{ $url . '&' . http_build_query(request()->except('page')) }}">{{ $page }}</a>
                    @elseif(abs($page - $employees->currentPage()) == 3)
                        <span class="dots">…</span>
                    @endif
                @endforeach

                {{-- Next --}}
                @if($employees->hasMorePages())
                    <a href="{{ $employees->nextPageUrl() . '&' . http_build_query(request()->except('page')) }}">›</a>
                @else
                    <span style="opacity:0.4;cursor:not-allowed">
                        <a href="#" onclick="return false">›</a>
                    </span>
                @endif
            </div>
        </div>
        @endif
    @endif 
</div>
