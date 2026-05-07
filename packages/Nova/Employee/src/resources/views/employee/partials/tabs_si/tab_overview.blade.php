<div id="tab-overview" class="emp-tab-panel emp-show-body" style="display:grid">
    {{-- Sidebar --}}
    <div class="emp-show-side">
        {{-- Avatar card --}}
        <div class="emp-info-card">
            <div style="padding:24px 20px;display:flex;flex-direction:column;align-items:center;gap:10px;border-bottom:1px solid #f1f5f9">
                <div class="emp-avatar-lg">
                    @if($employee->avatar)
                        <img src="{{ $employee->avatar_url }}" alt="{{ $employee->name }}"/>
                    @else
                        {{ strtoupper(substr($employee->first_name,0,1).substr($employee->last_name,0,1)) }}
                    @endif
                </div>
                <div style="font-size:15px;font-weight:900;color:#0f172a;text-align:center">{{ $employee->name }}</div>
                <div style="font-size:11px;color:#2563eb;font-weight:700;text-align:center">
                    {{ $employee->position?->title ?? 'Chưa có vị trí' }}
                </div>
                <div style="font-size:10px;color:#94a3b8;font-weight:700;font-family:'Courier New',monospace;background:#f8fafc;padding:2px 10px;border-radius:5px;border:1px solid #e2e8f0">
                    {{ $employee->employee_code }}
                </div>
                <span class="emp-badge {{ $stClass }}">
                    <span class="emp-status-dot {{ $stDot }}"></span>
                    {{ \Nova\Auth\Models\Employee::STATUSES[$employee->status] ?? $employee->status }}
                </span>
            </div>

            {{-- Meta info --}}
            <div class="emp-info-list">
                @if($employee->department)
                <div class="emp-info-row">
                    <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    <div>
                        <div class="emp-info-label">Phòng ban</div>
                        <div class="emp-info-val">
                            <a href="{{ route('hr.departments.show', $employee->department) }}"
                               style="color:#1d4ed8;text-decoration:none;font-weight:700">
                                {{ $employee->department->name }}
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                @if($employee->manager)
                <div class="emp-info-row">
                    <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <div>
                        <div class="emp-info-label">Quản lý trực tiếp</div>
                        <div class="emp-info-val">
                            <a href="{{ route('hr.employees.show', $employee->manager) }}"
                               style="color:#1d4ed8;text-decoration:none;font-weight:700">
                                {{ $employee->manager->name }}
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                @if($employee->email || $employee->work_email)
                <div class="emp-info-row">
                    <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    <div>
                        <div class="emp-info-label">Email</div>
                        <div class="emp-info-val" style="font-size:11.5px">{{ $employee->work_email ?? $employee->email }}</div>
                    </div>
                </div>
                @endif

                @if($employee->phone)
                <div class="emp-info-row">
                    <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.58 3.32 2 2 0 0 1 3.55 1h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.91 8.54a16 16 0 0 0 6 6l.91-.91a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    <div>
                        <div class="emp-info-label">Điện thoại</div>
                        <div class="emp-info-val">{{ $employee->phone }}</div>
                    </div>
                </div>
                @endif

                @if($employee->hire_date)
                <div class="emp-info-row">
                    <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <div>
                        <div class="emp-info-label">Ngày vào làm</div>
                        <div class="emp-info-val">{{ $employee->hire_date->format('d/m/Y') }}</div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Stat cards --}}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
            <div class="emp-info-card" style="padding:14px;text-align:center">
                <div style="font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.07em;margin-bottom:6px">Thâm niên</div>
                <div style="font-size:16px;font-weight:900;color:#0f172a">{{ $employee->tenure ?? '—' }}</div>
            </div>
            <div class="emp-info-card" style="padding:14px;text-align:center">
                <div style="font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.07em;margin-bottom:6px">Tuổi</div>
                <div style="font-size:16px;font-weight:900;color:#0f172a">{{ $employee->age ? $employee->age . ' tuổi' : '—' }}</div>
            </div>
        </div>

        {{-- Cảnh báo --}}
        @if($employee->is_contract_expiring)
        <div class="emp-alert emp-alert-danger">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <div>
                <div style="font-weight:700;font-size:12px">HĐ sắp hết hạn</div>
                <div style="font-size:11px;margin-top:2px">{{ $employee->contract_end_date->format('d/m/Y') }}</div>
            </div>
        </div>
        @endif

        @if($employee->is_probation_ending)
        <div class="emp-alert emp-alert-warning">
            <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            <div>
                <div style="font-weight:700;font-size:12px">Thử việc sắp kết thúc</div>
                <div style="font-size:11px;margin-top:2px">{{ $employee->probation_end_date->format('d/m/Y') }}</div>
            </div>
        </div>
        @endif
    </div>

    {{-- Main --}}
    <div class="emp-show-main">
        {{-- Thông tin công việc --}}
        <div class="emp-info-card">
            <div class="emp-info-card-head">
                <div class="emp-info-card-title">Thông tin công việc</div>
            </div>
            <div style="padding:16px 18px;display:grid;grid-template-columns:1fr 1fr;gap:16px">

                <div>
                    <div class="emp-info-label">Loại nhân viên</div>
                    <div class="emp-info-val" style="margin-top:4px">
                        <span class="emp-badge emp-badge-blue">
                            {{ \Nova\Auth\Models\Employee::EMPLOYMENT_TYPES[$employee->employment_type] ?? '—' }}
                        </span>
                    </div>
                </div>

                <div>
                    <div class="emp-info-label">Ngày vào làm</div>
                    <div class="emp-info-val" style="margin-top:4px">
                        {{ $employee->hire_date?->format('d/m/Y') ?? '—' }}
                    </div>
                </div>

                @if($employee->probation_start_date || $employee->probation_end_date)
                <div>
                    <div class="emp-info-label">Thời gian thử việc</div>
                    <div class="emp-info-val" style="margin-top:4px">
                        {{ $employee->probation_start_date?->format('d/m/Y') ?? '?' }}
                        →
                        {{ $employee->probation_end_date?->format('d/m/Y') ?? '?' }}
                    </div>
                </div>
                @endif

                @if($employee->official_start_date)
                <div>
                    <div class="emp-info-label">Ngày chính thức</div>
                    <div class="emp-info-val" style="margin-top:4px">{{ $employee->official_start_date->format('d/m/Y') }}</div>
                </div>
                @endif

                @if($employee->basic_salary)
                <div>
                    <div class="emp-info-label">Lương cơ bản</div>
                    <div class="emp-info-val" style="margin-top:4px;font-weight:800;color:#1d4ed8">
                        {{ number_format($employee->basic_salary) }} ₫
                        <span style="font-size:10.5px;color:#94a3b8;font-weight:500">
                            / {{ match($employee->salary_type) { 'daily' => 'ngày', 'hourly' => 'giờ', default => 'tháng' } }}
                        </span>
                    </div>
                </div>
                @endif

                @if(!$employee->is_active && $employee->termination_date)
                <div class="emp-col-full" style="grid-column:1/-1;padding-top:12px;border-top:1px solid #f1f5f9;margin-top:4px">
                    <div class="emp-info-label" style="color:#dc2626">Thông tin nghỉ việc</div>
                    <div style="margin-top:8px;display:flex;gap:16px;flex-wrap:wrap">
                        <div>
                            <div class="emp-info-label">Ngày nghỉ</div>
                            <div class="emp-info-val">{{ $employee->termination_date->format('d/m/Y') }}</div>
                        </div>
                        @if($employee->termination_type)
                        <div>
                            <div class="emp-info-label">Loại</div>
                            <div class="emp-info-val">
                                {{ \Nova\Auth\Models\Employee::TERMINATION_TYPES[$employee->termination_type] ?? $employee->termination_type }}
                            </div>
                        </div>
                        @endif
                        @if($employee->termination_reason)
                        <div style="flex:1;min-width:200px">
                            <div class="emp-info-label">Lý do</div>
                            <div class="emp-info-val">{{ $employee->termination_reason }}</div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Hợp đồng --}}
        @if($employee->contract_type || $employee->contract_number)
        <div class="emp-info-card">
            <div class="emp-info-card-head">
                <div class="emp-info-card-title">Hợp đồng hiện tại</div>
                <a href="#tab-contract" data-goto-tab="tab-contract"
                   style="font-size:11.5px;font-weight:700;color:#1d4ed8;text-decoration:none">
                    Chi tiết →
                </a>
            </div>
            <div style="padding:16px 18px;display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px">

                <div>
                    <div class="emp-info-label">Loại HĐ</div>
                    <div class="emp-info-val" style="margin-top:4px">
                        <span class="emp-badge emp-badge-purple">
                            {{ \Nova\Auth\Models\Employee::CONTRACT_TYPES[$employee->contract_type] ?? '—' }}
                        </span>
                    </div>
                </div>

                @if($employee->contract_number)
                <div>
                    <div class="emp-info-label">Số HĐ</div>
                    <div class="emp-info-val" style="margin-top:4px;font-family:'Courier New',monospace">
                        {{ $employee->contract_number }}
                    </div>
                </div>
                @endif

                @if($employee->contract_start_date || $employee->contract_end_date)
                <div>
                    <div class="emp-info-label">Thời hạn</div>
                    <div class="emp-info-val" style="margin-top:4px">
                        {{ $employee->contract_start_date?->format('d/m/Y') ?? '?' }}
                        →
                        {{ $employee->contract_end_date?->format('d/m/Y') ?? 'Không xác định' }}
                    </div>
                </div>
                @endif
            </div>

            {{-- Progress bar thời gian HĐ --}}
            @if($employee->contract_start_date && $employee->contract_end_date)
                @php
                    $totalDays   = $employee->contract_start_date->diffInDays($employee->contract_end_date);
                    $passedDays  = $employee->contract_start_date->diffInDays(now());
                    $pct         = $totalDays > 0 ? min(100, round($passedDays / $totalDays * 100)) : 0;
                    $remaining   = max(0, now()->diffInDays($employee->contract_end_date, false));
                    $barColor    = $pct >= 90 ? '#ef4444' : ($pct >= 70 ? '#f59e0b' : '#3b82f6');
                @endphp
                <div style="padding:0 18px 16px">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px">
                        <span style="font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.07em">
                            Tiến độ hợp đồng
                        </span>
                        <span style="font-size:12px;font-weight:800;color:{{ $barColor }}">{{ $pct }}%</span>
                    </div>
                    <div style="height:6px;background:#f1f5f9;border-radius:99px;overflow:hidden">
                        <div style="height:100%;width:{{ $pct }}%;background:{{ $barColor }};border-radius:99px;transition:width 0.3s"></div>
                    </div>
                    <div style="display:flex;justify-content:space-between;margin-top:5px">
                        <span style="font-size:11px;color:#94a3b8;font-weight:500">{{ $passedDays }} ngày đã qua</span>
                        @if($remaining > 0)
                            <span style="font-size:11px;font-weight:700;color:{{ $barColor }}">Còn {{ $remaining }} ngày</span>
                        @else
                            <span style="font-size:11px;font-weight:700;color:#dc2626">Đã hết hạn</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
        @endif

        {{-- Bio / Ghi chú --}}
        @if($employee->bio)
        <div class="emp-info-card">
            <div class="emp-info-card-head">
                <div class="emp-info-card-title">Giới thiệu</div>
            </div>
            <div style="padding:14px 18px;font-size:13px;color:#334155;line-height:1.75;white-space:pre-line">
                {{ $employee->bio }}
            </div>
        </div>
        @endif
    </div>
</div>