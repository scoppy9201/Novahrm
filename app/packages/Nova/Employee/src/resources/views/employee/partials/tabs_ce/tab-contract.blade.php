{{-- TAB 3: HỢP ĐỒNG - Sau này sẽ chuyển thành hợp đồng builder cho phép soạn thảo tự động--}}
<div id="tab-contract" class="emp-tab-panel" style="display:none;flex-direction:column;gap:14px">
    <div class="emp-form-card">
        <div class="emp-form-card-title">Thông tin hợp đồng</div>
        <div class="emp-form-grid emp-grid-2">

            <div class="emp-form-group">
                <label class="emp-form-label">Loại hợp đồng</label>
                <select name="contract_type" class="emp-select">
                    <option value="">— Chọn loại HĐ —</option>
                    @foreach($contractTypes as $key => $label)
                        <option value="{{ $key }}" {{ old('contract_type', $employee->contract_type ?? '') === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="emp-form-group">
                <label class="emp-form-label">Số hợp đồng</label>
                <input type="text" name="contract_number" class="emp-input"
                        value="{{ old('contract_number', $employee->contract_number ?? '') }}"
                        placeholder="VD: HĐ-2024-001"
                        style="font-family:'Courier New',monospace"/>
            </div>

            <div class="emp-form-group">
                <label class="emp-form-label">Ngày bắt đầu HĐ</label>
                <input type="date" name="contract_start_date" class="emp-input {{ $errors->has('contract_start_date') ? 'error' : '' }}"
                        value="{{ old('contract_start_date', $employee->contract_start_date?->format('Y-m-d') ?? '') }}"/>
                @error('contract_start_date') <span class="emp-field-error">{{ $message }}</span> @enderror
            </div>

            <div class="emp-form-group">
                <label class="emp-form-label">Ngày kết thúc HĐ</label>
                <input type="date" name="contract_end_date" class="emp-input {{ $errors->has('contract_end_date') ? 'error' : '' }}"
                        value="{{ old('contract_end_date', $employee->contract_end_date?->format('Y-m-d') ?? '') }}"/>
                @if(isset($employee) && $employee->is_contract_expiring)
                    <span class="emp-field-error">
                        ⚠ Hợp đồng hết hạn {{ $employee->contract_end_date->diffForHumans() }}
                    </span>
                @endif
                @error('contract_end_date') <span class="emp-field-error">{{ $message }}</span> @enderror
            </div>

            <div class="emp-form-group">
                <label class="emp-form-label">Số lần gia hạn</label>
                <input type="number" name="contract_renewal_count" class="emp-input"
                        value="{{ old('contract_renewal_count', $employee->contract_renewal_count ?? 0) }}" min="0"/>
            </div>
        </div>
    </div>

    <div class="emp-form-card">
        <div class="emp-form-card-title">Tài liệu đính kèm</div>
        <div class="emp-form-grid emp-grid-2">

            <div class="emp-form-group">
                <label class="emp-form-label">Upload CV</label>
                @if(isset($employee) && $employee->cv_path)
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px">
                        <span class="emp-badge emp-badge-blue">
                            <svg viewBox="0 0 24 24" style="width:11px;height:11px;stroke:currentColor;fill:none;stroke-width:2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/></svg>
                            CV đã có
                        </span>
                        <a href="{{ asset('storage/'.$employee->cv_path) }}" target="_blank"
                           style="font-size:11px;color:#1d4ed8;font-weight:600">Xem →</a>
                    </div>
                @endif
                <input type="file" name="cv_path" class="emp-input"
                        accept=".pdf,.doc,.docx" style="padding:6px 10px"/>
                <span class="emp-field-hint">
                    PDF, DOC, DOCX — tối đa 5MB
                    @if(isset($employee) && $employee->cv_path) · Để trống nếu không muốn thay đổi @endif
                </span>
                @error('cv_path') <span class="emp-field-error">{{ $message }}</span> @enderror
            </div>

            <div class="emp-form-group">
                <label class="emp-form-label">Upload chữ ký</label>
                @if(isset($employee) && $employee->signature_path)
                    <div style="margin-bottom:8px">
                        <img src="{{ asset('storage/'.$employee->signature_path) }}"
                             style="height:40px;border:1px solid #e2e8f0;border-radius:6px;padding:4px"/>
                    </div>
                @endif
                <input type="file" name="signature_path" class="emp-input"
                        accept="image/*" style="padding:6px 10px"/>
                <span class="emp-field-hint">
                    JPG, PNG — tối đa 2MB
                    @if(isset($employee) && $employee->signature_path) · Để trống nếu không muốn thay đổi @endif
                </span>
            </div>
        </div>
    </div>
</div>