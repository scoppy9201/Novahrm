@extends('nova-dashboard::layouts')

@section('title', __('org-chart::app.page_title'))

@section('styles')
    @vite([
        'app/packages/Nova/Dashboard/src/resources/css/app.css',
        'app/packages/Nova/OrgChart/src/resources/css/app.css',
    ])
@endsection

@section('content')
    {{-- Topbar --}}
    <header class="orgchart-topbar">
        <div class="orgchart-topbar-row1">
            <div>
                <div class="orgchart-breadcrumb">
                    <a href="{{ route('dashboard') }}">@lang('org-chart::app.dashboard')</a>
                    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    <a href="#">@lang('org-chart::app.suite')</a>
                    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    <span>@lang('org-chart::app.heading')</span>
                </div>
                <div class="orgchart-page-title">@lang('org-chart::app.heading')</div>
            </div>
            <div class="orgchart-actions">
                <button class="btn-orgchart-icon" id="btn-export-png" title="@lang('org-chart::app.actions.export_png')">
                    <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                </button>
                <button class="btn-orgchart-icon" id="btn-fullscreen" title="@lang('org-chart::app.actions.fullscreen')">
                    <svg viewBox="0 0 24 24"><path d="M8 3H5a2 2 0 0 0-2 2v3"/><path d="M21 8V5a2 2 0 0 0-2-2h-3"/><path d="M3 16v3a2 2 0 0 0 2 2h3"/><path d="M16 21h3a2 2 0 0 0 2-2v-3"/></svg>
                </button>
                <button class="btn-orgchart-primary" id="btn-add-dept">
                    <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    @lang('org-chart::app.actions.add_department')
                </button>
            </div>
        </div>

        <div class="orgchart-topbar-tabs">
            <div class="orgchart-tab active" data-tab="so-do">@lang('org-chart::app.tabs.chart')</div>
            <div class="orgchart-tab" data-tab="danh-sach">@lang('org-chart::app.tabs.list')</div>
        </div>
    </header>

    {{-- Toolbar (chỉ hiện khi tab Sơ đồ) --}}
    <div class="orgchart-toolbar" id="orgchart-toolbar">
        <div class="orgchart-search">
            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" id="orgchart-search-input" placeholder="@lang('org-chart::app.toolbar.search_all')" autocomplete="off"/>
        </div>

        <select class="orgchart-select" id="orgchart-filter-dept">
            <option value="">@lang('org-chart::app.toolbar.all_departments')</option>
        </select>

        <div class="orgchart-toolbar-sep"></div>

        <div class="orgchart-toolbar-right">
            <div class="orgchart-view-toggle">
                <button class="orgchart-view-btn active" data-view="vertical" title="@lang('org-chart::app.toolbar.vertical')">
                    <svg viewBox="0 0 24 24"><line x1="12" y1="2" x2="12" y2="22"/><path d="M17 7l-5-5-5 5"/><path d="M17 17l-5 5-5-5"/></svg>
                </button>
                <button class="orgchart-view-btn" data-view="horizontal" title="@lang('org-chart::app.toolbar.horizontal')">
                    <svg viewBox="0 0 24 24"><line x1="2" y1="12" x2="22" y2="12"/><path d="M7 7l-5 5 5 5"/><path d="M17 7l5 5-5 5"/></svg>
                </button>
                <button class="orgchart-view-btn" data-view="compact" title="@lang('org-chart::app.toolbar.compact')">
                    <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                </button>
            </div>
            <button class="btn-orgchart-icon" id="btn-fit-screen" title="@lang('org-chart::app.actions.fit_screen')">
                <svg viewBox="0 0 24 24"><path d="M15 3h6v6"/><path d="M9 21H3v-6"/><path d="M21 3l-7 7"/><path d="M3 21l7-7"/></svg>
            </button>
            <button class="btn-orgchart-icon" id="btn-collapse-all" title="@lang('org-chart::app.actions.collapse_all')">
                <svg viewBox="0 0 24 24"><polyline points="4 14 10 14 10 20"/><polyline points="20 10 14 10 14 4"/><line x1="10" y1="14" x2="21" y2="3"/><line x1="3" y1="21" x2="14" y2="10"/></svg>
            </button>
        </div>
    </div>

    {{-- Toolbar danh sách (chỉ hiện khi tab Danh sách) --}}
    <div class="orgchart-toolbar" id="list-toolbar" style="display:none;">
        <div class="orgchart-search">
            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" id="list-search-input" placeholder="@lang('org-chart::app.toolbar.search_departments')" autocomplete="off"/>
        </div>
        <select class="orgchart-select" id="list-filter-level">
            <option value="">@lang('org-chart::app.toolbar.all_levels')</option>
            <option value="0">@lang('org-chart::app.toolbar.level_1')</option>
            <option value="1">@lang('org-chart::app.toolbar.level_2')</option>
            <option value="2">@lang('org-chart::app.toolbar.level_3')</option>
        </select>
        <div class="orgchart-toolbar-right" style="margin-left:auto;">
            <span id="list-count" style="font-size:12px; color:#94a3b8; font-weight:600;"></span>
        </div>
    </div>

    {{-- Section: Sơ đồ --}}
    <div id="section-so-do" style="flex:1; overflow:hidden; display:flex; flex-direction:column;">
        <div class="orgchart-body" id="orgchart-body">
            <div class="orgchart-loading" id="orgchart-loading">
                <div class="orgchart-spinner"></div>
                <div class="orgchart-loading-text">@lang('org-chart::app.loading')</div>
            </div>
            <div class="orgchart-canvas" id="orgchart-canvas"></div>
            <div class="orgchart-zoom-controls">
                <button class="orgchart-zoom-btn" id="btn-zoom-in" title="@lang('org-chart::app.zoom_in')">+</button>
                <div class="orgchart-zoom-label" id="zoom-label">100%</div>
                <button class="orgchart-zoom-btn" id="btn-zoom-out" title="@lang('org-chart::app.zoom_out')">−</button>
            </div>
        </div>
    </div>

    {{-- Section: Danh sách --}}
    <div id="section-danh-sach" style="display:none; flex:1; overflow:auto; width:100%;">
        <div class="orgchart-list-wrap">
            <table class="orgchart-table">
                <thead>
                    <tr>
                        <th>@lang('org-chart::app.table.department')</th>
                        <th>@lang('org-chart::app.table.manager')</th>
                        <th>@lang('org-chart::app.table.employees')</th>
                        <th>@lang('org-chart::app.table.children')</th>
                        <th>@lang('org-chart::app.table.level')</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="orgchart-table-body"></tbody>
            </table>
            <div class="orgchart-list-empty" id="list-empty" style="display:none;">
                <div class="orgchart-empty-icon">
                    <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                </div>
                <div class="orgchart-empty-text">@lang('org-chart::app.empty.title')</div>
                <div class="orgchart-empty-sub">@lang('org-chart::app.empty.description')</div>
            </div>
        </div>
    </div>

    @include('org-chart::actions.create')
    @include('org-chart::actions.edit')
    
    {{-- Drawer overlay --}}
    <div class="orgchart-drawer-overlay" id="drawer-overlay"></div>

    {{-- Drawer chi tiết --}}
    <div class="orgchart-drawer" id="orgchart-drawer">
        <div class="orgchart-drawer-header">
            <div class="orgchart-drawer-title" id="drawer-title">@lang('org-chart::app.drawer.title')</div>
            <button class="orgchart-drawer-close" id="drawer-close">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="orgchart-drawer-body" id="drawer-body"></div>
        <div class="orgchart-drawer-footer" id="drawer-footer"></div>
    </div>

@endsection

@section('scripts')
    @vite([
        'app/packages/Nova/OrgChart/src/resources/js/app.js',
    ])
    <script>
        window.__orgChartConfig = {
            treeUrl:   '{{ route('org-chart.tree') }}',
            chainUrl:  '{{ route('org-chart.employee.chain', ['employee' => '__ID__']) }}',
            storeUrl:  '{{ route('org-chart.department.store') }}',
            updateUrl: '{{ route('org-chart.department.update', ['department' => '__ID__']) }}',
            deleteUrl: '{{ route('org-chart.department.destroy', ['department' => '__ID__']) }}',
            moveUrl:   '{{ route('org-chart.department.move', ['department' => '__ID__']) }}',
            csrfToken: '{{ csrf_token() }}',
        };
    </script>
@endsection
