@extends('nova-dashboard::layouts')

@section('title', __('nova-department::app.departments.page_title'))

@section('styles')
    @vite([
        'app/packages/Nova/Dashboard/src/resources/css/app.css',
        'app/packages/Nova/Department/src/resources/css/app.css',
    ])
@endsection

@section('content')

@php
    function sparkPoints(array $data, int $w = 80, int $h = 32, int $pad = 3): string {
        $min = min($data) ?? 0;
        $max = max($data) ?? 1;
        $range = $max - $min ?: 1;
        $count = count($data);
        return collect($data)->map(function ($val, $i) use ($count, $w, $h, $pad, $min, $range) {
            $x = $count > 1 ? $i / ($count - 1) * $w : $w / 2;
            $y = $h - $pad - (($val - $min) / $range) * ($h - $pad * 2);
            return "{$x},{$y}";
        })->implode(' ');
    }

    $totalPoints  = sparkPoints($totalSparkline->toArray());
    $activePoints = sparkPoints($activeByMonth->toArray());
    // điểm đóng vùng fill
    $totalFill  = $totalPoints  . " 80,32 0,32";
    $activeFill = $activePoints . " 80,32 0,32";
    $noManagerPoints = sparkPoints($noManagerByMonth->toArray());
    $noManagerFill   = $noManagerPoints . " 80,32 0,32";
@endphp

    {{-- Topbar --}}
    <header class="dept-topbar">
        <div class="dept-topbar-row1">
            <div>
                <div class="dept-breadcrumb">
                    <a href="{{ route('dashboard') }}">@lang('nova-department::app.common.dashboard')</a>
                    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    <a href="#">@lang('nova-department::app.common.suite')</a>
                    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    <span>@lang('nova-department::app.common.module')</span>
                </div>
                <div class="dept-page-title">@lang('nova-department::app.departments.heading')</div>
                <div class="dept-page-subtitle">@lang('nova-department::app.departments.subtitle')</div>
            </div>
            <div class="dept-actions">
                <a href="{{ route('hr.positions.index') }}" class="btn-dept-secondary">
                    <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    @lang('nova-department::app.common.positions')
                </a>
                <a href="{{ route('hr.departments.create') }}" class="btn-dept-primary">
                    <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    @lang('nova-department::app.departments.add_button')
                </a>
            </div>
        </div>
    </header>

    <div class="dept-body">
        {{-- Flash alerts --}}
        @if(session('success'))
            <div hidden data-nova-toast-message="{{ session('success') }}" data-nova-toast-type="success"></div>
        @endif
        @if(session('error'))
            <div hidden data-nova-toast-message="{{ session('error') }}" data-nova-toast-type="error"></div>
        @endif

        {{-- Stat cards --}}
        <div class="dept-stats-grid">
            <div class="dept-stat-card">
                <div class="dept-stat-top">
                    <div>
                        <div class="dept-stat-icon blue">
                            <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                        </div>
                        <div class="dept-stat-label">@lang('nova-department::app.departments.stats_total')</div>
                        <div class="dept-stat-value">{{ $departments->total() }}</div>
                        <div class="dept-stat-sub">@lang('nova-department::app.departments.stats_total_sub')</div>
                    </div>
                    <svg class="dept-sparkline" viewBox="0 0 80 32" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="blueGrad" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#3b82f6" stop-opacity="0.25"/>
                                <stop offset="100%" stop-color="#3b82f6" stop-opacity="0"/>
                            </linearGradient>
                        </defs>
                        <polygon points="{{ $totalFill }}" fill="url(#blueGrad)"/>
                        <polyline points="{{ $totalPoints }}"
                                fill="none" stroke="#3b82f6" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>

            <div class="dept-stat-card">
                <div class="dept-stat-top">
                    <div>
                        <div class="dept-stat-icon green">
                            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                        <div class="dept-stat-label">@lang('nova-department::app.departments.stats_active')</div>
                        <div class="dept-stat-value">{{ $departments->getCollection()->where('status','active')->count() }}</div>
                        <div class="dept-stat-sub">@lang('nova-department::app.departments.stats_active_sub')</div>
                    </div>
                    <svg class="dept-sparkline" viewBox="0 0 80 32" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="greenGrad" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#22c55e" stop-opacity="0.25"/>
                                <stop offset="100%" stop-color="#22c55e" stop-opacity="0"/>
                            </linearGradient>
                        </defs>
                        <polygon points="{{ $activeFill }}" fill="url(#greenGrad)"/>
                        <polyline points="{{ $activePoints }}"
                                fill="none" stroke="#22c55e" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>

            <div class="dept-stat-card">
                <div class="dept-stat-top">
                    <div>
                        <div class="dept-stat-icon amber">
                            <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M6 20v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/><line x1="18" y1="8" x2="23" y2="13"/><line x1="23" y1="8" x2="18" y2="13"/></svg>
                        </div>
                        <div class="dept-stat-label">@lang('nova-department::app.departments.stats_no_manager')</div>
                        <div class="dept-stat-value">
                            {{ $departments->getCollection()->whereNull('manager_id')->count() }}
                        </div>
                        <div class="dept-stat-sub">@lang('nova-department::app.departments.stats_no_manager_sub')</div>
                    </div>
                    <svg class="dept-sparkline" viewBox="0 0 80 32" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="amberGrad" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#f59e0b" stop-opacity="0.25"/>
                                <stop offset="100%" stop-color="#f59e0b" stop-opacity="0"/>
                            </linearGradient>
                        </defs>
                        <polygon points="{{ $noManagerFill }}" fill="url(#amberGrad)"/>
                        <polyline points="{{ $noManagerPoints }}"
                                fill="none" stroke="#f59e0b" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Toolbar --}}
        <form method="GET" action="{{ route('hr.departments.index') }}">
            <div class="dept-toolbar">
                <div class="dept-search-wrap">
                    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="dept-search-input" placeholder="@lang('nova-department::app.departments.search_placeholder')"/>
                </div>
                <select name="status" class="dept-filter-select" data-filter-form>
                    <option value="">@lang('nova-department::app.departments.all_statuses')</option>
                    <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>@lang('nova-department::app.common.active')</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>@lang('nova-department::app.common.inactive')</option>
                </select>
                @if(request()->hasAny(['search','status']))
                    <a href="{{ route('hr.departments.index') }}" class="btn-dept-secondary">@lang('nova-department::app.common.clear_filters')</a>
                @endif
                <button type="submit" class="btn-dept-secondary">
                    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    @lang('nova-department::app.common.search')
                </button>
            </div>
        </form>

        {{-- Table --}}
        <div class="dept-table-card">
            <div class="dept-table-header">
                <div>
                    <span class="dept-table-title">@lang('nova-department::app.departments.list_title')</span>
                    <span class="dept-table-count" style="margin-left:8px">{{ __('nova-department::app.common.department_count', ['count' => $departments->total()]) }}</span>
                </div>
            </div>

            @if($departments->isEmpty())
                <div class="dept-empty">
                    <div class="dept-empty-icon">
                        <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                    </div>
                    <div class="dept-empty-title">@lang('nova-department::app.departments.empty_title')</div>
                    <div class="dept-empty-desc">@lang('nova-department::app.departments.empty_description')</div>
                    <a href="{{ route('hr.departments.create') }}" class="btn-dept-primary" style="margin-top:4px">
                        <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        @lang('nova-department::app.departments.add_button')
                    </a>
                </div>
            @else
                <table class="dept-table">
                    <thead>
                        <tr>
                            <th>@lang('nova-department::app.departments.table.department')</th>
                            <th>@lang('nova-department::app.departments.table.code')</th>
                            <th>@lang('nova-department::app.departments.table.parent')</th>
                            <th>@lang('nova-department::app.departments.table.manager')</th>
                            <th>@lang('nova-department::app.departments.table.employees')</th>
                            <th>@lang('nova-department::app.departments.table.status')</th>
                            <th style="text-align:right">@lang('nova-department::app.departments.table.actions')</th>
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
                                        <span style="color:#cbd5e1;font-size:12px">@lang('nova-department::app.departments.no_manager')</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="dept-badge dept-badge-blue">{{ __('nova-department::app.common.people_count', ['count' => $dept->employee_count]) }}</span>
                                </td>
                                <td>
                                    <span class="dept-badge {{ $dept->status === 'active' ? 'dept-badge-active' : 'dept-badge-inactive' }}">
                                        <span class="dept-status-dot {{ $dept->status }}"></span>
                                        {{ $dept->status === 'active' ? __('nova-department::app.common.active') : __('nova-department::app.common.inactive') }}
                                    </span>
                                </td>
                                <td>
                                    <div class="dept-table-actions">
                                        <a href="{{ route('hr.departments.show', $dept) }}" class="btn-dept-icon view" title="@lang('nova-department::app.common.view_details')">
                                            <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </a>
                                        <a href="{{ route('hr.departments.edit', $dept) }}" class="btn-dept-icon edit" title="@lang('nova-department::app.common.edit')">
                                            <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        </a>

                                        <form id="delete-dept-{{ $dept->id }}" method="POST"
                                              action="{{ route('hr.departments.destroy', $dept) }}" style="display:none">
                                            @csrf @method('DELETE')
                                        </form>
                                        <button type="button" class="btn-dept-icon delete" title="@lang('nova-department::app.common.delete')"
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
                            {{ __('nova-department::app.common.showing_range', ['from' => $departments->firstItem(), 'to' => $departments->lastItem()]) }}
                            {{ __('nova-department::app.common.of_total', ['total' => __('nova-department::app.common.department_count', ['count' => $departments->total()])]) }}
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
