<div id="tab-documents" class="emp-tab-panel" style="display:none">
    <div style="padding:22px 24px;display:flex;flex-direction:column;gap:14px">

        <div class="emp-info-card">
            <div class="emp-info-card-head">
                <div class="emp-info-card-title">Tài liệu đính kèm</div>
            </div>

            @if(!$employee->cv_path && !$employee->signature_path && !$employee->avatar)
                <div class="emp-empty">
                    <div class="emp-empty-icon">
                        <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    </div>
                    <div class="emp-empty-title">Chưa có tài liệu</div>
                    <div class="emp-empty-desc">Tải lên CV, chữ ký trong trang chỉnh sửa</div>
                    <a href="{{ route('hr.employees.edit', $employee) }}" class="btn-emp-secondary" style="margin-top:8px">
                        Thêm tài liệu
                    </a>
                </div>
            @else
                <div style="padding:16px 18px;display:flex;flex-direction:column;gap:12px">

                    @if($employee->cv_path)
                    <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 14px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px">
                        <div style="display:flex;align-items:center;gap:10px">
                            <div style="width:36px;height:36px;border-radius:8px;background:#eff6ff;display:flex;align-items:center;justify-content:center">
                                <svg viewBox="0 0 24 24" style="width:18px;height:18px;stroke:#1d4ed8;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>
                                </svg>
                            </div>
                            <div>
                                <div style="font-size:12.5px;font-weight:700;color:#0f172a">CV / Hồ sơ</div>
                                <div style="font-size:11px;color:#94a3b8">{{ basename($employee->cv_path) }}</div>
                            </div>
                        </div>
                        <a href="{{ asset('storage/'.$employee->cv_path) }}" target="_blank" class="btn-emp-secondary" style="font-size:11px;padding:5px 12px">
                            Tải xuống
                        </a>
                    </div>
                    @endif

                    @if($employee->signature_path)
                    <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 14px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px">
                        <div style="display:flex;align-items:center;gap:10px">
                            <div style="width:36px;height:36px;border-radius:8px;background:#f5f3ff;display:flex;align-items:center;justify-content:center">
                                <svg viewBox="0 0 24 24" style="width:18px;height:18px;stroke:#7c3aed;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round">
                                    <path d="M12 19l7-7 3 3-7 7-3-3z"/><path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"/>
                                </svg>
                            </div>
                            <div>
                                <div style="font-size:12.5px;font-weight:700;color:#0f172a">Chữ ký</div>
                                <div>
                                    <img src="{{ asset('storage/'.$employee->signature_path) }}"
                                         style="height:32px;margin-top:4px;border:1px solid #e2e8f0;border-radius:4px;padding:2px"/>
                                </div>
                            </div>
                        </div>
                        <a href="{{ asset('storage/'.$employee->signature_path) }}" target="_blank" class="btn-emp-secondary" style="font-size:11px;padding:5px 12px">
                            Xem
                        </a>
                    </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>