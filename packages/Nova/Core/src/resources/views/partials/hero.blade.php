<!-- HERO -->
<section class="hero">
    <div class="hero-glow-1"></div>
    <div class="hero-glow-2"></div>
    <div class="hero-glow-3"></div>

    <div class="hero-content">
        <div class="hero-badge">
            <span class="hero-badge-dot"></span>
            @lang('nova-core::app.hero.badge')
        </div>
        <h1 class="hero-title">
            <span class="line-blue">@lang('nova-core::app.hero.title.line1_blue') </span><span class="line-white" style="display:inline">@lang('nova-core::app.hero.title.line1_white')</span>
            <span class="line-white">@lang('nova-core::app.hero.title.line2_white') <span class="line-blue">@lang('nova-core::app.hero.title.line2_blue')</span></span>
            <span class="line-white">@lang('nova-core::app.hero.title.line3_white') <span class="line-blue">@lang('nova-core::app.hero.title.line3_blue')</span></span>
        </h1>
        <p class="hero-desc">@lang('nova-core::app.hero.desc')</p>
        <div class="hero-btns">
            <a href="#" class="btn-hero-fill" data-demo="open">
                @lang('nova-core::app.hero.btn_demo')
                <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            <a href="#features" class="btn-hero-ghost">@lang('nova-core::app.hero.btn_features')</a>
        </div>
    </div>

    <div class="hero-preview">
        <div class="hbm-stage">
            <div class="hbm-glow-l"></div>
            <div class="hbm-glow-r"></div>

            <div class="hbm-panel hbm-panel-left">
                <div class="hbm-mobile">
                    <div class="hbm-mob-notch"></div>

                    <!-- header -->
                    <div class="hbm-mob-header">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        <div class="hbm-mob-search">
                            <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                        </div>
                        <div class="hbm-mob-notifbtn">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                            <div class="hbm-notif-badge"></div>
                        </div>
                    </div>

                    <!-- breadcrumb -->
                    <div class="hbm-mob-breadcrumb">
                        <span style="color:var(--text-dim)">@lang('nova-core::app.hero.preview.breadcrumb_list')</span>
                        <svg width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m9 18 6-6-6-6"/></svg>
                        <span style="color:#60A5FA">@lang('nova-core::app.hero.preview.breadcrumb_detail')</span>
                    </div>

                    <!-- employee mini card -->
                    <div class="hbm-mob-emp">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        <div>
                            <div style="font-size:9px;font-weight:800;color:#fff;line-height:1.2">@lang('nova-core::app.hero.preview.emp_name')</div>
                            <div style="font-size:7.5px;color:#60A5FA">@lang('nova-core::app.hero.preview.emp_position')</div>
                        </div>
                        <div class="hbm-mob-live">● @lang('nova-core::app.hero.preview.live')</div>
                    </div>

                    <!-- todo label -->
                    <div class="hbm-mob-section-label">@lang('nova-core::app.hero.preview.work_history')</div>

                    <!-- timeline items -->
                    <div class="hbm-mob-timeline">
                        <div class="hbm-tl-item">
                            <div class="hbm-tl-dot" style="background:#60A5FA"></div>
                            <div class="hbm-tl-content">
                                <div class="hbm-tl-title">@lang('nova-core::app.hero.preview.tl_date')</div>
                                <div class="hbm-tl-sub">@lang('nova-core::app.hero.preview.tl_hours')</div>
                            </div>
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#60A5FA" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </div>
                        <div class="hbm-tl-item hbm-tl-warn">
                            <div class="hbm-tl-dot" style="background:#f87171"></div>
                            <div class="hbm-tl-content">
                                <div class="hbm-tl-title" style="color:#f87171">@lang('nova-core::app.hero.preview.tl_leave_warn')</div>
                                <div class="hbm-tl-sub">@lang('nova-core::app.hero.preview.tl_leave_sub')</div>
                            </div>
                            <span style="font-size:11px">❤️</span>
                        </div>
                    </div>

                    <!-- quick menu 2x2 -->
                    <div class="hbm-mob-section-label" style="margin-top:6px">@lang('nova-core::app.hero.preview.quick_actions')</div>
                    <div class="hbm-mob-quickgrid">
                        <div class="hbm-mob-qi">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#60A5FA" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            <span>@lang('nova-core::app.hero.preview.qi_profile')</span>
                        </div>
                        <div class="hbm-mob-qi active">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#60A5FA" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                            <span>@lang('nova-core::app.hero.preview.qi_payroll')</span>
                        </div>
                        <div class="hbm-mob-qi">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#60A5FA" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            <span>@lang('nova-core::app.hero.preview.qi_checkin')</span>
                        </div>
                        <div class="hbm-mob-qi">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#60A5FA" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                            <span>@lang('nova-core::app.hero.preview.qi_leave')</span>
                        </div>
                    </div>

                    <!-- bảng lương mini -->
                    <div class="hbm-mob-section-label" style="margin-top:8px">@lang('nova-core::app.hero.preview.your_payroll')</div>
                    <div class="hbm-mob-payroll">
                        <div class="hbm-payroll-tag">@lang('nova-core::app.hero.preview.payroll_tag')</div>
                        <div class="hbm-payroll-val">@lang('nova-core::app.hero.preview.payroll_val')</div>
                        <div class="hbm-payroll-bar-wrap">
                            <div class="hbm-payroll-bar"></div>
                        </div>
                    </div>

                    <!-- bottom nav -->
                    <div class="hbm-mob-bottomnav">
                        <div class="hbm-bn-item active">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            <span>@lang('nova-core::app.hero.preview.nav_profile')</span>
                        </div>
                        <div class="hbm-bn-item">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            <span>@lang('nova-core::app.hero.preview.nav_payroll')</span>
                        </div>
                        <div class="hbm-bn-item">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            <span>@lang('nova-core::app.hero.preview.nav_policy')</span>
                        </div>
                        <div class="hbm-bn-item">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/></svg>
                            <span>@lang('nova-core::app.hero.preview.nav_leave')</span>
                        </div>
                        <div class="hbm-bn-item">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
                            <span>@lang('nova-core::app.hero.preview.nav_settings')</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ── PANEL GIỮA: Desktop App ── -->
            <div class="hbm-panel hbm-panel-center">
                <div class="hbm-desktop">
                    <!-- topbar -->
                    <div class="hbm-desk-topbar">
                        <div class="hbm-desk-logo">
                            <div class="hbm-desk-logo-icon">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="white"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                            </div>
                            <span style="font-size:12px;font-weight:800;color:#60A5FA">Base</span>
                            <span style="font-size:12px;font-weight:800;color:#fff">HRM</span>
                        </div>
                        <div style="display:flex;align-items:center;gap:5px">
                            <div style="font-size:9px;color:var(--text-dim)">◀</div>
                            <div style="font-size:9px;color:var(--text-dim)">@lang('nova-core::app.hero.preview.desk_breadcrumb')</div>
                        </div>
                        <div style="display:flex;align-items:center;gap:8px;margin-left:auto">
                            <div style="width:6px;height:6px;border-radius:50%;background:#22c55e;box-shadow:0 0 6px #22c55e"></div>
                            <span style="font-size:9px;color:#22c55e;font-weight:700">@lang('nova-core::app.hero.preview.online')</span>
                        </div>
                    </div>

                    <div class="hbm-desk-body">
                        <!-- Sidebar -->
                        <div class="hbm-desk-sidebar">
                            <div class="hbm-ds-item">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                <span>@lang('nova-core::app.hero.preview.sidebar.personal_info')</span>
                            </div>
                            <div class="hbm-ds-item hbm-ds-active">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                                <span>@lang('nova-core::app.hero.preview.sidebar.job_info')</span>
                            </div>
                            <div class="hbm-ds-item">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                <span>@lang('nova-core::app.hero.preview.sidebar.salary')</span>
                            </div>
                            <div class="hbm-ds-item">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/></svg>
                                <span>@lang('nova-core::app.hero.preview.sidebar.leave_list')</span>
                            </div>
                            <div class="hbm-ds-item">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                <span>@lang('nova-core::app.hero.preview.sidebar.achievements')</span>
                            </div>
                            <div class="hbm-ds-item">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/></svg>
                                <span>@lang('nova-core::app.hero.preview.sidebar.violations')</span>
                            </div>
                            <div class="hbm-ds-item">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                                <span>@lang('nova-core::app.hero.preview.sidebar.review')</span>
                            </div>
                        </div>

                        <!-- Main Content -->
                        <div class="hbm-desk-main">
                            <div class="hbm-desk-page-title">@lang('nova-core::app.hero.preview.desk_page_title')</div>

                            <!-- Employee header row -->
                            <div class="hbm-emp-headerrow" style="gap:5px">
                                <div class="hbm-emp-av-lg">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                        <circle cx="12" cy="7" r="4"/>
                                    </svg>
                                </div>
                                <div>
                                    <div style="font-size:13px;font-weight:800;color:#fff">@lang('nova-core::app.hero.preview.emp_name')</div>
                                    <div style="font-size:9px;color:#60A5FA;margin-top:1px">@lang('nova-core::app.hero.preview.emp_position')</div>
                                    <div style="font-size:8px;color:var(--text-dim);margin-top:2px">● @lang('nova-core::app.hero.preview.emp_tenure')</div>
                                </div>
                                <div style="display:flex;gap:5px;align-items:center;margin-left:auto">
                                    <div class="hbm-action-btn">@lang('nova-core::app.hero.preview.btn_edit_job')</div>
                                    <div class="hbm-action-btn hbm-action-primary">@lang('nova-core::app.hero.preview.btn_edit_salary') ▾</div>
                                </div>
                            </div>

                            <!-- Section: THÔNG TIN CÔNG VIỆC -->
                            <div class="hbm-section-label">@lang('nova-core::app.hero.preview.section_job_info')</div>
                            <div class="hbm-info-grid6">
                                <div class="hbm-ig-item"><div class="hbm-ig-label">@lang('nova-core::app.hero.preview.job.position')</div><div class="hbm-ig-val">@lang('nova-core::app.hero.preview.emp_position')</div></div>
                                <div class="hbm-ig-item"><div class="hbm-ig-label">@lang('nova-core::app.hero.preview.job.office')</div><div class="hbm-ig-val">🌐 @lang('nova-core::app.hero.preview.job.office_val')</div></div>
                                <div class="hbm-ig-item"><div class="hbm-ig-label">@lang('nova-core::app.hero.preview.job.type')</div><div class="hbm-ig-val">@lang('nova-core::app.hero.preview.job.type_val')</div></div>
                                <div class="hbm-ig-item"><div class="hbm-ig-label">@lang('nova-core::app.hero.preview.job.area')</div><div class="hbm-ig-val">📦 @lang('nova-core::app.hero.preview.job.area_val')</div></div>
                                <div class="hbm-ig-item"><div class="hbm-ig-label">@lang('nova-core::app.hero.preview.job.salary_policy')</div><div class="hbm-ig-val">🏠 @lang('nova-core::app.hero.preview.job.salary_policy_val')</div></div>
                                <div class="hbm-ig-item"><div class="hbm-ig-label">@lang('nova-core::app.hero.preview.job.start_date')</div><div class="hbm-ig-val">@lang('nova-core::app.hero.preview.job.start_date_val')</div></div>
                                <div class="hbm-ig-item"><div class="hbm-ig-label">@lang('nova-core::app.hero.preview.job.official_date')</div><div class="hbm-ig-val">@lang('nova-core::app.hero.preview.job.official_date_val')</div></div>
                                <div class="hbm-ig-item"><div class="hbm-ig-label">@lang('nova-core::app.hero.preview.job.schedule')</div><div class="hbm-ig-val">📅 @lang('nova-core::app.hero.preview.job.schedule_val')</div></div>
                                <div class="hbm-ig-item"><div class="hbm-ig-label">@lang('nova-core::app.hero.preview.job.gross')</div><div class="hbm-ig-val">@lang('nova-core::app.hero.preview.job.gross_val')</div></div>
                                <div class="hbm-ig-item"><div class="hbm-ig-label">@lang('nova-core::app.hero.preview.job.basic')</div><div class="hbm-ig-val" style="color:#22c55e;font-weight:700">@lang('nova-core::app.hero.preview.job.basic_val')</div></div>
                            </div>

                            <!-- Section: THÀNH TỰU -->
                            <div class="hbm-section-label" style="margin-top:10px">@lang('nova-core::app.hero.preview.section_achievements')</div>
                            <div class="hbm-achievements">
                                @foreach (__('nova-core::app.hero.preview.achievement_list') as $ach)
                                <div class="hbm-ach-item">
                                    <div class="hbm-ach-icon">{{ $ach['icon'] }}</div>
                                    <div class="hbm-ach-label">{{ $ach['label'] }}</div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ── PANEL PHẢI: Salary Card ── -->
            <div class="hbm-panel hbm-panel-right">
                <div class="hbm-salary-card">
                    <!-- header -->
                    <div class="hbm-sal-header">
                        <div style="display:flex;align-items:center;gap:6px">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#60A5FA" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><rect x="9" y="7" width="6" height="14"/></svg>
                            <span style="font-size:11px;font-weight:700;color:#e0eeff">@lang('nova-core::app.hero.preview.sal_header')</span>
                        </div>
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="var(--text-dim)" stroke-width="2"><path d="m18 15-6-6-6 6"/></svg>
                    </div>

                    <!-- tabs -->
                    <div class="hbm-sal-tabs">
                        <div class="hbm-sal-tab active">@lang('nova-core::app.hero.preview.sal_tab_overview')</div>
                        <div class="hbm-sal-tab">@lang('nova-core::app.hero.preview.sal_tab_allowance')</div>
                        <div class="hbm-sal-tab">@lang('nova-core::app.hero.preview.sal_tab_benefit')</div>
                    </div>

                    <!-- big number -->
                    <div class="hbm-sal-label">@lang('nova-core::app.hero.preview.sal_label')</div>
                    <div class="hbm-sal-big">@lang('nova-core::app.hero.preview.sal_amount')<span class="hbm-sal-unit">@lang('nova-core::app.hero.preview.sal_unit')</span></div>
                    <div class="hbm-sal-payroll-tag">
                        <span class="hbm-live-dot"></span>
                        @lang('nova-core::app.hero.preview.payroll_tag')
                    </div>

                    <!-- line chart -->
                    <div class="hbm-sal-chart-wrap">
                        <svg class="hbm-line-chart" viewBox="0 0 200 70" preserveAspectRatio="none">
                            <defs>
                                <linearGradient id="salGrad" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="#60A5FA" stop-opacity="0.35"/>
                                    <stop offset="100%" stop-color="#60A5FA" stop-opacity="0"/>
                                </linearGradient>
                            </defs>
                            <path d="M0,55 C20,50 40,45 60,40 C80,35 100,38 120,30 C140,22 160,28 200,10 L200,70 L0,70 Z" fill="url(#salGrad)"/>
                            <path d="M0,55 C20,50 40,45 60,40 C80,35 100,38 120,30 C140,22 160,28 200,10" fill="none" stroke="#60A5FA" stroke-width="1.5" stroke-linecap="round"/>
                            <circle cx="0"   cy="55" r="2.5" fill="#60A5FA"/>
                            <circle cx="40"  cy="45" r="2.5" fill="#60A5FA"/>
                            <circle cx="80"  cy="35" r="2.5" fill="#60A5FA"/>
                            <circle cx="120" cy="30" r="2.5" fill="#60A5FA"/>
                            <circle cx="160" cy="28" r="2.5" fill="#60A5FA"/>
                            <circle cx="200" cy="10" r="3.5" fill="#60A5FA" opacity="1"/>
                            <circle cx="200" cy="10" r="6"   fill="#60A5FA" opacity="0.25"/>
                        </svg>
                        <div class="hbm-chart-axis">
                            @foreach (__('nova-core::app.hero.preview.chart_months') as $m)
                                <span>{{ $m }}</span>
                            @endforeach
                        </div>
                    </div>

                    <!-- breakdown -->
                    <div class="hbm-sal-rows">
                        <div class="hbm-sal-row">
                            <div style="display:flex;align-items:center;gap:5px">
                                <div style="width:6px;height:6px;border-radius:50%;background:#60A5FA;flex-shrink:0"></div>
                                <span>@lang('nova-core::app.hero.preview.sal_basic')</span>
                            </div>
                            <span style="color:#e0eeff">@lang('nova-core::app.hero.preview.sal_basic_val')</span>
                        </div>
                        <div class="hbm-sal-row">
                            <div style="display:flex;align-items:center;gap:5px">
                                <div style="width:6px;height:6px;border-radius:50%;background:#22c55e;flex-shrink:0"></div>
                                <span>@lang('nova-core::app.hero.preview.sal_allowance')</span>
                            </div>
                            <span style="color:#22c55e">@lang('nova-core::app.hero.preview.sal_allowance_val')</span>
                        </div>
                        <div class="hbm-sal-row">
                            <div style="display:flex;align-items:center;gap:5px">
                                <div style="width:6px;height:6px;border-radius:50%;background:#f87171;flex-shrink:0"></div>
                                <span>@lang('nova-core::app.hero.preview.sal_tax')</span>
                            </div>
                            <span style="color:#f87171">@lang('nova-core::app.hero.preview.sal_tax_val')</span>
                        </div>
                    </div>

                    <!-- mini progress bars -->
                    <div class="hbm-sal-progress">
                        <div style="font-size:8px;color:var(--text-dim);margin-bottom:5px;font-weight:700;letter-spacing:0.5px">@lang('nova-core::app.hero.preview.sal_distribution')</div>
                        <div class="hbm-sal-progress-bar-wrap">
                            <div style="height:100%;width:83%;background:linear-gradient(90deg,#1565C0,#60A5FA);border-radius:4px 0 0 4px"></div>
                            <div style="height:100%;width:17%;background:rgba(96,165,250,0.2);border-radius:0 4px 4px 0"></div>
                        </div>
                        <div style="display:flex;justify-content:space-between;margin-top:4px">
                            <span style="font-size:7.5px;color:#60A5FA">@lang('nova-core::app.hero.preview.sal_net_pct')</span>
                            <span style="font-size:7.5px;color:var(--text-dim)">@lang('nova-core::app.hero.preview.sal_deduct_pct')</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>