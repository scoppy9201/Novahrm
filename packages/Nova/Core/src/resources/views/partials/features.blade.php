<!-- FEATURES -->
<section class="section" id="features">
    <div class="section-inner">
        <div class="reveal" style="text-align:center;margin-bottom:3.5rem">
            <div class="s-eyebrow" style="justify-content:center;display:flex">@lang('nova-core::app.features.eyebrow')</div>
            <h2 class="s-title feat-main-title" style="max-width:100%;text-align:center;font-size:clamp(28px,3.5vw,44px)">
                {!! __('nova-core::app.features.title') !!}
            </h2>
        </div>

        <div class="feat-slider">
            <button class="feat-arrow feat-prev" onclick="featSlide(-1)">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <button class="feat-arrow feat-next" onclick="featSlide(1)">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            </button>

            <div class="feat-slides">

                <!-- Slide 1 -->
                <div class="feat-slide active">
                    <div class="feat-left">
                        <div class="feat-tag">@lang('nova-core::app.features.slides.hrm.tag')</div>
                        <h3 class="feat-title">@lang('nova-core::app.features.slides.hrm.title')</h3>
                        <ul class="feat-list">
                            <li>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                                @lang('nova-core::app.features.slides.hrm.items.0')
                            </li>
                            <li>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                @lang('nova-core::app.features.slides.hrm.items.1')
                            </li>
                            <li>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                                @lang('nova-core::app.features.slides.hrm.items.2')
                            </li>
                        </ul>
                        <div class="feat-btns">
                            <a href="#" class="btn-cta-fill" style="font-size:13px;padding:10px 22px">@lang('nova-core::app.features.btn_detail')</a>
                            <a href="#" class="btn-cta-ghost" style="font-size:13px;padding:10px 22px">@lang('nova-core::app.features.btn_demo')</a>
                        </div>
                    </div>
                    <div class="feat-right">
                        <div class="feat-preview">
                            <div class="fp-header">
                                <span style="font-size:11px;color:var(--text-dim)">@lang('nova-core::app.features.slides.hrm.preview.header')</span>
                                <span style="font-size:10px;color:var(--accent);font-weight:600">@lang('nova-core::app.features.slides.hrm.preview.count')</span>
                            </div>
                            <div style="display:flex;flex-direction:column;gap:8px;margin-top:10px">
                                <div class="fp-row fp-row-header">
                                    <span>@lang('nova-core::app.features.slides.hrm.preview.col_name')</span>
                                    <span>@lang('nova-core::app.features.slides.hrm.preview.col_dept')</span>
                                    <span>@lang('nova-core::app.features.slides.hrm.preview.col_status')</span>
                                </div>
                                @foreach(__('nova-core::app.features.slides.hrm.preview.rows') as $row)
                                <div class="fp-row">
                                    <div style="display:flex;align-items:center;gap:8px">
                                        <div class="fp-avatar" style="background:{{ $row['bg'] }}">{{ $row['abbr'] }}</div>
                                        <span>{{ $row['name'] }}</span>
                                    </div>
                                    <span style="color:var(--text-mid)">{{ $row['dept'] }}</span>
                                    <span class="mini-row-badge {{ $row['badge'] }}">{{ $row['status'] }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="feat-slide">
                    <div class="feat-left">
                        <div class="feat-tag">@lang('nova-core::app.features.slides.attendance.tag')</div>
                        <h3 class="feat-title">@lang('nova-core::app.features.slides.attendance.title')</h3>
                        <ul class="feat-list">
                            <li>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                @lang('nova-core::app.features.slides.attendance.items.0')
                            </li>
                            <li>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                @lang('nova-core::app.features.slides.attendance.items.1')
                            </li>
                            <li>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                                @lang('nova-core::app.features.slides.attendance.items.2')
                            </li>
                        </ul>
                        <div class="feat-btns">
                            <a href="#" class="btn-cta-fill" style="font-size:13px;padding:10px 22px">@lang('nova-core::app.features.btn_detail')</a>
                            <a href="#" class="btn-cta-ghost" style="font-size:13px;padding:10px 22px">@lang('nova-core::app.features.btn_demo')</a>
                        </div>
                    </div>
                    <div class="feat-right">
                        <div class="feat-preview">
                            <div class="fp-header">
                                <span style="font-size:11px;color:var(--text-dim)">@lang('nova-core::app.features.slides.attendance.preview.header')</span>
                                <span style="font-size:10px;color:#22c55e;font-weight:600">@lang('nova-core::app.features.slides.attendance.preview.rate')</span>
                            </div>
                            <div style="display:flex;align-items:flex-end;gap:8px;height:100px;margin-top:16px">
                                @foreach(__('nova-core::app.features.slides.attendance.preview.bars') as $bar)
                                <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:5px">
                                    <span style="font-size:8px;color:{{ $bar['active'] ? 'var(--accent)' : 'var(--text-dim)' }}">{{ $bar['label'] }}</span>
                                    <div style="width:100%;height:{{ $bar['height'] }};background:{{ $bar['active'] ? 'linear-gradient(180deg,#60A5FA,#1976D2)' : 'linear-gradient(180deg,#2196F3,#1565C0)' }};border-radius:4px 4px 0 0;{{ $bar['active'] ? 'box-shadow:0 0 12px rgba(96,165,250,0.4)' : ($bar['opacity'] ?? '') }}"></div>
                                </div>
                                @endforeach
                            </div>
                            <div style="display:flex;gap:10px;margin-top:14px">
                                @foreach(__('nova-core::app.features.slides.attendance.preview.stats') as $stat)
                                <div style="flex:1;background:{{ $stat['bg'] }};border:1px solid {{ $stat['border'] }};border-radius:8px;padding:8px 10px">
                                    <div style="font-size:9px;color:var(--text-dim)">{{ $stat['label'] }}</div>
                                    <div style="font-size:16px;font-weight:800;color:{{ $stat['color'] }}">{{ $stat['value'] }}</div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="feat-slide">
                    <div class="feat-left">
                        <div class="feat-tag">@lang('nova-core::app.features.slides.payroll.tag')</div>
                        <h3 class="feat-title">@lang('nova-core::app.features.slides.payroll.title')</h3>
                        <ul class="feat-list">
                            <li>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                @lang('nova-core::app.features.slides.payroll.items.0')
                            </li>
                            <li>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                @lang('nova-core::app.features.slides.payroll.items.1')
                            </li>
                            <li>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                @lang('nova-core::app.features.slides.payroll.items.2')
                            </li>
                        </ul>
                        <div class="feat-btns">
                            <a href="#" class="btn-cta-fill" style="font-size:13px;padding:10px 22px">@lang('nova-core::app.features.btn_detail')</a>
                            <a href="#" class="btn-cta-ghost" style="font-size:13px;padding:10px 22px">@lang('nova-core::app.features.btn_demo')</a>
                        </div>
                    </div>
                    <div class="feat-right">
                        <div class="feat-preview">
                            <div class="fp-header">
                                <span style="font-size:11px;color:var(--text-dim)">@lang('nova-core::app.features.slides.payroll.preview.header')</span>
                                <span style="font-size:10px;color:#22c55e;font-weight:600">@lang('nova-core::app.features.slides.payroll.preview.status')</span>
                            </div>
                            <div style="display:flex;flex-direction:column;gap:7px;margin-top:10px">
                                <div class="fp-row fp-row-header">
                                    <span>@lang('nova-core::app.features.slides.payroll.preview.col_name')</span>
                                    <span>@lang('nova-core::app.features.slides.payroll.preview.col_basic')</span>
                                    <span>@lang('nova-core::app.features.slides.payroll.preview.col_net')</span>
                                </div>
                                @foreach(__('nova-core::app.features.slides.payroll.preview.rows') as $row)
                                <div class="fp-row">
                                    <div style="display:flex;align-items:center;gap:8px">
                                        <div class="fp-avatar" style="background:{{ $row['bg'] }}">{{ $row['abbr'] }}</div>
                                        <span>{{ $row['name'] }}</span>
                                    </div>
                                    <span style="color:var(--text-mid)">{{ $row['basic'] }}</span>
                                    <span style="color:#22c55e;font-weight:700">{{ $row['net'] }}</span>
                                </div>
                                @endforeach
                            </div>
                            <div style="margin-top:12px;padding-top:10px;border-top:1px solid rgba(255,255,255,0.06);display:flex;justify-content:space-between;align-items:center">
                                <span style="font-size:10px;color:var(--text-dim)">@lang('nova-core::app.features.slides.payroll.preview.total_label')</span>
                                <span style="font-size:16px;font-weight:900;color:#fff">@lang('nova-core::app.features.slides.payroll.preview.total_val')</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 4 -->
                <div class="feat-slide">
                    <div class="feat-left">
                        <div class="feat-tag">@lang('nova-core::app.features.slides.reports.tag')</div>
                        <h3 class="feat-title">@lang('nova-core::app.features.slides.reports.title')</h3>
                        <ul class="feat-list">
                            <li>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                                @lang('nova-core::app.features.slides.reports.items.0')
                            </li>
                            <li>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                @lang('nova-core::app.features.slides.reports.items.1')
                            </li>
                            <li>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/></svg>
                                @lang('nova-core::app.features.slides.reports.items.2')
                            </li>
                        </ul>
                        <div class="feat-btns">
                            <a href="#" class="btn-cta-fill" style="font-size:13px;padding:10px 22px">@lang('nova-core::app.features.btn_detail')</a>
                            <a href="#" class="btn-cta-ghost" style="font-size:13px;padding:10px 22px">@lang('nova-core::app.features.btn_demo')</a>
                        </div>
                    </div>
                    <div class="feat-right">
                        <div class="feat-preview">
                            <div class="fp-header">
                                <span style="font-size:11px;color:var(--text-dim)">@lang('nova-core::app.features.slides.reports.preview.header')</span>
                                <span style="font-size:10px;color:var(--accent);font-weight:600">@lang('nova-core::app.features.slides.reports.preview.period')</span>
                            </div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-top:10px">
                                @foreach(__('nova-core::app.features.slides.reports.preview.stats') as $stat)
                                <div style="background:{{ $stat['bg'] }};border:1px solid {{ $stat['border'] }};border-radius:10px;padding:10px">
                                    <div style="font-size:9px;color:var(--text-dim);margin-bottom:4px">{{ $stat['label'] }}</div>
                                    <div style="font-size:20px;font-weight:900;color:{{ $stat['color'] }}">{{ $stat['value'] }}</div>
                                    <div style="height:3px;background:rgba(255,255,255,0.06);border-radius:10px;margin-top:6px;overflow:hidden">
                                        <div style="width:{{ $stat['pct'] }};height:100%;background:{{ $stat['color'] }};border-radius:10px"></div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Dots -->
            <div class="feat-dots">
                <span class="feat-dot active" data-idx="0" onclick="featGoTo(0)"></span>
                <span class="feat-dot" data-idx="1" onclick="featGoTo(1)"></span>
                <span class="feat-dot" data-idx="2" onclick="featGoTo(2)"></span>
                <span class="feat-dot" data-idx="3" onclick="featGoTo(3)"></span>
            </div>
        </div>
    </div>
</section>