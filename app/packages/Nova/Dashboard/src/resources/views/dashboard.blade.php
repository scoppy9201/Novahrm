@extends('nova-dashboard::layouts')

@section('title', __('nova-dashboard::app.title'))

@section('styles')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    @vite([
        'app/packages/Nova/Dashboard/src/resources/css/app.css',
        'app/packages/Nova/Dashboard/src/resources/js/app.js',
    ])
@endsection

@section('content')

    {{-- Topbar 2 hàng --}}
    <header class="topbar">
        <div class="topbar-row1">
            <div class="topbar-title">@lang('nova-dashboard::app.employees')</div>

            <div class="topbar-actions">
                <div class="topbar-search">
                    <svg viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>

                    <input type="text" placeholder="@lang('nova-dashboard::app.search_placeholder')"/>
                </div>

                <button class="btn-icon" title="@lang('nova-dashboard::app.notifications')">
                    <svg viewBox="0 0 24 24">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                </button>

                <a href="{{ route('hr.employees.create') }}" class="btn-primary">
                    <svg viewBox="0 0 24 24">
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>

                    @lang('nova-dashboard::app.add_employee')
                </a>
            </div>
        </div>

        <div class="topbar-tabs">
            <div class="topbar-tab active">@lang('nova-dashboard::app.employee_tab')</div>
            <a href="{{ route('org-chart.index') }}" class="topbar-tab" style="text-decoration:none">
                @lang('nova-dashboard::app.org_chart_tab')
            </a>
            <div class="topbar-tab">@lang('nova-dashboard::app.hrm_app_tab')</div>
        </div>
    </header>

    {{-- Page body --}}
    <div class="page-body">

        <div class="charts-row">

            <div class="chart-card">
                <div class="chart-card-top">
                    <div class="chart-card-info">
                        <div class="chart-label">@lang('nova-dashboard::app.total_employees')</div>
                        <div class="chart-val">1,284</div>
                        <div class="chart-tag tag-green">@lang('nova-dashboard::app.today_increase')</div>
                    </div>

                    <div class="chart-icon icon-green">
                        <svg viewBox="0 0 24 24">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>
                </div>

                <div class="chart-canvas-wrap">
                    <canvas id="chart1"></canvas>
                </div>
            </div>

            <div class="chart-card">
                <div class="chart-card-top">
                    <div class="chart-card-info">
                        <div class="chart-label">@lang('nova-dashboard::app.active_employees')</div>
                        <div class="chart-val">1,247</div>
                        <div class="chart-tag tag-blue">@lang('nova-dashboard::app.active_rate')</div>
                    </div>

                    <div class="chart-icon icon-blue">
                        <svg viewBox="0 0 24 24">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                        </svg>
                    </div>
                </div>

                <div class="chart-canvas-wrap">
                    <canvas id="chart2"></canvas>
                </div>
            </div>

            <div class="chart-card">
                <div class="chart-card-top">
                    <div class="chart-card-info">
                        <div class="chart-label">@lang('nova-dashboard::app.attendance_today')</div>
                        <div class="chart-val">96.4%</div>
                        <div class="chart-tag tag-green">@lang('nova-dashboard::app.on_time')</div>
                    </div>

                    <div class="chart-icon icon-amber">
                        <svg viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                    </div>
                </div>

                <div class="chart-canvas-wrap">
                    <canvas id="chart3"></canvas>
                </div>
            </div>

            <div class="chart-card">
                <div class="chart-card-top">
                    <div class="chart-card-info">
                        <div class="chart-label">@lang('nova-dashboard::app.monthly_salary')</div>
                        <div class="chart-val">2.4 tỷ</div>
                        <div class="chart-tag tag-amber">@lang('nova-dashboard::app.processed')</div>
                    </div>

                    <div class="chart-icon icon-purple">
                        <svg viewBox="0 0 24 24">
                            <line x1="12" y1="1" x2="12" y2="23"/>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                        </svg>
                    </div>
                </div>

                <div class="chart-canvas-wrap">
                    <canvas id="chart4"></canvas>
                </div>
            </div>

        </div>

        <div class="sub-tabs-bar">
            <div class="sub-tab active">@lang('nova-dashboard::app.overview')</div>
            <div class="sub-tab">@lang('nova-dashboard::app.salary_promotion')</div>
            <div class="sub-tab">@lang('nova-dashboard::app.proposals')</div>
            <div class="sub-tab">@lang('nova-dashboard::app.groups_management')</div>
            <div class="sub-tab">@lang('nova-dashboard::app.tax_legal')</div>
            <div class="sub-tab">@lang('nova-dashboard::app.attendance_worktime')</div>
            <div class="sub-tab">@lang('nova-dashboard::app.contact_personal')</div>
            <div class="sub-tab">@lang('nova-dashboard::app.probation')</div>
            <div class="sub-tab">@lang('nova-dashboard::app.on_leave')</div>
            <div class="sub-tab danger">@lang('nova-dashboard::app.resigned')</div>
            <div class="sub-tab">@lang('nova-dashboard::app.raw_data')</div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:36px">
                            <input type="checkbox" style="width:13px;height:13px;cursor:pointer"/>
                        </th>

                        <th>@lang('nova-dashboard::app.employee')</th>
                        <th>@lang('nova-dashboard::app.employee_code')</th>
                        <th>@lang('nova-dashboard::app.status')</th>
                        <th>@lang('nova-dashboard::app.job_title')</th>
                        <th>@lang('nova-dashboard::app.manager')</th>

                        <th>
                            <div class="th-inner">
                                @lang('nova-dashboard::app.department')
                                <svg viewBox="0 0 24 24">
                                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
                                </svg>
                            </div>
                        </th>

                        <th>
                            <div class="th-inner">
                                @lang('nova-dashboard::app.office')
                                <svg viewBox="0 0 24 24">
                                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
                                </svg>
                            </div>
                        </th>

                        <th>
                            <div class="th-inner">
                                @lang('nova-dashboard::app.position')
                                <svg viewBox="0 0 24 24">
                                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
                                </svg>
                            </div>
                        </th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td><input type="checkbox" style="width:13px;height:13px;cursor:pointer"/></td>
                        <td><div class="emp-name"><div class="emp-av" style="background:#6366f1">NT</div>Nguyễn Phương Ta</div></td>
                        <td><span class="emp-code">NNV-000</span></td>
                        <td><span class="status-dot dot-gray"></span></td>
                        <td>@lang('nova-dashboard::app.admin')</td>
                        <td>@lang('nova-dashboard::app.none')</td>
                        <td><span class="badge badge-blue">@lang('nova-dashboard::app.sales')</span></td>
                        <td>@lang('nova-dashboard::app.hcm_office')</td>
                        <td>@lang('nova-dashboard::app.none')</td>
                    </tr>

                    <tr>
                        <td><input type="checkbox" style="width:13px;height:13px;cursor:pointer"/></td>
                        <td><div class="emp-name"><div class="emp-av" style="background:#0891b2">LA</div>Lưu Phương Anh</div></td>
                        <td><span class="emp-code">NNV-001</span></td>
                        <td><span class="status-dot dot-green"></span></td>
                        <td>@lang('nova-dashboard::app.ba')</td>
                        <td>@lang('nova-dashboard::app.none')</td>
                        <td><span class="badge badge-blue">@lang('nova-dashboard::app.sales')</span></td>
                        <td>@lang('nova-dashboard::app.hn_office')</td>
                        <td>@lang('nova-dashboard::app.none')</td>
                    </tr>

                    <tr>
                        <td><input type="checkbox" style="width:13px;height:13px;cursor:pointer"/></td>
                        <td><div class="emp-name"><div class="emp-av" style="background:#7c3aed">VP</div>Vũ Phương</div></td>
                        <td><span class="emp-code">NNV-001</span></td>
                        <td><span class="status-dot dot-green"></span></td>
                        <td>@lang('nova-dashboard::app.developer')</td>
                        <td>@lang('nova-dashboard::app.none')</td>
                        <td><span class="badge badge-purple">@lang('nova-dashboard::app.product')</span></td>
                        <td>@lang('nova-dashboard::app.hcm_office')</td>
                        <td>@lang('nova-dashboard::app.none')</td>
                    </tr>

                    <tr>
                        <td><input type="checkbox" style="width:13px;height:13px;cursor:pointer"/></td>
                        <td><div class="emp-name"><div class="emp-av" style="background:#0f766e">LH</div>Lương Đỗ Hà</div></td>
                        <td><span class="emp-code">NNV-002</span></td>
                        <td><span class="status-dot dot-green"></span></td>
                        <td>@lang('nova-dashboard::app.ceo')</td>
                        <td>@lang('nova-dashboard::app.none')</td>
                        <td><span class="badge badge-purple">@lang('nova-dashboard::app.product')</span></td>
                        <td>@lang('nova-dashboard::app.hn_office')</td>
                        <td>@lang('nova-dashboard::app.none')</td>
                    </tr>

                    <tr>
                        <td><input type="checkbox" style="width:13px;height:13px;cursor:pointer"/></td>
                        <td><div class="emp-name"><div class="emp-av" style="background:#b45309">LS</div>Lê Song Trúc</div></td>
                        <td><span class="emp-code">NNV-002</span></td>
                        <td><span class="status-dot dot-green"></span></td>
                        <td>@lang('nova-dashboard::app.cmo')</td>
                        <td>@lang('nova-dashboard::app.none')</td>
                        <td><span class="badge badge-green">@lang('nova-dashboard::app.marketing')</span></td>
                        <td>@lang('nova-dashboard::app.hn_office')</td>
                        <td><span class="badge badge-green">@lang('nova-dashboard::app.cmo')</span></td>
                    </tr>

                    <tr>
                        <td><input type="checkbox" style="width:13px;height:13px;cursor:pointer"/></td>
                        <td><div class="emp-name"><div class="emp-av" style="background:#be185d">BT</div>Bùi Thanh Tâm</div></td>
                        <td><span class="emp-code">NNV-003</span></td>
                        <td><span class="status-dot dot-green"></span></td>
                        <td>@lang('nova-dashboard::app.sales_team_leader')</td>
                        <td>@lang('nova-dashboard::app.none')</td>
                        <td><span class="badge badge-blue">@lang('nova-dashboard::app.sales')</span></td>
                        <td>@lang('nova-dashboard::app.dn_office')</td>
                        <td>@lang('nova-dashboard::app.none')</td>
                    </tr>

                    <tr>
                        <td><input type="checkbox" style="width:13px;height:13px;cursor:pointer"/></td>
                        <td><div class="emp-name"><div class="emp-av" style="background:#1d4ed8">HM</div>Huỳnh Minh Phúc</div></td>
                        <td><span class="emp-code">NNV-004</span></td>
                        <td><span class="status-dot dot-red"></span></td>
                        <td>@lang('nova-dashboard::app.marketing_manager')</td>
                        <td>@lang('nova-dashboard::app.none')</td>
                        <td><span class="badge badge-green">@lang('nova-dashboard::app.marketing')</span></td>
                        <td>@lang('nova-dashboard::app.hcm_office')</td>
                        <td><span class="badge badge-green">@lang('nova-dashboard::app.marketing_manager')</span></td>
                    </tr>

                    <tr>
                        <td><input type="checkbox" style="width:13px;height:13px;cursor:pointer"/></td>
                        <td><div class="emp-name"><div class="emp-av" style="background:#065f46">TB</div>Trần Bá Thần</div></td>
                        <td><span class="emp-code">NNV-005</span></td>
                        <td><span class="status-dot dot-green"></span></td>
                        <td>@lang('nova-dashboard::app.sales_manager')</td>
                        <td>@lang('nova-dashboard::app.none')</td>
                        <td><span class="badge badge-blue">@lang('nova-dashboard::app.sales')</span></td>
                        <td>@lang('nova-dashboard::app.hcm_office')</td>
                        <td><span class="badge badge-blue">@lang('nova-dashboard::app.sales_manager')</span></td>
                    </tr>

                    <tr>
                        <td><input type="checkbox" style="width:13px;height:13px;cursor:pointer"/></td>
                        <td><div class="emp-name"><div class="emp-av" style="background:#7e22ce">TH</div>Trần Thị Tuyết Hồng</div></td>
                        <td><span class="emp-code">NNV-006</span></td>
                        <td><span class="status-dot dot-green"></span></td>
                        <td>@lang('nova-dashboard::app.customer_success_manager')</td>
                        <td>@lang('nova-dashboard::app.none')</td>
                        <td><span class="badge badge-amber">@lang('nova-dashboard::app.customer_success')</span></td>
                        <td>@lang('nova-dashboard::app.hn_office')</td>
                        <td><span class="badge badge-amber">@lang('nova-dashboard::app.customer_success_manager')</span></td>
                    </tr>

                    <tr>
                        <td><input type="checkbox" style="width:13px;height:13px;cursor:pointer"/></td>
                        <td><div class="emp-name"><div class="emp-av" style="background:#0369a1">LL</div>Lê Văn Liêm</div></td>
                        <td><span class="emp-code">NNV-007</span></td>
                        <td><span class="status-dot dot-green"></span></td>
                        <td>@lang('nova-dashboard::app.hr_admin_manager')</td>
                        <td>@lang('nova-dashboard::app.none')</td>
                        <td><span class="badge badge-red">@lang('nova-dashboard::app.back_office')</span></td>
                        <td>@lang('nova-dashboard::app.dn_office')</td>
                        <td><span class="badge badge-red">@lang('nova-dashboard::app.hr_admin_manager')</span></td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
@endsection