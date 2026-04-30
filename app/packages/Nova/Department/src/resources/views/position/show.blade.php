@extends('nova-dashboard::layouts')

@section('title', 'Phòng ban — NovaHRM')

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
                    <span>Vị trí &amp; Phòng ban</span>
                </div>
                <div class="dept-page-title">Phòng ban</div>
                <div class="dept-page-subtitle">Quản lý cấu trúc tổ chức</div>
            </div>
            <div class="dept-actions">
                <a href="{{ route('hr.positions.index') }}" class="btn-dept-secondary">
                    <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    Vị trí
                </a>
                <a href="{{ route('hr.departments.create') }}" class="btn-dept-primary">
                    <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Thêm phòng ban
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
            <div class="dept-stat-card">
                <div class="dept-stat-icon blue">
                    <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                </div>
                <div class="dept-stat-label">Tổng phòng ban</div>
                <div class="dept-stat-value">{{ $departments->total() }}</div>
            </div>
            <div class="dept-stat-card">
                <div class="dept-stat-icon green">
                    <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <div class="dept-stat-label">Đang hoạt động</div>
                <div class="dept-stat-value">{{ $departments->getCollection()->where('status','active')->count() }}</div>
            </div>
        </div>

        {{-- Toolbar --}}
        <form method="GET" action="{{ route('hr.departments.index') }}">
            <div class="dept-toolbar">
                <div class="dept-search-wrap">
                    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="dept-search-input" placeholder="Tìm tên, mã phòng ban..."/>
                </div>
                <select name="status" class="dept-filter-select" data-filter-form>
                    <option value="">Tất cả trạng thái</option>
                    <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Hoạt động</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                </select>
                @if(request()->hasAny(['search','status']))
                    <a href="{{ route('hr.departments.index') }}" class="btn-dept-secondary">Xóa bộ lọc</a>
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
                    <span class="dept-table-title">Danh sách phòng ban</span>
                    <span class="dept-table-count" style="margin-left:8px">{{ $departments->total() }} phòng ban</span>
                </div>
            </div>

            @if($departments->isEmpty())
                <div class="dept-empty">
                    <div class="dept-empty-icon">
                        <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                    </div>
                    <div class="dept-empty-title">Chưa có phòng ban nào</div>
                    <div class="dept-empty-desc">Bắt đầu bằng cách thêm phòng ban đầu tiên cho tổ chức của bạn</div>
                    <a href="{{ route('hr.departments.create') }}" class="btn-dept-primary" style="margin-top:4px">
                        <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Thêm phòng ban
                    </a>
                </div>
            @else
                <table class="dept-table">
                    <thead>
                        <tr>
                            <th>Phòng ban</th>
                            <th>Mã</th>
                            <th>Phòng cha</th>
                            <th>Trưởng phòng</th>
                            <th>Nhân sự</th>
                            <th>Trạng thái</th>
                            <th style="text-align:right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($departments as $dept)
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:10px">
                                        @if($dept->color)
                                            <span style="width:10px;height:10px;border-radius:50%;background:{{ $dept->color }};flex-shrink:0;display:inline-block"></span>
                                        @endif
                                        <div>
                                            <div class="dept-table-name">{{ $dept->name }}</div>
                                            @if($dept->description)
                                                <div style="font-size:11px;color:#94a3b8;margin-top:1px">{{ Str::limit($dept->description, 50) }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td><span class="dept-table-code">{{ $dept->code }}</span></td>
                                <td>
                                    @if($dept->parent)
                                        <span class="dept-badge dept-badge-gray">{{ $dept->parent->name }}</span>
                                    @else
                                        <span style="color:#cbd5e1;font-size:12px">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($dept->manager)
                                        <div style="display:flex;align-items:center;gap:8px">
                                            <div class="dept-avatar" style="width:26px;height:26px;font-size:9px">
                                                @if($dept->manager->avatar)
                                                    <img src="{{ $dept->manager->avatar_url }}" alt="">
                                                @else
                                                    {{ strtoupper(substr($dept->manager->first_name,0,1).substr($dept->manager->last_name,0,1)) }}
                                                @endif
                                            </div>
                                            <span style="font-size:12px;font-weight:600;color:#334155">{{ $dept->manager->name }}</span>
                                        </div>
                                    @else
                                        <span style="color:#cbd5e1;font-size:12px">Chưa có</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="dept-badge dept-badge-blue">{{ $dept->employee_count }} người</span>
                                </td>
                                <td>
                                    <span class="dept-badge {{ $dept->status === 'active' ? 'dept-badge-active' : 'dept-badge-inactive' }}">
                                        <span class="dept-status-dot {{ $dept->status }}"></span>
                                        {{ $dept->status === 'active' ? 'Hoạt động' : 'Không hoạt động' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="dept-table-actions">
                                        <a href="{{ route('hr.departments.show', $dept) }}" class="btn-dept-icon view" title="Xem chi tiết">
                                            <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </a>
                                        <a href="{{ route('hr.departments.edit', $dept) }}" class="btn-dept-icon edit" title="Chỉnh sửa">
                                            <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        </a>

                                        <form id="delete-dept-{{ $dept->id }}" method="POST"
                                              action="{{ route('hr.departments.destroy', $dept) }}" style="display:none">
                                            @csrf @method('DELETE')
                                        </form>
                                        <button type="button" class="btn-dept-icon delete" title="Xóa"
                                                data-delete-form="delete-dept-{{ $dept->id }}"
                                                data-name="{{ $dept->name }}">
                                            <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                @if($departments->hasPages())
                    <div class="dept-pagination">
                        <div class="dept-pagination-info">
                            Hiển thị {{ $departments->firstItem() }}–{{ $departments->lastItem() }}
                            trong {{ $departments->total() }} phòng ban
                        </div>
                        <div class="dept-pagination-links">
                            {{ $departments->withQueryString()->links() }}
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    @vite(['app/packages/Nova/Department/src/resources/js/app.js'])
@endsection