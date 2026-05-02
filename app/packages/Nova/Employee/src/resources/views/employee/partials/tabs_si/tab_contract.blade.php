<div id="tab-contract" class="emp-tab-panel" style="display:none">
    <div style="padding:22px 24px;display:flex;flex-direction:column;gap:14px">

        <div class="emp-info-card">
            <div class="emp-info-card-head">
                <div class="emp-info-card-title">Chi tiết hợp đồng</div>
                <a href="{{ route('hr.employees.edit', $employee) }}#tab-contract"
                   class="btn-emp-secondary" style="font-size:11px;padding:5px 12px">
                    Chỉnh sửa
                </a>
            </div>
            <div style="padding:16px 18px;display:grid;grid-template-columns:repeat(3,1fr);gap:16px">

                <div>
                    <div class="emp-info-label">Loại hợp đồng</div>
                    <div class="emp-info-val" style="margin-top:4px">
                        @if($employee->contract_type)
                            <span class="emp-badge emp-badge-purple">
                                {{ \Nova\Auth\Models\Employee::CONTRACT_TYPES[$employee->contract_type] ?? $employee->contract_type }}
                            </span>
                        @else
                            <span style="color:#94a3b8">Chưa có</span>
                        @endif
                    </div>
                </div>

                <div>
                    <div class="emp-info-label">Số hợp đồng</div>
                    <div class="emp-info-val" style="margin-top:4px;font-family:'Courier New',monospace">
                        {{ $employee->contract_number ?? '—' }}
                    </div>
                </div>

                <div>
                    <div class="emp-info-label">Số lần gia hạn</div>
                    <div class="emp-info-val" style="margin-top:4px">{{ $employee->contract_renewal_count ?? 0 }} lần</div>
                </div>

                <div>
                    <div class="emp-info-label">Ngày bắt đầu</div>
                    <div class="emp-info-val" style="margin-top:4px">{{ $employee->contract_start_date?->format('d/m/Y') ?? '—' }}</div>
                </div>

                <div>
                    <div class="emp-info-label">Ngày kết thúc</div>
                    <div class="emp-info-val" style="margin-top:4px">
                        {{ $employee->contract_end_date?->format('d/m/Y') ?? 'Không xác định' }}
                        @if($employee->is_contract_expiring)
                            <div style="margin-top:4px">
                                <span class="emp-badge emp-badge-danger" style="font-size:10px">
                                    Hết hạn {{ $employee->contract_end_date->diffForHumans() }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Lương & Tài chính --}}
        <div class="emp-info-card">
            <div class="emp-info-card-head">
                <div class="emp-info-card-title">Lương & Tài chính</div>
            </div>
            <div style="padding:16px 18px;display:grid;grid-template-columns:repeat(3,1fr);gap:16px">

                <div style="grid-column:1/-1;padding:14px;background:#eff6ff;border-radius:10px;border:1px solid #dbeafe;text-align:center">
                    <div style="font-size:10px;font-weight:700;color:#1d4ed8;text-transform:uppercase;letter-spacing:0.07em;margin-bottom:4px">Lương cơ bản</div>
                    <div style="font-size:22px;font-weight:900;color:#1d4ed8">
                        {{ $employee->basic_salary ? number_format($employee->basic_salary) . ' ₫' : '—' }}
                    </div>
                    <div style="font-size:11px;color:#93c5fd;margin-top:2px">
                        / {{ match($employee->salary_type ?? 'monthly') { 'daily' => 'ngày', 'hourly' => 'giờ', default => 'tháng' } }}
                    </div>
                </div>

                <div>
                    <div class="emp-info-label">Ngân hàng</div>
                    <div class="emp-info-val" style="margin-top:3px">{{ $employee->bank_name ?? '—' }}</div>
                </div>
                <div>
                    <div class="emp-info-label">Số tài khoản</div>
                    <div class="emp-info-val" style="margin-top:3px;font-family:'Courier New',monospace">{{ $employee->bank_account ?? '—' }}</div>
                </div>
                <div>
                    <div class="emp-info-label">Tên chủ TK</div>
                    <div class="emp-info-val" style="margin-top:3px">{{ $employee->bank_account_name ?? '—' }}</div>
                </div>
                <div>
                    <div class="emp-info-label">Mã số thuế</div>
                    <div class="emp-info-val" style="margin-top:3px;font-family:'Courier New',monospace">{{ $employee->tax_code ?? '—' }}</div>
                </div>
                <div>
                    <div class="emp-info-label">Mã BHXH</div>
                    <div class="emp-info-val" style="margin-top:3px;font-family:'Courier New',monospace">{{ $employee->social_insurance_code ?? '—' }}</div>
                </div>
                <div>
                    <div class="emp-info-label">Mã BHYT</div>
                    <div class="emp-info-val" style="margin-top:3px;font-family:'Courier New',monospace">{{ $employee->health_insurance_code ?? '—' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>