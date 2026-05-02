<div id="tab-subordinates" class="emp-tab-panel" style="display:none">
    <div style="padding:22px 24px">
        <div class="emp-info-card">
            <div class="emp-info-card-head">
                <div class="emp-info-card-title">
                    Nhân viên cấp dưới
                    <span class="emp-table-count" style="margin-left:6px">{{ $employee->subordinates->count() }} người</span>
                </div>
            </div>

            @if($employee->subordinates->isEmpty())
                <div class="emp-empty">
                    <div class="emp-empty-icon">
                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div class="emp-empty-title">Chưa có cấp dưới</div>
                    <div class="emp-empty-desc">Nhân viên này chưa quản lý ai</div>
                </div>
            @else
                <table class="emp-table">
                    <thead>
                        <tr>
                            <th>Nhân viên</th>
                            <th>Phòng ban</th>
                            <th>Vị trí</th>
                            <th>Ngày vào làm</th>
                            <th>Trạng thái</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employee->subordinates as $sub)
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px">
                                    <div class="emp-avatar">
                                        @if($sub->avatar)
                                            <img src="{{ $sub->avatar_url }}" alt="{{ $sub->name }}"/>
                                        @else
                                            {{ strtoupper(substr($sub->first_name,0,1).substr($sub->last_name,0,1)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <div class="emp-table-name">{{ $sub->name }}</div>
                                        <div class="emp-table-code">{{ $sub->employee_code }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="font-size:12.5px;color:#334155;font-weight:600">{{ $sub->department?->name ?? '—' }}</td>
                            <td style="font-size:12.5px;color:#334155">{{ $sub->position?->title ?? '—' }}</td>
                            <td style="font-size:12.5px;color:#475569">{{ $sub->hire_date?->format('d/m/Y') ?? '—' }}</td>
                            <td>
                                @php
                                    $subStClass = match($sub->status) {
                                        'active'    => 'emp-badge-active',
                                        'probation' => 'emp-badge-probation',
                                        default     => 'emp-badge-inactive',
                                    };
                                @endphp
                                <span class="emp-badge {{ $subStClass }}">
                                    <span class="emp-status-dot {{ $sub->is_active ? 'active' : 'inactive' }}"></span>
                                    {{ \Nova\Auth\Models\Employee::STATUSES[$sub->status] ?? $sub->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('hr.employees.show', $sub) }}" class="btn-emp-icon" title="Xem">
                                    <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>