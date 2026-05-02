<div class="emp-modal-overlay" id="terminate-modal">
    <div class="emp-modal">
        <div class="emp-modal-header">
            <div class="emp-modal-title">Xác nhận nghỉ việc — {{ $employee->name }}</div>
            <button type="button" class="emp-modal-close" id="close-terminate">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('hr.employees.terminate', $employee) }}">
            @csrf
            <div class="emp-modal-body">
                <div class="emp-alert emp-alert-warning">
                    <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    Hành động này sẽ đánh dấu nhân viên là đã nghỉ việc.
                </div>
                <div class="emp-form-group">
                    <label class="emp-form-label">Loại nghỉ việc <span class="required">*</span></label>
                    <select name="status" class="emp-select" required>
                        <option value="resigned">Tự nghỉ việc</option>
                        <option value="terminated">Bị sa thải</option>
                        <option value="retired">Nghỉ hưu</option>
                        <option value="deceased">Qua đời</option>
                    </select>
                </div>
                <div class="emp-form-group">
                    <label class="emp-form-label">Loại hình chấm dứt <span class="required">*</span></label>
                    <select name="termination_type" class="emp-select" required>
                        @foreach(\Nova\Auth\Models\Employee::TERMINATION_TYPES as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="emp-form-group">
                    <label class="emp-form-label">Ngày nghỉ việc <span class="required">*</span></label>
                    <input type="date" name="termination_date" class="emp-input"
                           value="{{ now()->format('Y-m-d') }}" required/>
                </div>
                <div class="emp-form-group">
                    <label class="emp-form-label">Lý do</label>
                    <textarea name="termination_reason" class="emp-textarea" rows="3"
                              placeholder="Mô tả lý do nghỉ việc..."></textarea>
                </div>
            </div>
            <div class="emp-modal-footer">
                <button type="button" class="btn-emp-secondary" id="cancel-terminate">Huỷ</button>
                <button type="submit" class="btn-emp-danger">
                    <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Xác nhận nghỉ việc
                </button>
            </div>
        </form>
    </div>
</div>

<div class="emp-modal-overlay" id="terminate-modal">
    <div class="emp-modal">
        <div class="emp-modal-header">
            <div class="emp-modal-title">Xác nhận nghỉ việc — {{ $employee->name }}</div>
            <button type="button" class="emp-modal-close" id="close-terminate">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <form method="POST" action="{{ route('hr.employees.terminate', $employee) }}">
            @csrf
            <div class="emp-modal-body">

                <div class="emp-alert emp-alert-warning" style="margin-bottom:4px">
                    <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    Hành động này sẽ đánh dấu nhân viên là đã nghỉ việc.
                </div>

                <div class="emp-form-group">
                    <label class="emp-form-label">Loại nghỉ việc <span class="required">*</span></label>
                    <select name="status" class="emp-select" required>
                        <option value="resigned">Tự nghỉ việc</option>
                        <option value="terminated">Bị sa thải</option>
                        <option value="retired">Nghỉ hưu</option>
                        <option value="deceased">Qua đời</option>
                    </select>
                </div>

                <div class="emp-form-group">
                    <label class="emp-form-label">Loại hình chấm dứt <span class="required">*</span></label>
                    <select name="termination_type" class="emp-select" required>
                        @foreach(\Nova\Auth\Models\Employee::TERMINATION_TYPES as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="emp-form-group">
                    <label class="emp-form-label">Ngày nghỉ việc <span class="required">*</span></label>
                    <input type="date" name="termination_date" class="emp-input"
                           value="{{ now()->format('Y-m-d') }}" required/>
                </div>

                <div class="emp-form-group">
                    <label class="emp-form-label">Lý do</label>
                    <textarea name="termination_reason" class="emp-textarea" rows="3"
                              placeholder="Mô tả lý do nghỉ việc..."></textarea>
                </div>

            </div>

            <div class="emp-modal-footer">
                <button type="button" class="btn-emp-secondary" id="cancel-terminate">Huỷ</button>
                <button type="submit" class="btn-emp-danger">
                    <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Xác nhận nghỉ việc
                </button>
            </div>
        </form>
    </div>
</div>